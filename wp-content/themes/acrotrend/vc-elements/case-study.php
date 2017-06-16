<?php

/*
Element Description: Case study
*/

class caseStudy extends WPBakeryShortCode
{

    // Element Init
    function __construct()
    {
        add_action('init', array($this, 'vc_casestudy_mapping'));
        add_shortcode('vc_casestudy', array($this, 'vc_casestudy_html'));
    }

    public function vc_casestudy_mapping()
    {

        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        vc_map(

            array(
                'name' => __('Case Study', 'text-domain'),
                'base' => 'vc_casestudy',
                'description' => __('Case study', 'text-domain'),
                'category' => __('case study', 'text-domain'),
                'icon' => get_template_directory_uri() . '/assets/img/vc-icon.png',
                'params' => array(

                    array(
                        "type" => "vc_link",
                        "class" => "",
                        "heading" => __("Url"),
                        "param_name" => "button-url",
                        "value" => __(""),
                        "description" => __("The button will link to this URL")
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Title', 'js_composer' ),
                        'param_name' => 'cs_title',
                        'description' => __( 'Title', 'js_composer' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Top Title', 'js_composer' ),
                        'param_name' => 'cs_top_title',
                        'description' => __( 'Top Title', 'js_composer' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Date', 'js_composer' ),
                        'param_name' => 'cs_date',
                        'description' => __( 'Date', 'js_composer' )
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => __( 'Image', 'js_composer' ),
                        'param_name' => 'cs_image',
                        'description' => __( 'Image', 'js_composer' )
                    ),




                )
            )
        );

    }


    public function vc_casestudy_html($atts)
    {

        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'url'   => '',
                    'cs_title' => '',
                    'cs_top_title' => '',
                    'cs_date' => '',
                    'cs_image' => ''
                ),
                $atts
            )
        );


        $html = '';

        $url_options_string = $atts['button-url'];
        $url_options_array = explode( '|', $url_options_string );
        $url_options = array();
        foreach ( $url_options_array as $entry ) {
            $temp_array = explode( ':', $entry );
            $url_options[ $temp_array[0] ] = urldecode_deep( $temp_array[1] );
        }

        $img = wp_get_attachment_image_src($atts['cs_image'], "large");
        $imgSrc = $img[0];


        $html = '
                <div class="vc-infobox-wrap case-study-single item-block magic-click" data-url="'.$url_options['url'].'">
                    <div class="image">
                    <div class="bg"></div>
                    <img src="'.$imgSrc.'" alt=""/>
                    <div class="top-title">'.$atts['cs_top_title'].'</div>
                    <div class="filter">
                        <div>
                            <span class="date">'.$atts['cs_date'].'</span>
                            <h3>'.$atts['cs_title'].'</h3>
                        </div>
                    </div>
                    </div>
                </div>';


        return $html;

    }




}


new caseStudy();