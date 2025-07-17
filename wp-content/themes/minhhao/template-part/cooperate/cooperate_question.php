<?php
defined( 'ABSPATH' ) || exit;
/**
 * FAQ Section (Câu hỏi thường gặp)
 * @param array $args ACF data passed from the flexible content field.
 */
$main_title = $args['cooperate_title'] ?? '';
$faq_items = $args['faq_items'] ?? [];
?>

<?php if (!empty($faq_items)): ?>
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4">
        <h1 id="faq-title"
            class="text-2xl md:text-3xl lg:text-4xl font-bold uppercase text-[#E7292B] text-center mb-8 fade-up">
            <?= wp_kses_post($main_title) ?>
        </h1>

        <div class="space-y-4 fade-up delay-2s">
            <?php foreach ($faq_items as $item): ?>
                <div class="border border-[#E7292B] rounded overflow-hidden">
                    <button
                        class="accordion-header w-full flex justify-between items-center px-6 py-4 bg-[#E7292B] text-white font-semibold text-left cursor-pointer">
                        <span><?= esc_html($item['question']); ?></span>
                        <i class="fa-solid fa-play transform transition-transform duration-300"></i>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden bg-white text-black px-6 transition-[max-height] duration-500 ease-in-out">
                        <div class="py-4">
                            <?= wp_kses_post($item['answer']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
