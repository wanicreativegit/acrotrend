<?php

/*
Element Description: Simple text
*/

class simpleText extends WPBakeryShortCode
{

    // Element Init
    function __construct()
    {
        add_action('init', array($this, 'vc_simpletext_mapping'));
        add_shortcode('vc_simpletext', array($this, 'vc_simpletext_html'));
    }

    public function vc_simpletext_mapping()
    {

        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        vc_map(

            array(
                'name' => __('Simple text', 'text-domain'),
                'base' => 'vc_simpletext',
                'description' => __('Simple text', 'text-domain'),
                'category' => __('Simple text', 'text-domain'),
                'icon' => get_template_directory_uri() . '/assets/img/vc-icon.png',
                'params' => array(

                    array(
                        "type" => "vc_link",
                        "class" => "",
                        "heading" => __("Url"),
                        "param_name" => "button-url",
                        "value" => __("--"),
                        "description" => __("The button will link to this URL")
                    ),
                    array(
                        "type"        => "dropdown",
                        "heading"     => __("Box color"),
                        "param_name"  => "box-color",
                        "admin_label" => true,
                        "value"       => array(
                            'Grey'   => 'grey',
                            'Orange'   => 'orange'
                        )
                    ),
                    array(
                        "type" => "textarea",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __( "Content", "my-text-domain" ),
                        "param_name" => "content-opa", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
                        "value" => __( "", "my-text-domain" ),
                        "description" => __( "Enter your content.", "my-text-domain" )
                    )


                )
            )
        );

    }


    public function vc_simpletext_html($atts)
    {

        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'content-opa'   => '',
                    'box-color' => ''
                ),
                $atts
            )
        );

        $url_options_string = $atts['button-url'];
        $url_options_array = explode( '|', $url_options_string );
        $url_options = array();
        foreach ( $url_options_array as $entry ) {
            $temp_array = explode( ':', $entry );
            $url_options[ $temp_array[0] ] = urldecode_deep( $temp_array[1] );
        }

        if($url_options['url']){
            $url = $url_options['url'];
        }

        $html = '
                <div class="vc-infobox-wrap item-block" data-color="'.$atts['box-color'].'">
                    <div class="content">
                    <div>
                    <p>'.$atts['content-opa'].'</p>
                    <hr/>
                    <a href="'.$url.'">Discover more</a>
                    </div>
                    </div>
                </div>';


        return $html;

    }




}


new simpleText();