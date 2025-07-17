<?php
defined( 'ABSPATH' ) || exit;
/**
 * Template Part - Home » Video File
 *
 * Expected $args:
 * - home_video_file (file URL or ID, ideally a .mp4 video)
 *
 * @param array $args Passed from flexible content or get_field.
 */

$video_id = $args['home_video_file'] ?? null;
$video_url = $video_id ? wp_get_attachment_url($video_id) : '';

if (empty($video_url)) return;
?>

<section id="videoSection" class="relative w-screen aspect-[4/3] md:aspect-video overflow-hidden cursor-pointer">

  <!-- Background Video -->
  <video id="heroVideo" muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
    <source src="<?= esc_url($video_url) ?>" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <!-- Top Wave SVG -->
  <img src="data:image/svg+xml,%3csvg%20id='visual'%20viewBox='0%200%20900%20600'%20width='900'%20height='600'%20xmlns='http://www.w3.org/2000/svg'%20xmlns:xlink='http://www.w3.org/1999/xlink'%20version='1.1'%3e%3cpath%20d='M0%2028L21.5%2034.7C43%2041.3%2086%2054.7%20128.8%2057.3C171.7%2060%20214.3%2052%20257.2%2054.8C300%2057.7%20343%2071.3%20385.8%2067.2C428.7%2063%20471.3%2041%20514.2%2036.3C557%2031.7%20600%2044.3%20642.8%2053.8C685.7%2063.3%20728.3%2069.7%20771.2%2065.5C814%2061.3%20857%2046.7%20878.5%2039.3L900%2032L900%200L878.5%200C857%200%20814%200%20771.2%200C728.3%200%20685.7%200%20642.8%200C600%200%20557%200%20514.2%200C471.3%200%20428.7%200%20385.8%200C343%200%20300%200%20257.2%200C214.3%200%20171.7%200%20128.8%200C86%200%2043%200%2021.5%200L0%200Z'%20fill='%23FFEECF'%20stroke-linecap='round'%20stroke-linejoin='miter'%3e%3c/path%3e%3c/svg%3e"
    alt="Top Wave"
    class="absolute top-0 left-0 w-full h-auto pointer-events-none select-none z-1" />

  <!-- Bottom Wave SVG -->
  <img src="data:image/svg+xml,%3csvg%20id='visual'%20viewBox='0%200%20900%20600'%20width='900'%20height='600'%20xmlns='http://www.w3.org/2000/svg'%20xmlns:xlink='http://www.w3.org/1999/xlink'%20version='1.1'%3e%3cpath%20d='M0%20557L21.5%20555.2C43%20553.3%2086%20549.7%20128.8%20545.7C171.7%20541.7%20214.3%20537.3%20257.2%20540.3C300%20543.3%20343%20553.7%20385.8%20559.7C428.7%20565.7%20471.3%20567.3%20514.2%20556.8C557%20546.3%20600%20523.7%20642.8%20516.3C685.7%20509%20728.3%20517%20771.2%20517.3C814%20517.7%20857%20510.3%20878.5%20506.7L900%20503L900%20601L878.5%20601C857%20601%20814%20601%20771.2%20601C728.3%20601%20685.7%20601%20642.8%20601C600%20601%20557%20601%20514.2%20601C471.3%20601%20428.7%20601%20385.8%20601C343%20601%20300%20601%20257.2%20601C214.3%20601%20171.7%20601%20128.8%20601C86%20601%2043%20601%2021.5%20601L0%20601Z'%20fill='%23FFFFFF'%20stroke-linecap='round'%20stroke-linejoin='miter'%3e%3c/path%3e%3c/svg%3e"
    alt="Bottom Wave"
    class="absolute -bottom-1 left-0 w-full h-auto pointer-events-none select-none z-1" />

  <!-- Center Play Button -->
  <div id="playButtonWrapper" class="absolute inset-0 flex items-center justify-center bg-black/20 transition-opacity duration-300">
    <!-- Pulse Ring -->
    <span class="pulse-ring"></span>
    <button id="playButton"
      class="w-[77px] h-[77px] rounded-full bg-white border-4 border-white flex items-center justify-center hover:scale-105 transition-transform duration-300"
      aria-label="Play">
      <!-- Play Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" class="w-6 h-6 ml-1">
        <path d="M5 3v18l15-9L5 3z" />
      </svg>
    </button>
  </div>

</section>
