<?php

/**
 * Module: +++MODULE+++
 *
 * @param    array        $block      The block settings and attributes.
 * @param    string       $content    The block inner HTML (empty).
 * @param    bool         $is_preview True during AJAX preview.
 * @param    (int|string) $post_id    The post ID this block is saved to.
 */
 
$id = '+++MODULE+++-' . $block['id'];
$name = "+++MODULE+++";

if ($is_preview) {
    echo '<link href="/wp-content/themes/+++REPLACE_THEME_NAME+++/_blocks/' . $name . '.css" rel="stylesheet" type="text/css">';
}

?>
