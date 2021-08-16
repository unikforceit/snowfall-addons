<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WF_Product_Meta_Element extends Widget_Base {

    public function get_name() {
        return 'wf-single-product-meta';
    }

    public function get_title() {
        return __( 'WF - Product Meta', 'woofall' );
    }

    public function get_icon() {
        return 'eicon-product-meta';
    }

    public function get_categories() {
        return array( 'woofall' );
    }

    public function get_style_depends(){
        return [
            'woofall-widgets',
        ];
    }
    public function get_keywords(){
        return ['meta','product meta','meta info'];
    }

    protected function _register_controls() {

        // Product Price Style
        $this->start_controls_section(
            'product_meta_style_section',
            array(
                'label' => __( 'Meta', 'woofall' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'meta_text_color',
                [
                    'label' => __( 'Text Color', 'woofall' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .product_meta' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'meta_link_color',
                [
                    'label' => __( 'Link Color', 'woofall' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .product_meta a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'meta_link_hover_color',
                [
                    'label' => __( 'Link Hover Color', 'woofall' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .product_meta a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'meta_text_typography',
                    'label' => __( 'Typography', 'woofall' ),
                    'selector' => '{{WRAPPER}} .product_meta',
                ]
            );

            $this->add_responsive_control(
                'meta_margin',
                [
                    'label' => __( 'Margin', 'woofall' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .product_meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        global $product;
        $product = wc_get_product();
        
        if( Plugin::instance()->editor->is_edit_mode() ){
            echo \Woofall_Data::instance()->default( $this->get_name() );
        } else{
            if ( empty( $product ) ) { return; }
            woocommerce_template_single_meta();
        }
        

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WF_Product_Meta_Element() );
