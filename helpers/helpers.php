<?php

/**
 * @param $source
 * @param string $img_size
 * @return string
 */
function woomentor_image($source, $img_size = 'full')
{
    if ($source) {
        return wp_get_attachment_image($source['id'], $img_size);
    }
}


/**
 * @param string $tax
 * @return array
 */
function woomentor_category_lists($tax = 'category')
{

    $categories_obj = get_categories('taxonomy=' . $tax . '');
    $categories = array();

    foreach ($categories_obj as $pn_cat) {
        $categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
    }
    return $categories;
}

/**
 * @param $style
 * @param string $taxonomy
 * @return string
 */
function woomentor_get_category_link($style, $taxonomy = 'product_cat')
{

    global $post;
    $output = '';
    $ids = $taxonomy;
    $terms = wp_get_post_terms($post->ID, $ids);
    $separator = $style;
    if ($terms) {
        foreach ($terms as $term) {
            $term_link = get_term_link($term);
            $output .= '<a href="' . esc_url($term_link) . '">' . $term->name . '</a>' . $separator;
        }
    }
    return trim($output, $separator);
}

/**
 * @param string $post_type
 * @return array
 */
function woomentor_post_lists($post_type = 'product')
{
    $args = array(
        'numberposts' => -1,
        'post_type' => $post_type
    );

    $posts = get_posts($args);
    $list = array();
    foreach ($posts as $cpost) {
        $list[$cpost->ID] = $cpost->post_title;
    }
    return $list;
}

/**
 * @return array|false
 */
function woomentor_image_sizes()
{
    $image_sizes = get_intermediate_image_sizes();

    $addsizes = array(
        'full' => 'full',
        'custom' => 'custom',
    );
    $newsizes = array_merge($image_sizes, $addsizes);

    return array_combine($newsizes, $newsizes);
}


/**
 * @param $link
 * @return string
 */
function woomentor_link($link)
{

    $url = $link['url'] ? 'href=' . esc_url($link['url']) . '' : '';
    $ext = $link['is_external'] ? 'target= _blank' : '';
    $link = $url . ' ' . $ext;
    return $link;
}

/**
 * @param $data
 * @return string
 */
function woomentor_odd_even($data)
{
    if ($data % 2 == 0) {
        $data = "Even";
    } else {
        $data = "Odd";
    }
    return $data;
}

/**
 * @param string $meta
 * @param null $default
 * @return |null
 */
function woomentor_meta($meta = '', $default = null)
{
    $options = get_post_meta(get_the_ID(), '_slidermeta', true);
    return (isset($options[$meta])) ? $options[$meta] : $default;
}

/**
 * @param string $option
 * @param null $default
 * @return |null
 */
function woomentor_option($option = '', $default = null)
{
    $options = get_option('_woomentor'); // Attention: Set your unique id of the framework
    return (isset($options[$option])) ? $options[$option] : $default;
}

/**
 * [woomentor_get_taxonomies]
 * @return [array] product texonomies
 */
function woomentor_get_taxonomies( $object = 'product' ) {
    $all_taxonomies = get_object_taxonomies( $object );
    $taxonomies_list = [];
    foreach ( $all_taxonomies as $taxonomy_data ) {
        $taxonomy = get_taxonomy( $taxonomy_data );
        if( $taxonomy->show_ui ) {
            $taxonomies_list[ $taxonomy_data ] = $taxonomy->label;
        }
    }
    return $taxonomies_list;
}

/**
 * Woocommerce Product last product id return
 */
function woomentor_get_last_product_id(){
    global $wpdb;

    // Getting last Product ID (max value)
    $results = $wpdb->get_col( "
        SELECT MAX(ID) FROM {$wpdb->prefix}posts
        WHERE post_type LIKE 'product'
        AND post_status = 'publish'"
    );
    return reset($results);
}

/*
 * HTML Tag list
 * return array
 */
function woomentor_html_tag_lists() {
    $html_tag_list = [
        'h1'   => __( 'H1', 'woomentor' ),
        'h2'   => __( 'H2', 'woomentor' ),
        'h3'   => __( 'H3', 'woomentor' ),
        'h4'   => __( 'H4', 'woomentor' ),
        'h5'   => __( 'H5', 'woomentor' ),
        'h6'   => __( 'H6', 'woomentor' ),
        'p'    => __( 'p', 'woomentor' ),
        'div'  => __( 'div', 'woomentor' ),
        'span' => __( 'span', 'woomentor' ),
    ];
    return $html_tag_list;
}

/*
 * HTML Tag Validation
 * return strig
 */
function woomentor_validate_html_tag( $tag ) {
    $allowed_html_tags = [
        'article',
        'aside',
        'footer',
        'header',
        'section',
        'nav',
        'main',
        'div',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'p',
        'span',
    ];
    return in_array( strtolower( $tag ), $allowed_html_tags ) ? $tag : 'div';
}