<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WM_Product_Description_Element extends Widget_Base {

    public function get_name() {
        return 'wm-single-product-description';
    }

    public function get_title() {
        return __( 'WM - Product Description', 'woomentor' );
    }

    public function get_icon() {
        return 'eicon-product-description';
    }

    public function get_categories() {
        return array( 'woomentor' );
    }

    public function get_style_depends(){
        return [
            'woomentor-widgets',
        ];
    }

    public function get_keywords(){
        return ['description','product description','product content'];
    }

    protected function _register_controls() {

        // Product Style
        $this->start_controls_section(
            'product_style_section',
            array(
                'label' => __( 'Style', 'woomentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_responsive_control(
                'text_align',
                [
                    'label' => __( 'Alignment', 'woomentor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'woomentor' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'woomentor' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'woomentor' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'woomentor' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'text_color',
                [
                    'label' => __( 'Text Color', 'woomentor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce_product_description' => 'color: {{VALUE}} !important',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text_typography',
                    'label' => __( 'Typography', 'woomentor' ),
                    'selector' => '{{WRAPPER}} .woocommerce_product_description',
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {
       global $product, $post;
        $product = wc_get_product();
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            echo '<div class="woocommerce_product_description">'.\Woomentor_Data::instance()->default( $this->get_name() ).'</div>';
        }else{
            if ( empty( $product ) ) { return; }
            echo '<div class="woocommerce_product_description">';
                the_content();
            echo '</div>';
        }
    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WM_Product_Description_Element() );
