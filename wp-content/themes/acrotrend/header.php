<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(''); ?><?php if (wp_title('', false)) {
            echo ' :';
        } ?> <?php bloginfo('name'); ?></title>

    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<?php
if (is_front_page() || get_the_ID() == 18 || get_post_type() == 'acservices') {
    $logo = 'home';
}else{
    $logo = 'page';
}
?>
<div class="logo magic-click" data-type="<?php echo $logo; ?>" data-url="<?php echo get_home_url(); ?>">

</div>

<header class="header">

    <div class="hamburger-bg">
        <div class="burger-menu burger-menu--closed">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>

    <div class="main-menu">
        <?php
        wp_nav_menu(array('menu' => 'header-menu'));
        ?>
    </div>

    <div class="service-menu">
        <?php


        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'acservices',
        );
        $myposts = get_posts($args);

        $html .= '<div class="all-services">';
        $html .= '<h3>Services</h3>';
        foreach ($myposts as $post) : setup_postdata($post);


            $term_list = wp_get_post_terms($post->ID, 'services_categories', array("fields" => "all"));

            $fields = 'data-icon="'.get_field('icon', $post->ID).'" data-as-a-service="'.get_field('as_a_service', $post->ID).'" data-cloud-business-platforms="'.get_field('cloud_business_platform', $post->ID).'" data-in-a-box="'
                .get_field('in_a_box', $post->ID).'" data-active="'
                .get_field('active', $post->ID).'"';

            $numItems = count($term_list);
            $i = 0;
            $hola = '';
            foreach($term_list as $terms){
                $separartor=' ';
                if(++$i === $numItems) {
                    $separartor ='';
                }
                $hola .= $terms->slug.$separartor;
            }

            $html .= '
            <div class="service '.$hola.'">
            <div class="s__item magic-click" data-url="'.get_the_permalink($post->ID).'" data-type="_blank">
                <div class="image"  '.$fields.' >
                </div>
                <div class="title">
                    '.get_the_title($post->ID).'
                </div>
            </div>
            </div>';
        endforeach;
        $html .= '</div>';

        $html .= '</div>';
        wp_reset_postdata();

        echo $html;


        ?>
    </div>

    <div class="plus-minus-toggle collapsed service-menu-button"></div>

    <div class="share">
        <div class="links">
            <?php
            foreach (get_socials() as $name => $soc) {
                echo '<div data-url="' . $soc . '" data-type="_blank" class="magic-click ' . $name . '"></div>';
            }
            ?>
        </div>
    </div>

    <div class="contacts">
        <?php
        $phone_url = get_option('phone_url');
        $email_url = get_option('email_url');
        ?>
        <div class="links">
            <div>
                <a href="<?php echo get_the_permalink(20); ?>">
                    Talk to an expert
                </a>
            </div>
            <div>
                <a href="mailto:<?php echo $email_url; ?>" class="email">
                </a>
            </div>
        </div>
    </div>

</header>

<!--  end of header -->