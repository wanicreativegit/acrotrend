<?php

/*
Element Description: Slider
*/

class Slider extends WPBakeryShortCode
{


    function __construct()
    {
        add_action('init', array($this, 'vc_slider_mapping'));
        add_shortcode('vc_slider', array($this, 'vc_slider_html'));
    }

    public function vc_slider_mapping()
    {

        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        vc_map(
            array(
                'name' => __('VC Slider', 'text-domain'),
                'base' => 'vc_slider',
                'description' => __('Custom slider', 'text-domain'),
                'category' => __('Custom slider', 'text-domain'),
                'icon' => get_template_directory_uri() . '/assets/img/vc-icon.png',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Title', 'js_composer' ),
                        'param_name' => 'cs_title',
                        'description' => __( 'Title', 'js_composer' ),
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'dropdown',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __('Category', 'text-domain'),
                        'param_name' => 'article_id',
                        'value' => get_all_taxonomies(),
                        'admin_label' => false,
                        "std"         => '----',
                        'weight' => 0,
                    ),
                    array(
                        'type' => 'dropdown',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __('Page type', 'text-domain'),
                        'param_name' => 'page_type',
                        'value' => array(
                            'services' => 'Services',
                            'other' => 'Other'
                        ),
                        'admin_label' => true,
                        "std"         => '----',
                        'weight' => 0,
                    )
                )
            )
        );

    }


    public function vc_slider_html($atts)
    {

        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'article_id'   => '',
                    'cs_title' => '',
                    'page_type' => ''
                ),
                $atts
            )
        );

        $category = get_term_by('name', $atts['article_id'], 'fmedia_categories');
        $output = fmedia_func($category->term_id, $atts['cs_title'], $atts['page_type']);

        return $output;

    }




}


new Slider();