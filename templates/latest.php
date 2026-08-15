<?php

/** @var WP_Query $query */
?>

<div class="search-newsletter-header">
    <h3>Último boletín</h3>
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
            href="<?= esc_url($source); ?>"
            target="_blank"
            rel="noopener noreferrer">
            <img
                src="<?= esc_url($thumbnail); ?>"
                alt="<?= esc_attr(get_the_title()); ?>">
        </a>
    <?php endwhile; ?>
</div>