<?php
/* template name: contact page */
?>
<?php get_header(); ?>


<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="contact">
    <?php the_content(); ?>
</div>
<?php endwhile; endif; ?>


<?php get_footer(); ?>