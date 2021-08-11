<?php

/**
 * @param $source
 * @param string $img_size
 * @return string
 */
function snowfall_image($source, $img_size = 'full')
{
    if ($source) {
        return wp_get_attachment_image($source['id'], $img_size);
    }
}


/**
 * @param string $tax
 * @return array
 */
function snowfall_category_lists($tax = 'category')
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
function snowfall_get_category_link($style, $taxonomy = 'product_cat')
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
function snowfall_post_lists($post_type = 'product')
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
function snowfall_image_sizes()
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
function snowfall_link($link)
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
function snowfall_odd_even($data)
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
function snowfall_meta($meta = '', $default = null)
{
    $options = get_post_meta(get_the_ID(), '_slidermeta', true);
    return (isset($options[$meta])) ? $options[$meta] : $default;
}

/**
 * @param string $option
 * @param null $default
 * @return |null
 */
function snowfall_option($option = '', $default = null)
{
    $options = get_option('_snowfall'); // Attention: Set your unique id of the framework
    return (isset($options[$option])) ? $options[$option] : $default;
}