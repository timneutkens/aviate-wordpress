<?php
namespace WeProvide\Aviate\WordPress;

use WeProvide\Aviate\Aviate;

class Bridge extends Aviate {
    // Required function for you to implement. This should return the directory that has the aviate.config.js
    public function getProjectRoot(): string {
        if(!defined('PROJECT_ROOT')) {
            throw new Exception('Please define PROJECT_ROOT variable for Aviate to work');
        }

        return PROJECT_ROOT;
    }

    public function isDevelopment(): bool {
        if(!defined('WP_ENV')) {
            return false;
        }
        
        return WP_ENV === 'development';
    }

    public function getProductionUrl($name): string {
        return get_template_directory_uri().'/dist/'.$name;
    }

    // Return a nested array with Javascript and CSS files to be included into the page.
    public function getFiles(): array {
        $types = parent::getFiles();

        if($this->isDevelopment()) {
            // In development css is injected from Javascript to provide hot reloading.
            $types['js'][] = $this->getDevServerUrl('styles.js');
            $types['js'][] = $this->getDevServerUrl('javascript.js');
            return $types;
        }
        
        // In production we load an actual CSS file             
        $types['css'][] = $this->getProductionUrl('styles.css');
        $types['js'][] = $this->getProductionUrl('javascript.js');        
        return $types;
    }
}
