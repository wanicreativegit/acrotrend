<?php get_header(); ?>

<div class="blog single">


    <?php

    $prev_post = get_adjacent_post(false, '', true);
    $next_post = get_adjacent_post(false, '', false);

    $categories = get_the_category();
    $category_id = $categories[0]->term_id;
    $thumb_id = get_post_thumbnail_id();
    $thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
    ?>

    <?php if (have_posts()): while (have_posts()) : the_post(); ?>

        <div class="header">

            <div class="row">

                <div class="col-sm-12 col-md-6 hide-on-small remove-padding">
                    <div class="image" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 content hr-blue-menu h-blue-menu">

                    <?php

                    if (!empty($prev_post)) {
                        echo '<div class="arrow left magic-click" data-url="' . get_permalink($prev_post->ID) . '">


                          <svg width="20px" height="80px" viewBox="0 0 50 80" xml:space="preserve">
                            <polyline fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" points="
                            45.63,75.8 0.375,38.087 45.63,0.375 "/>
                          </svg>

                        </div>';
                    }

                    if (!empty($next_post)) {
                        echo '<div class="arrow right magic-click" data-url="' . get_permalink($next_post->ID) . '">

                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="80px" viewBox="0 0 50 80" xml:space="preserve">
                                    <polyline fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" points="
                                0.375,0.375 45.63,38.087 0.375,75.8 "/>
                                </svg>

                        </div>';
                    }

                    ?>

                    <span class="date">
                    <?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?>
                </span>


                    <h1>
                        <?php the_title(); ?>
                    </h1>
                    <hr/>

                    <div class="text">
                        <?php the_content(); ?>
                    </div>
                    <div class="social-block">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php  echo get_the_permalink();?>" class="facebook"></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/home?status=Take%20a%20look%3A%20<?php  echo get_the_permalink(); ?>" class="twitter"></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php  echo get_the_permalink(); ?>&title=<?php echo get_the_title(); ?>&summary=sdssd&source=" class="linkedin"></a>
                            </li>
                            <li>
                                <a href="mailto:?&subject=Article&body=<?php echo get_the_permalink(); ?>" class="email"></a>
                            </li>

                        </ul>
                    </div>

                </div>

            </div>

        </div>




        <?php


        $lastposts = get_posts(array(
            'category' => $category_id,
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID())
        ));

        if ($lastposts) {
            echo '<div class="row articles-row grey-block ">';
            echo '<div class="wrapper">';
            foreach ($lastposts as $post) :
                setup_postdata($post);

                $thumb_id = get_post_thumbnail_id($post->ID);
                $thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);

                ?>


                <div id="post-<?php echo $post->ID; ?>"
                     class="col-12 col-sm-12 col-md-6 col-lg-4 article magic-click"
                     data-url="<?php echo get_the_permalink($post->ID); ?>">

                    <div class="image" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
                        <div class="bg"></div>
                        <?php
                        $categories = get_the_category($post->ID);
                        $category_id = $categories[1]->cat_name;
                        ?>
                        <div class="cat">
                            <?= $category_id ?>
                        </div>
                    </div>

                    <div class="filter">
                        <div>
                            <span class="date"><?php the_time('F j, Y'); ?></span>

                            <h2><?php echo get_the_title($post->ID); ?></h2>

                            <div class="excerpt">
                                <?php wanicreawp_excerpt('wanicreawp_index'); ?>
                            </div>
                        </div>
                    </div>
                </div>




            <?php
            endforeach;
            wp_reset_postdata();
            echo '</div>';
            echo '</div>';
        }
        ?>




    <?php endwhile; ?>

    <?php else: ?>

        <article>
            <h1><?php _e('Sorry, nothing to display.', 'wanicrea'); ?></h1>
        </article>

    <?php endif; ?>


    <?php get_footer(); ?>
