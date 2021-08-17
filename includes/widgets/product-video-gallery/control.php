<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WF_Product_Video_Gallery_ELement extends Widget_Base {

    public function get_name() {
        return 'wf-product-video-gallery';
    }

    public function get_title() {
        return __( 'WF - Product Video Gallery', 'woofall' );
    }

    public function get_icon() {
        return 'eicon-video-camera';
    }

    public function get_categories() {
        return array( 'woofall' );
    }

    public function get_style_depends(){
        return [
            'woofall-widgets',
        ];
    }

    public function get_script_depends() {
        return [
            'woofall-widgets-scripts',
        ];
    }

    public function get_keywords(){
        return ['video','gallery','product video gallery'];
    }

    protected function _register_controls() {

         $this->start_controls_section(
            'product_thumbnails_content',
            array(
                'label' => __( 'Video Thumbnails', 'woofall' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );
            
            $this->add_control(
                'tab_thumbnails_position',
                [
                    'label'   => __( 'Thumbnails Position', 'woofall' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'woofall' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'woofall' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'top' => [
                            'title' => __( 'Top', 'woofall' ),
                            'icon'  => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', 'woofall' ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => 'bottom',
                    'toggle'      => false,
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();
        
        // Product Main Image Style
        $this->start_controls_section(
            'product_image_style_section',
            [
                'label' => __( 'Main Video Area', 'woofall' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'main_video_height',
                [
                    'label' => __( 'Height', 'plugin-domain' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 550,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .embed-responsive' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_image_border',
                    'label' => __( 'Product image border', 'woofall' ),
                    'selector' => '{{WRAPPER}} .woofall-product-gallery-video',
                ]
            );

            $this->add_responsive_control(
                'product_image_border_radius',
                [
                    'label' => __( 'Border Radius', 'woofall' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woofall-product-gallery-video img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .woofall-product-gallery-video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .embed-responsive' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_margin',
                [
                    'label' => __( 'Margin', 'woofall' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woofall-product-gallery-video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Product Thumbnails Image Style
        $this->start_controls_section(
            'product_image_thumbnails_style_section',
            [
                'label' => __( 'Thumbnails', 'woofall' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_thumbnais_image_border',
                    'label' => __( 'Product image border', 'woofall' ),
                    'selector' => '{{WRAPPER}} .woofall-product-video-tabs li a',
                ]
            );

            $this->add_responsive_control(
                'product_thumbnais_image_border_radius',
                [
                    'label' => __( 'Border Radius', 'woofall' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woofall-product-video-tabs li a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .woofall-product-video-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_product_thumbnais_padding',
                [
                    'label' => __( 'Padding', 'woofall' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woofall-product-video-tabs li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    protected function render() {
        $settings  = $this->get_settings_for_display();

        $this->add_render_attribute( 'wf_product_thumbnails_attr', 'class', 'wfpro-product-videothumbnails thumbnails-tab-position-'.$settings['tab_thumbnails_position'] );

        if( Plugin::instance()->editor->is_edit_mode() ){
            $product = wc_get_product( woofall_get_last_product_id() );
        } else{
            global $product;
        }

        if ( empty( $product ) ) { return; }
        $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
        if ( $product->get_image_id() ){
            array_unshift( $gallery_images_ids, $product->get_image_id() );
        }

        ?>

        <div <?php echo $this->get_render_attribute_string( 'wf_product_thumbnails_attr' ); ?>>
            <div class="wf-thumbnails-image-area">

                    <?php if( $settings['tab_thumbnails_position'] == 'left' || $settings['tab_thumbnails_position'] == 'top' ): ?>
                        <ul class="woofall-product-video-tabs">
                            <?php
                                $j=0;
                                foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                    $j++;
                                    if( $j == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                    $video_url = get_post_meta( $gallery_attachment_id, 'woofall_video_url', true );
                                    ?>
                                    <li class="<?php if( !empty( $video_url ) ){ echo 'wfvideothumb'; }?>">
                                        <a class="<?php echo $tabactive; ?>" href="#wfvideo-<?php echo $j; ?>">
                                            <?php
                                                if( !empty( $video_url ) ){
                                                    echo '<span class="wfvideo-button"><i class="sli sli-control-play"></i></span>';
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }else{
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }
                                            ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>
                    <?php endif; ?>

                    <div class="woofall-product-gallery-video">
                        <?php
                            $i = 0;
                            foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                $i++;
                                if( $i == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                $video_url = get_post_meta( $gallery_attachment_id, 'woofall_video_url', true );
                                ?>
                                <div class="video-cus-tab-pane <?php echo $tabactive; ?>" id="wfvideo-<?php echo $i; ?>">
                                    <?php
                                        if( !empty( $video_url ) ){
                                            ?>
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <?php echo wp_oembed_get( $video_url ); ?>
                                                </div>
                                            <?php
                                        }else{
                                            echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_single' );
                                        }
                                    ?>
                                </div>
                                <?php
                            }
                        ?>
                    </div>

                    <?php if( $settings['tab_thumbnails_position'] == 'right' || $settings['tab_thumbnails_position'] == 'bottom' ): ?>

                        <ul class="woofall-product-video-tabs">
                            <?php
                                $j=0;
                                foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                    $j++;
                                    if( $j == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                    $video_url = get_post_meta( $gallery_attachment_id, 'woofall_video_url', true );
                                    ?>
                                    <li class="<?php if( !empty( $video_url ) ){ echo 'wfvideothumb'; }?>">
                                        <a class="<?php echo $tabactive; ?>" href="#wfvideo-<?php echo $j; ?>">
                                            <?php
                                                if( !empty( $video_url ) ){
                                                    echo '<span class="wfvideo-button"><i class="sli sli-control-play"></i></span>';
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }else{
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }
                                            ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>

                    <?php endif; ?>
                    
            </div>
        </div>

        <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WF_Product_Video_Gallery_ELement() );