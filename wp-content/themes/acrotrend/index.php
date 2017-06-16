<?php get_header(); ?>

<div class="grey-block blog">
    <?php
    $count_posts = wp_count_posts();
    $posts = get_posts('category=32');
    $count = count($posts);


    $categories = get_categories();
    GLOBAL $number;
    foreach ($categories as $category) {
        //to check if category is parent
        if ($category->parent == 0) {
            $number .= $category->count;

            break;
        }
    }

    ?>

    <div class="header">
        <div class="wrapper-normal">
            <?php get_template_part('templates/blog_slider'); ?>
        </div>
        <div class="hide-on-large">
            <h3 style="padding:10px 30px 20px 30px;">Categories</h3>
        </div>
        <div class="filter">
            <ul>
                <li>
                    <a href="<?php echo get_the_permalink(6); ?>">All articles ( <?php echo $number; ?> )</a>
                </li>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => 0,
                    'exclude' => 1,
                    'parent' => 32

                ));

                foreach ($categories as $category) {
                    $category_link = sprintf(
                        '<a href="%1$s" alt="%2$s">%3$s (%4$s)</a>',
                        esc_url(get_the_permalink(6) . '?cat=' . $category->term_id),
                        esc_attr(sprintf(__('View all posts in %s', 'textdomain'), $category->name)),
                        esc_html($category->name),
                        esc_html($category->category_count)
                    );
                    echo '<li>' . $category_link . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="wrapper">

        <?php


        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $cat = (get_query_var('cat')) ? get_query_var('cat') : '32';


        $args = array(
            'posts_per_page' => 6,
            'cat' => $cat,
            'paged' => $paged
        );

        $the_query = new WP_Query($args);

        ?>

        <div class="row blog-section">
            <div class="relative">

                <?php
                if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();


                    $thumb_id = get_post_thumbnail_id();
                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);

                    ?>

                    <div id="post-<?php echo get_the_ID(); ?>"
                         class="col-12 col-sm-12 col-md-6 col-lg-4 article magic-click"
                         data-url="<?php echo get_the_permalink(); ?>">

                        <div class="image" style="background-image: url(<?php echo $thumb_url[0]; ?>);">
                            <div class="bg"></div>
                            <?php
                            $categories = get_the_category();
                            $category_id = $categories[1]->cat_name;
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

                <?php endwhile; ?>

                    <?php if ($the_query->max_num_pages > 1) { // check if the max number of pages is greater than 1  ?>
                        <nav class="prev-next-posts">

                            <div class="all-pages">
                                <?php echo $paged; ?> / <?php echo $the_query->max_num_pages; ?>
                            </div>
                            <div class="prev-posts-link">
                                <?php echo get_next_posts_link('See more', $the_query->max_num_pages); // display older posts link ?>
                            </div>
                            <div class="next-posts-link">
                                <?php echo get_previous_posts_link('See less'); // display newer posts link ?>
                            </div>
                        </nav>
                    <?php } ?>

                <?php else: ?>
                    <article>
                        <h1>Sorry...</h1>

                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    </article>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>

<?php get_footer(); ?>
