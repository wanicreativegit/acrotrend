<?php get_header(); ?>

<div class="services-single">

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

    <?php
    the_content();
    ?>

<?php endwhile; ?>

<?php else: ?>

    <article>
        <h1><?php _e('Sorry, nothing to display.', 'wanicrea'); ?></h1>
    </article>

<?php endif; ?>

</div>

<?php get_footer(); ?>
