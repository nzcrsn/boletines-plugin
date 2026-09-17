<?php

/** @var WP_Query $query */
?>
<section class="latest-newsletter">
    <div class="newsletter-header">
        <h2 class="heading">Boletín más reciente</h2>
        <p class="supporting-text">Descarga el último boletín</p>
    </div>

    <div class="latest-newsletter-container">
        <?php
        while ($query->have_posts()) :
            $query->the_post();
            if (function_exists('get_field')) {
                $source = get_field('source');
                $thumbnail = get_field('thumbnail');
            }
        ?>


            <a
                type="button"
                class="latest-newsletter-item"
                href="<?= esc_url($source); ?>"
                target="_blank"
                rel="noopener noreferrer">
                <img
                    src="<?= esc_url($thumbnail); ?>"
                    alt="<?= esc_attr(get_the_title()); ?>">


            </a>

            <div class="latest-newsletter-item-icon-container">
                <a
                    type="button"
                    href="<?= esc_url($source); ?>"
                    target="_blank"
                    rel="noopener noreferrer">
                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.757 16.243 L16.243 7.757 M16.243 7.757 L9.172 7.757 M16.243 7.757 L16.243 14.828"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>

        <?php endwhile; ?>
    </div>
</section>