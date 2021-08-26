<?php
// Control core classes for avoid errors
if (class_exists('CSF')) {

    //
    // Set a unique slug-like ID
    $prefix = '_woomentor';

    //
    // Create options
    CSF::createOptions($prefix, array(
        'menu_title' => 'Woomentor',
        'menu_slug' => 'woomentor',
        'framework_title' => 'Woomentor Addons',
        'menu_position' => 50,
        'nav' => 'inline',
        'theme' => 'light',
        'menu_icon' => 'dashicons-wordpress-alt',
        'show_in_customizer' => true,
        'footer_text' => 'WooMentor Addons',
        'footer_credit' => 'WooMentor Addons by <a href="https://unikforce.com" target="_blank">UnikForce</a>',
        'footer_after' => '<a href="https://unikforce.com" target="_blank">Go Pro</a>',
    ));


//
// Create a section
//
    CSF::createSection( $prefix, array(
        'title'  => 'General',
        'icon'   => 'fas fa-rocket',
        'fields' => array(
            array(
                'id'    => 'wm_builder',
                'type'  => 'switcher',
                'title' => 'Woomentor Builder',
                'label' => 'Woomentor builder to enable features.',
            ),
            array(
                'id'          => 'singleproductpage',
                'type'        => 'select',
                'title'       => 'Select Product Single Template',
                'placeholder' => 'Select Product Single Template',
                'dependency' => ['wm_builder', '==', 'true'],
                'options'     => woomentor_post_lists('elementor_library'),
            ),
            array(
                'id'          => 'productarchivepage',
                'type'        => 'select',
                'title'       => 'Select Shop Template',
                'placeholder' => 'Select Shop Template',
                'dependency' => ['wm_builder', '==', 'true'],
                'options'     => woomentor_post_lists('elementor_library'),
            ),
            array(
                'id'          => 'productallarchivepage',
                'type'        => 'select',
                'title'       => 'Select Product Archive Template',
                'placeholder' => 'Select Product Archive Template',
                'dependency' => ['wm_builder', '==', 'true'],
                'options'     => woomentor_post_lists('elementor_library'),
            ),
        )
    )
    );
}
