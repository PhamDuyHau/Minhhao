<?php

/**
 * Template Name: Cooperate
 * Template Post Type: page
 * The template for displaying the cooperate page using ACF Flexible Content.

 * @author Hau
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part(slug: 'template-part/block/breadcrumbs');

// Load flexible content
$flexible_content = get_field('cooperate_flexible_content');

if ($flexible_content && is_array($flexible_content)) {
    foreach ($flexible_content as $section) {
        $layout = $section['acf_fc_layout'] ?? '';

        if ($layout) {
            get_template_part('template-part/cooperate/' . $layout, null, $section);
        }
    }
} else {
    echo '<p class="text-center text-gray-600 py-10">Please add content blocks to the "Factory Flexible Content" field.</p>';
}

get_footer();
