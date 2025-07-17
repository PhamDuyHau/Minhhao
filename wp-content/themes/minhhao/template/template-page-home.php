<?php
/**
 * Template Name: Home
 * Template Post Type: page
 *
 * The template for displaying the homepage using ACF Flexible Content.
 * 
 * @author Hau
 */
defined( 'ABSPATH' ) || exit;
get_header();

// Load flexible content
$flexible_content = get_field('home_flexible_content');

if ($flexible_content && is_array($flexible_content)) {
    foreach ($flexible_content as $section) {
        $layout = $section['acf_fc_layout'] ?? '';

        if ($layout) {
            get_template_part('template-part/home/' . $layout, null, $section);
        }
    }
} else {
    echo '<p class="text-center text-gray-600 py-10">Please add content blocks to the "Home Flexible Content" field.</p>';
}

get_footer();
