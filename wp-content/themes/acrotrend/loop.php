<?php


if (have_posts()):

    $i = 1;
    $thumb_id = get_post_thumbnail_id();
    $thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);

    echo '<div class="row articles-row">';

    while (have_posts()) : the_post(); ?>


        <div id="post-<?php echo get_the_ID(); ?>"
             class="col-12 col-sm-12 col-md-6 col-lg-4 article magic-click"
             data-url="<?php echo get_the_permalink(); ?>">

            <div class="image" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
                <div class="bg"></div>
                <?php
                $categories = get_the_category();
                $category_id = $categories[0]->cat_name;
                ?>
                <div class="cat">
                    <?= $category_id ?>
                </div>
            </div>

            <div class="filter">
                <div>
                    <span class="date"><?php the_time('F j, Y'); ?></span>

                    <h2><?php the_title(); ?></h2>

                    <div class="excerpt">
                        <?php wanicreawp_excerpt('wanicreawp_index'); ?>
                    </div>
                </div>
            </div>
        </div>


        <?php
        if ($i % 3 === 0) {
            echo '</div><div class="row articles-row">';
        }
        ?>

        <?php $i++; endwhile; ?>
    <?php
    echo '</div>';
    ?>
<?php else: ?>

    <article>
        <h2><?php _e('Sorry, nothing to display.', 'wanicrea'); ?></h2>
    </article>

<?php
endif; ?>
