<?php

/*
Element Description: Blog article
*/

class blogArticle extends WPBakeryShortCode
{

    // Element Init
    function __construct()
    {
        add_action('init', array($this, 'vc_blogarticle_mapping'));
        add_shortcode('vc_blogarticle', array($this, 'vc_blogarticle_html'));
    }

    public function vc_blogarticle_mapping()
    {

        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        vc_map(

            array(
                'name' => __('VC Blog article', 'text-domain'),
                'base' => 'vc_blogarticle',
                'description' => __('Blog article', 'text-domain'),
                'category' => __('Blog article', 'text-domain'),
                'icon' => get_template_directory_uri() . '/assets/img/vc-icon.png',
                'params' => array(

                    array(
                        'type' => 'dropdown',
                        'holder' => 'h3',
                        'class' => 'title-class',
                        'heading' => __('Article ID', 'text-domain'),
                        'param_name' => 'article_id',
                        'value' => wpb_recentposts_dropdown(),
                        'description' => __('Box Title', 'text-domain'),
                        'admin_label' => false,
                        'weight' => 0,
                        'group' => 'Custom Group',
                    ),


                )
            )
        );

    }


    public function vc_blogarticle_html($atts)
    {

        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'article_id'   => ''
                ),
                $atts
            )
        );

        $id = $article_id;

        $title = get_the_title($id);
        $thumb_id = get_post_thumbnail_id($id);
        $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
        $thumb_url = $thumb_url_array[0];


        $html = '
                <div class="vc-infobox-wrap item-block magic-click" data-url="'.get_the_permalink($id).'">
                    <div class="image">
                    <div class="bg"></div>
                    <img src="'.$thumb_url.'" alt=""/>
                    <div class="filter">
                        <div>
                            <span class="date">'.get_the_time('F j, Y', $id).'</span>
                            <h3>'.$title.'</h3>
                            <div class="excerpt">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>';

        return $html;

    }




}


new blogArticle();