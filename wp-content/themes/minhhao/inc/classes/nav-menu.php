<?php
defined('ABSPATH') || exit;

class Walker_Nav_Menu_Custom extends Walker_Nav_Menu
{
  private $menu_index = 0;

  public function start_lvl(&$output, $depth = 0, $args = [], $id = 0)
  {
    $dropdown_id = 'dropdown' . $this->menu_index;
    $output .= "\n<div id=\"$dropdown_id\" class=\"dropdown hidden group-hover:block absolute w-64 space-y-2 z-20 bg-white shadow  rounded transition-all duration-300\">\n";
  }

  public function end_lvl(&$output, $depth = 0, $args = [], $id = 0)
  {
    $output .= "</div>\n";
  }

  public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
  {
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $has_children = in_array('menu-item-has-children', $classes);
    $title = apply_filters('the_title', $item->title, $item->ID);
    $url = esc_url($item->url);
    $target = $item->target ? " target=\"{$item->target}\"" : '';
    $rel = $item->xfn ? " rel=\"{$item->xfn}\"" : '';
    $dropdown_id = 'dropdown' . $this->menu_index;
    $button_id = 'dropdownButton' . $this->menu_index;

    // 🖼️ Optional thumbnail for sub-items under /san-pham/
    $image_url = '';
    if ($depth > 0 && strpos($url, '/san-pham/') !== false) {
      $parsed_url = wp_parse_url($url);
      $slug = isset($parsed_url['path']) ? basename(trim($parsed_url['path'], '/')) : '';
      $term = get_term_by('slug', $slug, 'product_cat');
      if ($term && !is_wp_error($term)) {
        $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
        if ($thumbnail_id) {
          $image_url = wp_get_attachment_url($thumbnail_id);
        }
      }
    }

    if ($depth === 0) {
      $output .= '<li class="relative group">' . "\n";

      $output .= "<a href=\"$url\"$target$rel class=\"flex items-center uppercase font-semibold group-hover:text-[#E7292B] transition duration-300\">";
      $output .= "<span class=\"hover:text-[#E7292B] hover:underline decoration-2 underline-offset-2 transition-colors duration-300 cursor-pointer\">$title</span>";
      if ($has_children) {
        $output .= "<i class=\"fas fa-chevron-right ml-2 transform transition-transform duration-300 group-hover:rotate-90\"></i>";
      }
      $output .= "</a>\n";
    } else {
      // Submenu item
      $output .= "<a href=\"$url\"$target$rel class=\"flex items-center h-16 space-x-3 px-3 hover:bg-[#E7292B] border border-gray-200 rounded transition-all duration-300\">";
      if ($image_url) {
        $output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" class="w-16 h-16 object-contain">';
      }
      $output .= '<span class="hover:text-white font-semibold block w-full">' . esc_html($title) . '</span>';
      $output .= '</a>';
    }
  }

  public function end_el(&$output, $item, $depth = 0, $args = [])
  {
    if ($depth === 0) {
      $output .= "</li>\n";
      $this->menu_index++;
    }
  }
}


class Footer_Icon_Walker extends Walker_Nav_Menu
{
  public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
  {
    $classes = implode(' ', $item->classes ?? []);
    $title = apply_filters('the_title', $item->title, $item->ID);
    $url = esc_url($item->url);

    $output .= '<li class="flex items-center gap-2">';
    $output .= '<i class="fa-solid fa-angle-right text-[#E7292B] text-xs"></i>';
    $output .= '<a href="' . $url . '" class="hover:underline">' . esc_html($title) . '</a>';
    $output .= '</li>';
  }
}

class Walker_Mobile_Menu extends Walker_Nav_Menu
{
  private int $menu_index = 0;

  public function start_lvl(&$output, $depth = 0, $args = null)
  {
    $dropdown_id = 'mobileDropdown' . $this->menu_index;

    $output .= sprintf(
      '<ul id="%s" class="ml-4 max-h-0 overflow-hidden transition-all duration-500 ease-in-out flex-col space-y-2 text-white text-sm pl-2 border-l-2 border-[#FFCD27]">',
      esc_attr($dropdown_id)
    );
  }

  public function end_lvl(&$output, $depth = 0, $args = null)
  {
    $output .= '</ul>';
  }

  public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $has_children = in_array('menu-item-has-children', $item->classes ?? []);
    $title = apply_filters('the_title', $item->title, $item->ID);
    $url = !empty($item->url) ? esc_url($item->url) : '#';

    if ($depth === 0) {
      $output .= '<li>';

      if ($has_children) {
        $this->menu_index++;
        $button_id = 'mobileDropdownButton' . $this->menu_index;
        $dropdown_id = 'mobileDropdown' . $this->menu_index;

        $output .= sprintf(
          '<button id="%s" aria-expanded="false" aria-controls="%s" class="w-full flex justify-between items-center hover:text-[#E7292B] transition-colors focus:outline-none uppercase">
						%s
						<svg class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
						</svg>
					</button>',
          esc_attr($button_id),
          esc_attr($dropdown_id),
          esc_html($title)
        );
      } else {
        $output .= sprintf(
          '<a href="%s" class="hover:text-[#E7292B] transition-colors">%s</a>',
          $url,
          esc_html($title)
        );
      }
    } else {
      // Sub-menu items
      $output .= sprintf(
        '<li><a href="%s" class="hover:text-[#E7292B] transition-colors">%s</a></li>',
        $url,
        esc_html($title)
      );
    }
  }

  public function end_el(&$output, $item, $depth = 0, $args = null)
  {
    if ($depth === 0) {
      $output .= '</li>';
    }
  }
}
