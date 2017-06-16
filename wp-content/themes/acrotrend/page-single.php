<?php
/* template name: single */
?>
<?php get_header(); ?>
<div class="single-page">

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <?php
        $thumb_id = get_post_thumbnail_id();
        $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
        $thumb_url = $thumb_url_array[0];
        ?>

        <div class="wrapper text" style="padding-top:130px;">
            <h1><?php the_title(); ?></h1>
            <hr/>
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>

    <?php else: ?>

        <h2><?php _e('Sorry, nothing to display.', 'wanicrea'); ?></h2>

    <?php endif; ?>

</div>
<?php get_footer(); ?>
