<?php
$main_categories = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => true,
]);

if (!empty($main_categories)) :
?>
    <div class="flex flex-wrap gap-4 justify-center mb-8">
        <?php foreach ($main_categories as $cat): ?>
            <a href="<?= esc_url(get_term_link($cat)); ?>"
               class="category-btn opacity-80 hover:opacity-100 transition font-semibold">
                <?= esc_html($cat->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
