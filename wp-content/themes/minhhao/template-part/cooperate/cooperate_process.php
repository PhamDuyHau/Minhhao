<?php
defined( 'ABSPATH' ) || exit;
$main_title = $args['process_title'] ?? '';
$steps = $args['process_step'] ?? [];
$notes = $args['process_notes_between'] ?? [];
?>

<?php if (!empty($steps)): ?>
<section class="py-16 bg-[#E7292B]" aria-labelledby="cooperate-process-title">
    <div class="max-w-7xl mx-auto px-4 space-y-12">
        <h1 id="cooperate-process-title"
            class="text-2xl md:text-3xl lg:text-4xl font-bold uppercase text-white text-center fade-up">
            <?= wp_kses_post($main_title) ?>
        </h1>

        <!-- Steps Section -->
        <div class="fade-up delay-3s">
            <!-- Desktop Layout -->
            <div class="hidden md:flex justify-center items-center flex-nowrap lg:flex-wrap">
                <?php foreach ($steps as $index => $step): 
                    $icon = $step['icon'] ?? '';
                    $title = $step['title'] ?? '';
                ?>
                    <!-- Step Box -->
                    <div class="w-36 md:w-[180px] lg:w-[200px] h-[200px] bg-white rounded-xl shadow-lg flex flex-col items-center justify-center text-center p-4">
                        <?php if ($icon): ?>
                            <div class="w-16 h-16 rounded-full bg-[#E7292B] flex items-center justify-center mb-4">
                                <?= wp_get_attachment_image($icon, 'thumbnail', false, ['class' => 'w-8 h-8']); ?>
                            </div>
                        <?php endif; ?>
                        <p class="text-[#E7292B] font-semibold text-sm"><?= esc_html($title); ?></p>
                    </div>

                    <!-- Line with optional note -->
                    <?php if ($index < count($steps) - 1): ?>
                        <div class="flex flex-col items-center relative w-16">
                            <?php if (!empty($notes[$index]['note'])): ?>
                                <span class="absolute hidden lg:inline -top-6 text-white text-xs whitespace-nowrap">
                                    <?= esc_html($notes[$index]['note']); ?>
                                </span>
                            <?php endif; ?>
                            <div class="w-full h-1 bg-white"></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Mobile Grid -->
            <div class="grid grid-cols-2 gap-6 md:hidden">
                <?php foreach ($steps as $step): ?>
                    <div class="flex flex-col items-center text-center bg-white p-4 rounded-xl shadow-lg">
                        <div class="w-16 h-16 rounded-full bg-[#E7292B] flex items-center justify-center mb-2">
                            <?= wp_get_attachment_image($step['icon'], 'thumbnail', false, ['class' => 'w-8 h-8']); ?>
                        </div>
                        <p class="text-[#E7292B] font-semibold text-sm mb-1"><?= esc_html($step['title']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
