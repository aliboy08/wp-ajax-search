<?php
$file = '/modules/search/search-ajax.css';
$file .= '?t='.filemtime(FF_DIR.$file);
wp_enqueue_style('search_ajax', FF_URL.$file);

$file = '/modules/search/search-ajax.js';
$file .= '?t='.filemtime(FF_DIR.$file);
wp_enqueue_script('search_ajax', FF_URL.$file, ['jquery'], null, true);
?>
<form class="ff_search_ajax" method="get" action="/" role="search">
    <input class="search_input" type="search" placeholder="Search..." value="" name="s" autocomplete="off">
    <div class="search_submit"><svg aria-hidden="true" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="14" height="14"><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg></div>
    <div class="loading_icon lds-ring"><div></div><div></div><div></div><div></div></div>
    <div class="search_results"></div>
</form>