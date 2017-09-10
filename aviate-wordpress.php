<?php
namespace WeProvide\Aviate\WordPress;
use WeProvide\Aviate\WordPresss\Bridge;

function addFiles() {
    $aviate = new Bridge();

    $files = apply_filters('aviate_files', $aviate->getFiles(), $aviate);

    foreach($files as $fileType) {
        foreach($fileType as $key => $file) {
            if($fileType === 'js') {
                wp_enqueue_script('aviate_'.$filetype.'_'.$key, $file);                
                return;
            }

            if($fileType === 'css') {
                wp_enqueue_style('aviate_'.$filetype.'_'.$key, $file);
                return;
            }
        }
    }
}

add_action('wp_enqueue_scripts', __NAMESPACE__.'\\addFiles');
