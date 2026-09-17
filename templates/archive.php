<?php

/** @var WP_Query $query */
?>

<section class="previous-newsletters">
    <header class="newsletter-header">
        <h2 class="heading">Boletines de meses anteriores</h2>
        <p class="supporting-text"> Descarga el boletín del mes que prefieras de este año.</p>
    </header>

    <div class="arrow-navigation">

        <svg id="arrow-left" class="arrow left disabled" width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <svg id="arrow-right" class="arrow right" width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

    </div>

    <div id="newsletters-container" class="newsletters-container">
        <?php
        $num_item = 1;
        while ($query->have_posts()) :
            $query->the_post();
            if (function_exists('get_field')) {
                $source = get_field('source');
                $thumbnail = get_field('thumbnail');
            }

        ?>

            <div nl="<?= esc_attr($num_item) ?>" id="newsletter-item-<?= esc_attr($num_item) ?>" class="newsletter-item">
                <a
                    class="previous-newsletter-item"
                    href="<?= esc_url($source); ?>"
                    target="_blank"
                    rel="noopener noreferrer">
                    <img
                        src="<?= esc_url($thumbnail); ?>"
                        alt="<?= esc_attr(get_the_title()); ?>">
                </a>
                <div class="previous-newsletter-item-icon-container">
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
            </div>
            <?php $num_item = $num_item + 1 ?>
        <?php endwhile; ?>

    </div>
</section>