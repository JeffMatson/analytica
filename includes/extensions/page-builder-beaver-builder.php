<?php
namespace Analytica\Extensions\Page_Builder;

/**
 * This file is a part of the Analytica core.
 * Please be cautious editing this file,
 *
 * @package  Analytica\Extensions\Page_Builder\Beaver_Builder
 * @subpackage  Analytica
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

use FLBuilderModel;

/**
 * Elementor Compatibility
 *
 * @since 1.0.0
 */
class Beaver_Builder {

    /**
     * Constructor
     */
    public function __construct() {
        if ( ! $this->is_builder_activated() ) {
            return;
        }
        add_filter( 'analytica_is_builder_page', [ $this, 'is_live_builder_page'], 10, 2 );
        add_filter( 'analytica_builder_is_active', [ $this, 'is_builder_activated'] );
    }

    /**
     * Check is builder activated.
     *
     * @param int $id Post/Page Id.
     * @return boolean
     */
    function is_builder_activated( $retval = false ) {

        $retval = false;

        if ( analytica_detect_plugin( array( 'classes' => array( 'FLBuilderModel' ) ) ) ) {
            $retval = true;
        }

        return $retval;
    }

    /**
     * Detect builder page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function is_live_builder_page( $retval, $post_id ) {

        $do_render = apply_filters( 'fl_builder_do_render_content', true, FLBuilderModel::get_post_id() );

		if ( $do_render && FLBuilderModel::is_builder_enabled() ) {
			$retval = true;
		}

        return $retval;
    }
}
