<?php

/**
 * API Post Controller
 */
function api_get_posts()
{
    $post_type = $_POST['post_type'] ? $_POST['post_type'] : 'post';
    $posts_per_page = $_POST['posts_per_page'] ? $_POST['posts_per_page'] : get_option('posts_per_page');
    $paged = $_POST['paged'] ? $_POST['paged'] : 1;

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page,
        'paged' => $paged
    );
    $query = new WP_Query($args);
    $total_posts = count($query->posts);
    foreach ($query->posts as $post) {
                // collect post

        $post_tags = wp_get_post_tags($post->ID);
        if ($post_tags) foreach ($post_tags as $tag) {
            $tags = array(
                'ID' => $tag->ID,
                'link' => get_permalink($tag->slug),
                'slug' => $tag->slug,
                'name' => $tag->name
            );
        }

        $posts[] = array(
            'ID' => $post->ID,
            'thumbnail' => get_the_post_thumbnail_url($post->ID),
            'title' => $post->post_title,
            'excerpt' => $post->excerpt,
            'link' => get_permalink($post->ID),
            'date' => $post->post_date,
            'tags' => $tags
        );
    }

    $meta = array(
        'total_posts' => $total_posts,
        'current_page' => $paged,
        'prev_page' => $paged <= 1 ? null : $paged - 1,
        'next_page' => $paged < $query->max_num_pages ? $paged + 1 : null,
        'load_more_label' => __('Load More', 'codein_theme'),
        'total_pages' => $query->max_num_pages
    );


    wp_send_json(array(
        'posts' => $posts,
        'meta' => $meta
    ));

    // wp_die();
}

add_action('wp_ajax_api_get_posts', 'api_get_posts');
add_action('wp_ajax_nopriv_api_get_posts', 'api_get_posts');

