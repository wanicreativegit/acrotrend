<?php

if (!isset($content_width)) {
    $content_width = 900;
}



if (function_exists('add_theme_support')) {
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    add_theme_support('automatic-feed-links');

    load_theme_textdomain('wanicrea', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function wanicrea_nav()
{
    wp_nav_menu(
        array(
            'theme_location' => 'header-menu',
            'menu' => '',
            'container' => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul>%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        )
    );
}


function wanicrea_header_scripts()
{

    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', array(), '3.0.0'); // jquery
        wp_enqueue_script('jquery'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('slick', get_template_directory_uri() . '/js/slick.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('slick'); // Enqueue it!

        wp_register_script('joinus', get_template_directory_uri() . '/js/join-us-form.js', array('jquery'));
        wp_enqueue_script('joinus'); // Enqueue it!

        wp_register_script('wanicreascripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.5'); // Custom scripts
        wp_enqueue_script('wanicreascripts'); // Enqueue it!

    }
}

function wanicrea_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

function wanicrea_styles()
{
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap'); // Enqueue it!

    wp_register_style('wanicrea', get_template_directory_uri() . '/style.min.css', array(), '170426126', 'all');
    wp_enqueue_style('wanicrea'); // Enqueue it!

}

function register_wanicrea_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'wanicrea'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'wanicrea'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'wanicrea') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}


function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}


function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}


function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}


if (function_exists('register_sidebar')) {
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'wanicrea'),
        'description' => __('Description for this widget-area...', 'wanicrea'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'wanicrea'),
        'description' => __('Description for this widget-area...', 'wanicrea'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}


function remove_head_scripts()
{
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
}

add_action('wp_enqueue_scripts', 'remove_head_scripts');

// END Custom Scripting to Move JavaScript


function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}


function wanicreawp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

function wanicreawp_index($length = 20)
{
    return $length;
}


function wanicreawp_custom_post($length = 40)
{
    return $length;
}


function wanicreawp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}


function wanicrea_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'wanicrea') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function wanicrea_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html)
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}


function wanicreagravatar($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}


function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function wanicreacomments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
<?php endif; ?>
    <div class="comment-author vcard">
        <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['180']); ?>
        <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
    <?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
    <br/>
<?php endif; ?>

    <div class="comment-meta commentmetadata"><a
            href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
            <?php
            printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'), '  ', '');
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
        <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ('div' != $args['style']) : ?>
    </div>
<?php endif; ?>
<?php
}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'wanicrea_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'wanicrea_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'wanicrea_styles'); // Add Theme Stylesheet
add_action('init', 'register_wanicrea_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'wanicreawp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'wanicreagravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'wanicrea_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'wanicrea_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'wanicrea_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'wanicrea_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Code
\*------------------------------------*/


function custom_mtypes($m)
{
    $m['svg'] = 'image/svg+xml';
    $m['svgz'] = 'image/svg+xml';
    return $m;
}

add_filter('upload_mimes', 'custom_mtypes');


/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function wanicrea_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}


function wanicrea_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

include_once 'options_page.php';

function get_socials()
{

    $output = [];

    $facebook_url = get_option('facebook_url');
    $twitter_url = get_option('twitter_url');
    $linkedin_url = get_option('linkedin_url');
    $youtube_url = get_option('youtube_url');


    if ($facebook_url) {
        $output['fb'] = $facebook_url;
    }
    if ($twitter_url) {
        $output['tw'] = $twitter_url;
    }
    if ($linkedin_url) {
        $output['ln'] = $linkedin_url;
    }
    if ($youtube_url) {
        $output['you'] = $youtube_url;
    }


    return $output;

}

function get_contacts()
{

    $output = [];

    $phone_url = get_option('phone_url');
    $email_url = get_option('email_url');
    $address_url = get_option('address_url');


    if ($phone_url) {
        $output['phone'] = $phone_url;
    }
    if ($email_url) {
        $output['email'] = $email_url;
    }
    if ($address_url) {
        $output['address'] = $address_url;
    }


    return $output;

}


add_action('init', 'fmedia_register');

function fmedia_register()
{

    $labels = array(
        'name' => _x('Feature media', 'post type general name'),
        'singular_name' => _x('Feature media Item', 'post type singular name'),
        'add_new' => _x('Add New', 'portfolio item'),
        'add_new_item' => __('Add New Feature media'),
        'edit_item' => __('Edit Feature media'),
        'new_item' => __('New Feature media'),
        'view_item' => __('View Feature media'),
        'search_items' => __('Search Feature media'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array(
            'fmedia_categories'
        )
    );

    register_post_type('fmedia', $args);
}


function fmedia_taxonomy()
{
    register_taxonomy(
        'fmedia_categories',
        'fmedia',
        array(
            'hierarchical' => true,
            'label' => 'Categories',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'fmediacat',
                'with_front' => false
            )
        )
    );
}
add_action('init', 'fmedia_taxonomy');



function fmedia_func($cat_id, $title, $type)
{

    $html = '';

    $class='multiple-items';
    if($type == 'Services'){
        $class = 'services-items';
    }
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'fmedia',
        'tax_query' => array(
            array(
                'taxonomy' => 'fmedia_categories',
                'field' => 'id',
                'terms' =>$cat_id,
            )
        ));

    $myposts = get_posts($args);
    $html .= '<div class="wrapper">';
    $html .= '<div class="fmedia">';
    $html .= '<h2>'.$title.'</h2>';
    $html .= '<hr/>';
    $html .= '<div class="row '.$class.'">';
    foreach ($myposts as $post) : setup_postdata($post); ?>
        <?php
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
        $url = get_field('url', $post->ID);

        $html .= '<div class="item ">';

            if ($url) {

                $html .= '<a href="'.$url.'"><img src="'.$image[0].'"/></a>';

            } else {
                $html .= '<img src="'.$image[0].'" alt=""/>';
            }

        $html .= '</div>';
    endforeach;
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    wp_reset_postdata();

    return $html;


}

add_shortcode('fmedia', 'fmedia_func');


function socials(){

    $html ='<div class="socials">';
    foreach (get_socials() as $name => $soc) {
        $html .= '<div data-url="' . $soc . '" data-type="_blank" class="magic-click ' . $name . '"></div>';
    }
    $html .= '</div>';
    return $html;

}

add_shortcode('socials-block', 'socials');


/**
 * testimonials
 */

add_action('init', 'testimonials_register');
function testimonials_register()
{

    $labels = array(
        'name' => _x('Testimonials', 'post type general name'),
        'singular_name' => _x('Testimonials Item', 'post type singular name'),
        'add_new' => _x('Add New', 'portfolio item'),
        'add_new_item' => __('Add New Testimonials'),
        'edit_item' => __('Edit Testimonials'),
        'new_item' => __('New Testimonials'),
        'view_item' => __('View Testimonials'),
        'search_items' => __('Search Testimonials'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => '',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('actestimonials', $args);
}


add_action('init', 'jobs_register');
function jobs_register()
{

    $labels = array(
        'name' => _x('Jobs', 'post type general name'),
        'singular_name' => _x('Jobs Item', 'post type singular name'),
        'add_new' => _x('Add New', 'portfolio item'),
        'add_new_item' => __('Add New Jobs'),
        'edit_item' => __('Edit Jobs'),
        'new_item' => __('New Jobs'),
        'view_item' => __('View Jobs'),
        'search_items' => __('Search Jobs'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => '',
        'rewrite' => array('slug' => 'jobs'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array(
            'jobs_categories'
        )
    );

    register_post_type('acjobs', $args);
}

function jobs_taxonomy()
{
    register_taxonomy(
        'jobs_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'acjobs',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Categories',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'jobscat', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );
}

add_action('init', 'jobs_taxonomy');

/* services */

add_action('init', 'services_register');
function services_register()
{

    $labels = array(
        'name' => _x('Services', 'post type general name'),
        'singular_name' => _x('Services Item', 'post type singular name'),
        'add_new' => _x('Add New', 'portfolio item'),
        'add_new_item' => __('Add New Services'),
        'edit_item' => __('Edit Services'),
        'new_item' => __('New Services'),
        'view_item' => __('View Services'),
        'search_items' => __('Search Services'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => '',
        'rewrite' => array('slug' => 'services'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies' => array(
            'services_categories'
        )
    );

    register_post_type('acservices', $args);
}

flush_rewrite_rules( false );

function services_taxonomy()
{
    register_taxonomy(
        'services_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'acservices',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Categories',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'servicescat', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );
}

add_action('init', 'services_taxonomy');


function actestimonials_func($atts)
{
    $a = shortcode_atts(array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts);


    $html = '';


    $args = array('posts_per_page' => -1, 'post_type' => 'actestimonials');

    $myposts = get_posts($args);

    echo '<div class="testimonials">';
    echo '<div class="wrapper">';
    ?>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 hr-orange">
            <?php
            echo '<h2 class="text-orange">What<br/> Our Clients Say</h2>';


            echo '<div class="slider push-left">';
            foreach ($myposts as $post) : setup_postdata($post); ?>
                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                <div>
                    <hr class="push-hr-med"/>
                    <?php the_content(); ?>
                    <div class="person">
                        <div class="name"><?php echo get_field('name', $post->ID); ?></div>
                        <div class="position"><?php echo get_field('position', $post->ID); ?></div>
                    </div>
                </div>
            <?php endforeach;
            echo '</div>';
            ?>
        </div>
    </div>
    <?php

    echo '</div>';
    echo '</div>';

    wp_reset_postdata();


}

add_shortcode('testimonials', 'actestimonials_func');


/*
 * Job descriptions
 */

function acjobs_func($atts)
{
    $a = shortcode_atts(array(
        'category' => '',
    ), $atts);


    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'acjobs',
        'tax_query' => array(
            array(
                'taxonomy' => 'jobs_categories',
                'field' => 'term_id',
                'terms' => $a['category'],
            )
        )
    );
    $myposts = get_posts($args);

    $html = '';
    foreach ($myposts as $post) : setup_postdata($post);

        $html .= '
        <div class="jobs-block">
            <div class="line">
                <input type="radio"
                        name="job"
                        class="job_radio"
                        v-model="message"
                       value="' . get_the_title($post->ID) . '"
                       id="country-' . $post->ID . '" />
                <label class="job-label" for="country-' . $post->ID . '" ><a href="'.get_the_permalink($post->ID).'" target="_blank">' . get_the_title($post->ID) . '</a> <div class="info"> ' . get_field('city', $post->ID) . ' | ' . get_field('position', $post->ID) . ' </div></label>
            </div>
        </div>';

    endforeach;
    wp_reset_postdata();

    return $html;
}

add_shortcode('jobs', 'acjobs_func');


/*
 * Services shortcode
 */


function services_func($atts)
{
    $a = shortcode_atts(array(
        'category' => '',
    ), $atts);


    $html = '';
    $html .= '<div class="services-block">';

    $categories = get_terms('services_categories', array(
        'orderby' => 'menu_order',
        'hide_empty' => 0
    ));

    $html .= '<ul>';
    foreach ($categories as $cat) {
        $html .= '<li>';
        $html .= '<a href="#' . $cat->term_id . '" class="cat-button" data-id="' . $cat->term_id . '" data-slug="' . $cat->slug . '">' . $cat->name . '</a>';
        $html .= '</li>';
    }
    $html .= '</ul>';

    $html .= '<div class="cat-content">';
    foreach ($categories as $cat) {

        $color = get_field('color', 'services_categories_' . $cat->term_id);

        $html .= '<div data-color="' . $color . '" class="content" id="cat-' . $cat->term_id . '">';
        $html .= get_field('description', 'services_categories_' . $cat->term_id);
        $html .= '<div class="close"></div>';
        $html .= '</div>';
    }
    $html .= '</div>';


    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'acservices',
    );
    $myposts = get_posts($args);

    $html .= '<div class="all-services">';
    foreach ($myposts as $post) : setup_postdata($post);


        $term_list = wp_get_post_terms($post->ID, 'services_categories', array("fields" => "all"));


        $fields = 'data-icon="' . get_field('icon', $post->ID) . '" data-as-a-service-solutions="'
            . get_field('as_a_service', $post->ID) . '" data-in-a-box-solutions="'
            . get_field('cloud_business_platform', $post->ID) . '" data-tailored-solutions="'
            . get_field('in_a_box', $post->ID) . '" data-active="'
            . get_field('active', $post->ID) . '"';

        $numItems = count($term_list);
        $i = 0;
        $hola = '';
        foreach ($term_list as $terms) {
            $separartor = ' ';
            if (++$i === $numItems) {
                $separartor = '';
            }
            $hola .= $terms->slug . $separartor;
        }

        $html .= '
            <div class="service ' . $hola . '" ">
            <div class="s__item magic-click" data-url="' . get_the_permalink($post->ID) . '">
            <div>
                <div class="title top">
                    ' . get_the_title($post->ID) . '
                </div>
                <div class="image"  ' . $fields . ' >
                </div>
                <div class="title bottom">
                    ' . get_the_title($post->ID) . '
                </div>
                <div class="content">
                    <p id="as-a-service-solutions">
                    ' . get_post_meta($post->ID, 'as-a-service', true) . '
                    </p>
                    <p id="tailored-solutions">
                    ' . get_post_meta($post->ID, 'cloud-business-platforms', true) . '
                    </p>
                    <p class="" id="in-a-box-solutions">
                    ' . get_post_meta($post->ID, 'in-a-box', true) . '
                    </p>
                    <p class="active" id="main">
                    ' . get_post_meta($post->ID, 'main', true) . '
                    </p>
                </div>
            </div>
            </div>
            </div>';
    endforeach;
    $html .= '</div>';

    $html .= '</div>';
    wp_reset_postdata();

    return $html;
}

add_shortcode('services', 'services_func');


add_action('init', 'aboutus_register');
function aboutus_register()
{

    $labels = array(
        'name' => _x('About us slider', 'post type general name'),
        'singular_name' => _x('About us slider Item', 'post type singular name'),
        'add_new' => _x('Add New', 'portfolio item'),
        'add_new_item' => __('Add New About us slider'),
        'edit_item' => __('Edit About us slider'),
        'new_item' => __('New About us slider'),
        'view_item' => __('View About us slider'),
        'search_items' => __('Search About us slider'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => '',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('aboutusslider', $args);
}


add_action('init', 'teamslider_register');
function teamslider_register()
{

    $labels = array(
        'name' => _x('Team slider', 'post type general name'),
        'singular_name' => _x('Team slider Item', 'post type singular name'),
        'add_new' => _x('Add New', 'portfolio item'),
        'add_new_item' => __('Add New Team slider'),
        'edit_item' => __('Edit Team slider'),
        'new_item' => __('New Team slider'),
        'view_item' => __('View Team slider'),
        'search_items' => __('Search Team slider'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => '',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('teamslider', $args);
}


function aboutusslider_func($atts)
{
    $a = shortcode_atts(array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts);


    $html = '';


    $args = array('posts_per_page' => -1, 'post_type' => 'aboutusslider');
    $myposts = get_posts($args);

    ?>



    <div class="row relative ">

        <div class="slider-bgs">

            <div class="blue-block">
                <div class="bg"></div>
            </div>
            <div class="yellow-block">
            </div>


            <?php

            echo '<div class="slider">';
            foreach ($myposts as $post) : setup_postdata($post); ?>
                <?php
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                ?>
                <div>
                    <div class="col-md-4 content">
                        <div class="inside">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <div class="col-md-7 image" style="background-image:url(<?php echo $image[0]; ?>);">
                    </div>
                </div>
            <?php endforeach;
            echo '</div>';
            ?>

        </div>

    </div>
    <?php

    wp_reset_postdata();


}

add_shortcode('about-us-slider', 'aboutusslider_func');


function teamslider_func($atts)
{
    $a = shortcode_atts(array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts);

    $html = '';

    $args = array('posts_per_page' => -1, 'post_type' => 'teamslider');
    $myposts = get_posts($args);

    ?>

    <div class="row relative ">
        <div class="slider-bgs">
            <div class="magic stick-wrapper more">
                <?php
                foreach ($myposts as $post) : setup_postdata($post); ?>
                    <?php
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                    ?>
                    <div>
                        <div class="content">
                            <img src="<?php echo $image[0]; ?>" alt=""/>

                            <div class="info">
                                <h3><?php echo get_the_title($post->ID); ?></h3>

                                <div class="position"><?php echo get_field('position', $post->ID); ?></div>
                                <div class="cont">
                                    <?php
                                    the_content();
                                    ?>
                                </div>
                                <div class="socials">
                                    <?php
                                    if (get_field('twitter', $post->ID)) {
                                        echo '<a href="' . get_field('twitter', $post->ID) . '" target="_blank" class="twitter"></a>';
                                    }
                                    if (get_field('linkedin', $post->ID)) {
                                        echo '<a href="' . get_field('linkedin', $post->ID) . '" target="_blank" class="linkedin"></a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 image" style="background-image:url(<?php echo $image[0]; ?>);">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
    wp_reset_postdata();

}

add_shortcode('team-slider', 'teamslider_func');


function joinus_form_uk()
{

    $html = '';
    $html .= '
<div class="row join-us-contact">
<div class="form">
' . do_shortcode('[contact-form-7 id="1145" title="acrotrend - join us_UK"]') . '
</div>
</div>';

    return $html;

}

function joinus_form_india()
{

    $html = '';
    $html .= '
<div class="row join-us-contact">
<div class="form">
' . do_shortcode('[contact-form-7 id="1048" title="acrotrend - join us"]') . '
</div>
</div>';

    return $html;


}

add_shortcode('join-us-form-india', 'joinus_form_india');
add_shortcode('join-us-form-uk', 'joinus_form_uk');
add_shortcode('join-us-form', 'joinus_form_uk');



add_action('init', 'team_register');
function team_register()
{

    $labels = array(
        'name' => _x('Team', 'post type general name'),
        'singular_name' => _x('Team Item', 'post type singular name'),
        'add_new' => _x('Add New', 'portfolio item'),
        'add_new_item' => __('Add New team'),
        'edit_item' => __('Edit Team'),
        'new_item' => __('New Team'),
        'view_item' => __('View Team'),
        'search_items' => __('Search Team'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => '',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('teamposts', $args);
}


function team_func($atts)
{
    $a = shortcode_atts(array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts);


    $args = array('posts_per_page' => -1, 'post_type' => 'teamposts', 'orderby' => 'menu_order');
    $myposts = get_posts($args);



    ?>

    <div class="title absolute h-orange hr-orange hide-on-large padding-right more mobile-padding" style="right:0;">
        <?php
        echo '<h2>Meet<br/>the team</h2>';
        ?>
        <hr/>
    </div>

    <div class="team-box relative padding-left">
        <?php
        $rand = rand(5, 10);
        $i = 1;
        foreach ($myposts as $post) {

            setup_postdata($post); ?>
            <?php
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');

            $likes = explode(",", get_field('likes', $post->ID));

            $tw = get_field('twitter', $post->ID);
            $ln = get_field('linkedin', $post->ID);

            ?>
            <div class="diff-row" style="background-image: url(<?= $image[0] ?>);" onclick="">

                <div class="info">
                    <div class="name">
                        <?php echo get_the_title($post->ID); ?>
                        <div class="socials">
                            <?php

                            if ($tw) {
                                echo '<a href="' . $tw . '" class="twitter" target="_blank" rel="noopener"></a>';
                            }
                            if ($ln) {
                                echo '<a href="' . $ln . '" class="linkedin" target="_blank" rel="noopener"></a>';
                            }

                            ?>

                        </div>
                    </div>
                    <div class="summary">
                        <?php echo get_field('summary', $post->ID); ?>
                    </div>

                </div>

            </div>


            <?php $i++;
        }
        ?>
    </div>

    <div class="title absolute h-orange hr-orange padding-right more hide-on-small mobile-padding" style="right:0;">
        <?php
        echo '<h2>Meet<br/>the team</h2>';
        ?>
        <hr/>
    </div>

    <?php

    wp_reset_postdata();


}

add_shortcode('team-boxes', 'team_func');


function wpb_recentposts_dropdown()
{


    $args = array('numberposts' => '-1', 'post_status' => 'publish');

    $arr = [];
    $recent_posts = wp_get_recent_posts($args);
    foreach ($recent_posts as $recent) {

        $arr[] = $recent["ID"];

    }

    return $arr;
}

function get_all_taxonomies(){
    $terms = get_terms( array(
        'taxonomy' => 'fmedia_categories',
        'hide_empty' => false,
    ) );

    $arr = [];
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){

        $arr[] = '--- Choose ---';
        foreach ( $terms as $term ) {

            $arr[] = $term->name;
        }

    }

    return $arr;

}

add_shortcode('rp_dropdown', 'wpb_recentposts_dropdown');
add_filter('widget_text', 'do_shortcode');


require_once(__DIR__ . '/vc-elements/blog-article.php');
require_once(__DIR__ . '/vc-elements/case-study.php');
require_once(__DIR__ . '/vc-elements/simple-text.php');
require_once(__DIR__ . '/vc-elements/slider.php');

require_once(__DIR__ . '/_inc/video_bg.php');




?>
