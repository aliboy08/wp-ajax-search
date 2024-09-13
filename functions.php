<?php
function ff_search_ajax(){
    $res = [
        'payload' => $_POST,
        'request_time' => $_POST['request_time'],
        'html' => '',
    ];

    $s = $_POST['s'];

    $query_args = [
        'post_type' => 'nlr_product',
        'post_status' => 'publish',
        'showposts' => 10,
        's' => $s,
        'no_found_rows' => true,
    ];

    $q = new WP_Query($query_args);
    if( !$q->posts ) wp_send_json($res);

    foreach( $q->posts as $post ) {
        $link = get_permalink($post);
        $title = $post->post_title;
        $excerpt = get_field('about_content', $post->ID);
        if( $excerpt ) {
            $excerpt = wp_strip_all_tags($excerpt);
            $excerpt = wp_trim_words($excerpt, 20);
        }
        
        $img_html = has_post_thumbnail($post) ? get_the_post_thumbnail($post, 'thumbnail') : '';
        $res['html'] .= "
        <a class='item item_result' href='{$link}'>
            <div class='image image_fit'>{$img_html}</div>
            <div class='s1'>
                <div class='title'>{$title}</div>
                <div class='excerpt limit-lines-2'>{$excerpt}</div>
            </div>
        </a>";
    }

    $res['html'] .= '<a href="/?s='.$s.'" class="see_more">'. __( 'See more results', 'ff' ).'</a>';

    wp_send_json($res);
}
add_action( 'wp_ajax_ff_search_ajax', 'ff_search_ajax' );
add_action( 'wp_ajax_nopriv_ff_search_ajax', 'ff_search_ajax' );