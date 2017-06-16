<?php

if (!class_exists('WPBakeryShortCode')) return;

class video_bg extends WPBakeryShortCode
{

    // Element Init
    function __construct()
    {
        add_action('init', array($this, 'vc_video_bg_mapping'));
        add_shortcode('vc_video_bg', array($this, 'vc_video_bg_html'));
    }

    public function vc_video_bg_mapping()
    {

        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        vc_map(

            array(
                'name' => __('Video BG', 'text-domain'),
                'base' => 'vc_video_bg',
                'description' => __('Video BG', 'text-domain'),
                'category' => __('video BG', 'text-domain'),
                'icon' => get_template_directory_uri() . '/assets/img/vc-icon.png',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __( 'Url', 'text-domain' ),
                        'param_name' => 'cs_url',
                        'description' => __( 'youtube video url', 'text-domain' ),
                        'admin_label' => false,
                        'weight' => 0
                    ),
                    array(
                        "type" => "textarea_html",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Content", "my-text-domain"),
                        "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
                        "value" => __("", "my-text-domain"),
                        "description" => __("Enter your content.", "my-text-domain")
                    ),
                )
            )
        );

    }


    public function vc_video_bg_html($atts, $content)
    {

        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'cs_url' => ''
                ),
                $atts
            )
        );

        $atts['content'] = $content;

        $html = '';

        $html .= '<div class="video-wrapper" data-video-id="'.$atts['cs_url'].'" data-video-youtube-link="y"
             data-video-start="0"
             data-video-width-add="100" data-video-height-add="100" style="height: 800px;">
            <div class="tv">
                <div class="screen mute" id="tv"></div>
            </div>
            <div class="bg-img"
                 style="
                     background-image:url(https://img.youtube.com/vi/'.$atts['cs_url'].'/maxresdefault.jpg);
                     background-size: cover;
                     width: 100%;
                     background-position: center;
                     height: 100%;
                     top: 0;
                     position: absolute;
                     "></div>
        </div>';


        return $html;

    }


}


new video_bg();