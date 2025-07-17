<?php
defined('ABSPATH') || exit;

class Theme_Footer
{
    public function __construct()
    {
        add_action('theme_footer', [$this, 'render_footer_open'], 10);
        add_action('theme_footer', [$this, 'render_footer_left'], 20);
        add_action('theme_footer', [$this, 'render_footer_middle'], 30);
        add_action('theme_footer', [$this, 'render_footer_right'], 40);
        add_action('theme_footer', [$this, 'render_footer_bottom'], 50);
        add_action('theme_footer', [$this, 'render_footer_close'], 100);
    }

    public function render_footer_open()
    {
        $is_home_template = is_page_template('template/template-page-home.php');
        $is_shop = is_shop();
        $is_tax_product_cat = is_tax('product_cat');
        $is_single_product = is_product(); // ✅ Detect single product page

        // ✅ Detect default page
        $is_default_page = (is_page() && !is_page_template()) || is_cart() || is_checkout();

        // ✅ Decide gradient color
        if ($is_single_product) {
            $gradient_color = '#F3F3F3'; // ✅ Your desired color for single product
        } elseif ($is_tax_product_cat || $is_shop) {
            $gradient_color = '#FFF4EC';
        } elseif ($is_default_page) {
            $gradient_color = '#FFEECF';
        } else {
            $gradient_color = 'white';
        }

        echo '<!-- Footer -->';
        echo '<footer class="relative py-4 sm:py-12 px-6 ' . ($is_home_template ? 'text-black custom-footer' : 'text-gray-700') . '"';

        if (!$is_home_template) {
            $svg = "url('data:image/svg+xml,%3csvg%20width=\'1728\'%20height=\'670\'%20viewBox=\'0%200%201728%20670\'%20fill=\'none\'%20xmlns=\'http://www.w3.org/2000/svg\'%3e%3cpath%20d=\'M0%203.18452C18.7738%20-4.30954%2044.9488%202.28162%2073.1094%2014.0193C112.191%2030.2715%20156.599%2040.9257%20205.789%2030.2715C295.236%2010.8592%20388.924%2013.8387%20495.519%2062.7759C604.823%20112.977%20732.358%20129.771%20870.995%2091.6686C1020.64%2050.4964%201146.46%2038.9393%201256.4%2086.2512C1330.77%20118.214%201422.93%20114.512%201517.7%20103.858C1614.36%2093.023%201701.55%2083.4523%201728%2099.3433V670.486H0.451293L0%203.18452Z\'%20fill=\'%23FFEECF\'/%3e%3c/svg%3e')";
            echo ' style="background-image: ' . $svg . ', linear-gradient(' . esc_attr($gradient_color) . '); background-repeat: no-repeat, no-repeat; background-position: center, 0 0; background-size: cover, cover;"';
        }

        echo '>';
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto mt-32">';
    }

    public function render_footer_left()
    {
        $footer_left = get_field('footer_group_left', 'option');
        $footer_image_id = $footer_left['footer_image'] ?? false;
        $footer_image_url = $footer_image_id ? wp_get_attachment_url($footer_image_id) : '';

        echo '<div class="w-full flex flex-col items-start gap-6">';

        if ($footer_image_url) {
            echo '<img src="' . esc_url($footer_image_url) . '" alt="Footer Image" class="w-full max-w-[200px] md:max-w-[260px] lg:max-w-[286px] h-auto object-contain rounded-md" />';
        }

        echo '<ul class="flex flex-wrap justify-start gap-1 sm:gap-2 md:gap-4 text-white text-lg">';

        $socials = ['facebook', 'youtube', 'instagram', 'twitter', 'zalo'];
        foreach ($socials as $name) {
            $link = $footer_left["link_$name"] ?? null;
            if (!empty($link['url'])) {
                echo '<li>';
                echo '<a href="' . esc_url($link['url']) . '" target="_blank" class="bg-[#CB1908] w-12 h-12 p-3 rounded-md flex items-center justify-center hover:opacity-75">';
                if ($name === 'zalo') {
                    echo '<img src="' . get_stylesheet_directory_uri() . '/dist/assets/zalo-icon-DLaycxUz.svg" alt="Zalo Icon" />';
                } else {
                    echo '<i class="fab fa-' . esc_attr($name) . '"></i>';
                }
                echo '</a>';
                echo '</li>';
            }
        }

        echo '</ul>';
        echo '</div>';
    }


    public function render_footer_middle()
    {
        $footer_map_link = get_field('footer_map_link', 'option');

        echo '<div class="w-full">';

        if (have_rows('footer_menu_items', 'option')) {
            while (have_rows('footer_menu_items', 'option')) {
                the_row();
                $main_title = get_sub_field('main_title');
                $menu_object = get_sub_field('link_menu'); // ACF returns menu object

                if ($main_title && $menu_object && isset($menu_object->ID)) {
                    echo '<div class="mb-8">';
                    echo '<h1 class="text-[#E7292B] text-lg font-bold mb-4 uppercase">' . esc_html($main_title) . '</h1>';

                    wp_nav_menu([
                        'menu'         => $menu_object->ID,
                        'container'    => false,
                        'menu_class'   => 'space-y-2 font-medium',
                        'items_wrap'   => '<ul class="%2$s">%3$s</ul>',
                        'depth'        => 1,
                        'fallback_cb'  => false,
                        'link_before'  => '<span class="flex items-center gap-2"><i class="fa-solid fa-angle-right"></i>',
                        'link_after'   => '</span>',
                    ]);

                    echo '</div>';
                }
            }
        }

        if (!empty($footer_map_link['url'])) {
            echo '<div class="flex items-center gap-2 transition-colors mt-4">';
            echo '<i class="fa-solid fa-location-dot text-[#E7292B]"></i>';
            echo '<a href="' . esc_url($footer_map_link['url']) . '" class="text-[#E7292B] font-medium hover:underline" target="' . esc_attr($footer_map_link['target'] ?? '_self') . '">';
            echo esc_html($footer_map_link['title'] ?? '');
            echo '</a>';
            echo '</div>';
        }

        echo '</div>';
    }


    public function render_footer_right()
    {
        $footer_right = get_field('footer_group_right', 'option');

        echo '<div class="w-full md:col-span-2 md:row-span-2 lg:col-span-1 lg:row-auto">';

        echo '<div>';
        if (!empty($footer_right['contact_main_title'])) {
            echo '<h1 class="text-[#E7292B] text-lg font-bold mb-2 uppercase">' . esc_html($footer_right['contact_main_title']) . '</h1>';
        }

        if (!empty($footer_right['contact_description'])) {
            echo '<div class="space-y-3 text-sm">' . wpautop($footer_right['contact_description']) . '</div>';
        }
        echo '</div>';

        echo '<div class="mt-8">';
        if (!empty($footer_right['sign_in_main_title'])) {
            echo '<h1 class="text-[#E7292B] text-lg font-bold uppercase mb-2">' . esc_html($footer_right['sign_in_main_title']) . '</h1>';
        }

        if (!empty($footer_right['sign_in_description'])) {
            echo '<p class="text-[#1C1C1C] font-medium mb-4">' . wpautop($footer_right['sign_in_description']) . '</p>';
        }

        echo do_shortcode('[fluentform id="5"]');
        echo '</div>';

        echo '</div>';
    }


    public function render_footer_bottom()
    {
        echo '</div>'; // ✅ Close grid from render_footer_open()

        $group = get_field('copyright_group', 'option');
        $company = $group['company_name'] ?? '';
        $year = $group['copyright_year'] ?? '';
        $agency_link = $group['agency_link'] ?? null;
        $terms_link = $group['terms_link'] ?? null;
        $privacy_link = $group['privacy_link'] ?? null;

        echo '<div class="mt-4 pt-4 pb-6 text-sm text-black max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">';

        // Left side
        echo '<p class="text-center sm:text-left">';
        echo 'Copyright ' . esc_html($year) . ' ';
        echo '<strong>' . esc_html($company) . '</strong>.';

        if ($agency_link) {
            echo ' Powered by ';
            echo '<a href="' . esc_url($agency_link['url']) . '" target="' . esc_attr($agency_link['target'] ?? '_self') . '" class="font-semibold text-[#E7292B] hover:underline">';
            echo esc_html($agency_link['title']);
            echo '</a>';
        }

        echo '</p>';

        // Right side
        echo '<p class="text-center sm:text-right">';
        if ($terms_link) {
            echo '<a href="' . esc_url($terms_link['url']) . '" target="' . esc_attr($terms_link['target'] ?? '_self') . '" class="hover:underline">';
            echo esc_html($terms_link['title']);
            echo '</a>';
        }

        if ($terms_link && $privacy_link) {
            echo ' | ';
        }

        if ($privacy_link) {
            echo '<a href="' . esc_url($privacy_link['url']) . '" target="' . esc_attr($privacy_link['target'] ?? '_self') . '" class="hover:underline">';
            echo esc_html($privacy_link['title']);
            echo '</a>';
        }

        echo '</p>';
        echo '</div>';
    }

    public function render_footer_close()
    {
        echo '</footer>';
        wp_footer();
        echo '</body></html>';
    }
}
