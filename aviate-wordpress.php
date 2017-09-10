<?php
/*
Plugin Name:  Aviate WordPress
Description:  Aviate implementation for WordPress
Version:      0.0.1
Author:       Tim Neutkens
Author URI:   https://github.com/timneutkens
License:      MIT License
*/

namespace WeProvide\Aviate\WordPress;
use WeProvide\Aviate\WordPress\Bridge;

function addFiles() {
    $aviate = new Bridge();

    $files = apply_filters('aviate_files', $aviate->getFiles(), $aviate);

    foreach($files as $fileType => $files) {
        foreach($files as $key => $file) {
            if($fileType === 'js') {
                wp_enqueue_script('aviate_'.$fileType.'_'.$key, $file, [], null);                
                continue;
            }

            if($fileType === 'css') {
                wp_enqueue_style('aviate_'.$fileType.'_'.$key, $file, [], null);
                continue;
            }
        }
    }
}

add_action('wp_enqueue_scripts', __NAMESPACE__.'\\addFiles');
