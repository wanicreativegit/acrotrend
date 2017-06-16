<div class="slider-bg">

    <div class="blue-bg"></div>
    <div class="yellow-bg"></div>

    <?php

    $lastposts = get_posts(array(
        'posts_per_page' => 1,
        'category' => '32'
    ));

    if ($lastposts) {
        ?>
        <div class="row">
            <div class="col-sm-6 hr-white h-white push-50 relative">

                <?php
                foreach ($lastposts as $post) :
                setup_postdata($post);

                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                ?>
                    <div class="bg-image" style="background-image: url(<?php echo $image[0]; ?>);"></div>
                <?php
                endforeach;
                ?>



                <h1>Latest<br/> news</h1>
                <hr/>
            </div>
            <div class="col-sm-6 content">
                <?php
                $lastposts = get_posts(array(
                    'posts_per_page' => 3,
                    'category' => 32
                ));
                echo '<div class="slider">';
                foreach ($lastposts as $post) :
                    setup_postdata($post);

                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                    ?>
                    <div class="hr-blue item-slider" data-image="<?php echo $image[0]; ?>">
                        <span class="date"><?php the_time('F j, Y'); ?></span>

                        <h2><?php the_title(); ?></h2>
                        <hr />
                        <div class="excerpt">
                            <?php wanicreawp_excerpt('wanicreawp_index'); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>"> Read article </a>
                    </div>
                <?php
                endforeach;
                echo '</div>';
                ?>
            </div>
        </div>

        <?php
    }
    ?>
</div>