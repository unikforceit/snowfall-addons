<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WF_Product_Title_Element extends Widget_Base {

    public function get_name() {
        return 'wf-single-product-title';
    }

    public function get_title() {
        return __( 'WF - Product title', 'woofall' );
    }

    public function get_icon() {
        return 'eicon-product-title';
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
        return ['product title','product','title'];
    }

    protected function _register_controls() {


        // Slider Button stle
        $this->start_controls_section(
            'wf_product_title_content',
            [
                'label' => __( 'Product Title', 'woofall' ),
            ]
        );
            $this->add_control(
                'wf_product_title_html_tag',
                [
                    'label'   => __( 'Title HTML Tag', 'woofall' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => woofall_html_tag_lists(),
                    'default' => 'h2',
                ]
            );

        $this->end_controls_section();

        // Product Style
        $this->start_controls_section(
            'product_style_section',
            array(
                'label' => __( 'Product Title', 'woofall' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'wf_product_title_color',
                [
                    'label'     => __( 'Title Color', 'woofall' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wf_product_title' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'wf_product_title_typography',
                    'label'     => __( 'Typography', 'woofall' ),
                    'selector'  => '{{WRAPPER}} .wf_product_title',
                )
            );

            $this->add_responsive_control(
                'wf_product_title_margin',
                [
                    'label' => __( 'Margin', 'woofall' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wf_product_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'wf_product_title_align',
                [
                    'label'        => __( 'Alignment', 'woofall' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'woofall' ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'woofall' ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'woofall' ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'prefix_class' => 'elementor-align-%s',
                    'default'      => 'left',
                ]
            );

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {
        $settings   = $this->get_settings_for_display();

        $title_html_tag = woofall_validate_html_tag( $settings['wf_product_title_html_tag'] );

        if( Plugin::instance()->editor->is_edit_mode() ){
            $title = get_the_title( woofall_get_last_product_id() );
            echo sprintf( "<%s class='wf_product_title entry-title'>%s</%s>", $title_html_tag, $title, $title_html_tag );
        }else{
            echo sprintf( "<%s class='wf_product_title entry-title'>%s</%s>", $title_html_tag, get_the_title(), $title_html_tag  );
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WF_Product_Title_Element() );
