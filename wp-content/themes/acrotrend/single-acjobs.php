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

                <div class="col-sm-6 hide-on-small remove-padding">
                    <div class="image" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
                    </div>
                </div>
                <div class="col-sm-6 content hr-blue-menu h-blue-menu">
                    <span class="date">
                    <?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?>
                    </span>

                    <h1>
                        <?php the_title(); ?>
                    </h1>
                    <hr/>

                    <?php

                    $my_terms = get_the_terms( get_the_ID(), 'jobs_categories' );
                    if( $my_terms && !is_wp_error( $my_terms ) ) {
                        foreach( $my_terms as $term ) {

                            if($term->slug == 'mumbai-india'){
                                $value = get_option('indian_email');
                            }else if($term->slug == 'london-englan'){
                                $value = get_option('uk_email');
                            }
                            echo '<input type="hidden" id="curr_cat" value="'.$value.'" />';
                        }
                    }

                    ?>

                    <input type="hidden" id="role_name" value="<?php the_title(); ?>"
                    <div class="text">
                        <?php the_content(); ?>
                    </div>



                </div>

            </div>

        </div>


    <?php endwhile; ?>

    <?php else: ?>

        <article>
            <h1><?php _e('Sorry, nothing to display.', 'wanicrea'); ?></h1>
        </article>

    <?php endif; ?>


    <?php get_footer(); ?>

