<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     http://qazana.net/
 */

add_action( 'customize_register', 'analytica_customizer_controls', 5 );
/**
 * Load controls after plugins
 *
 * @return void
 */
function analytica_customizer_controls() {
    if ( class_exists('Kirki') ) {
        require_once get_theme_file_path( '/includes/classes/customizer/controls/dimensions/dimensions.php' );
        require_once get_theme_file_path( '/includes/classes/customizer/controls/icon-select/icon-select.php' );
        require_once get_theme_file_path( '/includes/classes/customizer/controls/image-gallery/image-gallery.php' );
    }
}