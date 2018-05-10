<?php
namespace Analytica;
/**
 * Analytica functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Analytica
 * @since 1.0.0
 */

use WP_Error;
use stdClass;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main Theme Framework Class
 *
 * @since 1.0.0
 */
class Core {

      /**
     * framework version, used for cache-busting of style and script file references.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * @var array Overloads get_option()
     */
    public $options = array();

    /** Radium *************************************************************/

    /**
     * @var analytica The one true instance
     */
    protected static $instance;
 
    /**
     * Arguments for later use
     *
     * @var $args
     *
     * @since 1.0.0
     */
    public $args = [];

    /**
     * [__construct description]
     */
    private function __construct() {}

    /**
     * Main radium Instance
     *
     * Please load it only one time
     * For this, we thank you
     *
     * Insures that only one instance of the analytica exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     *
     * @since  1.0.0
     *
     * @static var array $instance
     * @uses   analytica::setup_globals() Setup the globals needed
     * @uses   analytica::includes() Include the required files
     * @uses   analytica::setup_actions() Setup the hooks and actions
     * @see    analytica()
     * @return The one true analytica
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
            self::$instance->pre();
            self::$instance->setup_globals();
            self::$instance->includes();
            self::$instance->init();
        }

        return self::$instance;
    }

   /**
     * Run the analytica_pre Hook
     *
     * @since 1.0.0
     */
    public function pre() { do_action( 'analytica_pre_init', array( &$this ) ); }

     /**
     * Setup the default hooks and actions
     *
     * @since 1.0.0
     * @access private
     * @todo Not use analytica_is_deactivation()
     * @uses register_activation_hook() To register the activation hook
     * @uses register_deactivation_hook() To register the deactivation hook
     * @uses add_action() To add various actions
     */
    private function setup_actions() {

        // Add actions to plugin activation and deactivation hooks
        add_action( 'activate_'   . $this->theme_slug, 'analytica_activation' );
        add_action( 'deactivate_' . $this->theme_slug, 'analytica_deactivation' );
        
        // If theme is being deactivated, do not add any actions
        
        /** Run the analytica_pre_framework Hook */
        do_action( 'analytica_pre_framework' );

        do_action_ref_array( 'analytica_after_setup_actions', array( &$this ) );

        /** Run the analytica_init hook */
        do_action( 'analytica_init', array( &$this ) );

        /** Run the analytica_setup hook */
        do_action( 'analytica_setup', array( &$this ) );

    }

    /**
     * Set some smart defaults to class variables. Allow some of them to be
     * filtered to allow for early overriding.
     *
     * @since  1.0.0
     *
     * @access private
     * @uses   get_theme_file_path() To generate theme path
     * @uses   get_theme_file_path_uri() To generate bbPress theme url
     * @uses   apply_filters() calls various filters
     */
    public function setup_globals() {
        $this->theme            = wp_get_theme();         // Get Theme data (WP 3.4+)
        $this->theme_version    = $this->theme->version;  // Theme version

        // Setup some base path, name and URL information
        $this->theme_title = apply_filters( 'analytica_theme_title',      $this->theme->name );                          // or $this->theme->title
        $this->theme_slug  = apply_filters( 'analytica_theme_slug',       get_stylesheet() );
        $this->theme_dir   = apply_filters( 'analytica_theme_dir_path',   strtolower( get_template_directory() ) );
        $this->theme_url   = apply_filters( 'analytica_theme_dir_url',    strtolower( get_template_directory_uri() ) );

        // Setup theme Options name - it's not recommended that you change this, if you do you will looses theme option settings and you will need to resave them
        $this->theme_option_name = $this->theme_slug . '_options';  // Theme_options name
        $this->options             = get_option( $this->theme_option_name );  // get theme options so we don't run it all the time
    }

    /**
     * Initialize classes
     *
     * @return void
     */
    public function init() {
        $this->css_generator = new CSS_Generate();
        $this->theme         = new Theme();
        $this->frontend      = new Frontend();
        $this->loop          = new Content\Loop();
    }

    /**
     * Loads all the framework files and features.
     *
     * The analytica_pre_framework action hook is called before any of the files are
     * required().
     *
     * All files can be overriden from a child theme by copying the file into the child theme while maintaining the same path structure
     *
     * @since 1.0.0
     */
    public function includes() {

        // Base Files
        $this->_include_config();
        $this->_include_classes();
        $this->_include_function();

        /* 
        $this->_include_profiles();
        $this->_include_options(); */
        $this->_include_admin();
        $this->_include_structure_base();
        // End base files

        /*
        $this->_include_structure_pages(); */
        $this->_include_structure_post_archives();
        /*
        $this->_include_structure_single_posts();

        $this->_include_menus();
        $this->_include_builder(); */
        $this->_include_extensions(); 
    }

    function _include_classes() {
        require_once get_theme_file_path( '/includes/classes/nav/breadcrumb.php' );
        require_once get_theme_file_path( '/includes/classes/css/css-base.php' );
        require_once get_theme_file_path( '/includes/classes/css/global-css-file.php' );
        require_once get_theme_file_path( '/includes/classes/css/css-generate.php' );
    }

    function _include_config() {
        // First file to load - setup theme environment
        require_once get_theme_file_path( '/includes/config/theme.php' );
        require_once get_theme_file_path( '/includes/config/frontend.php' );
        // require_once get_theme_file_path( '/includes/config/icons.php' );
        // require_once get_theme_file_path( '/includes/config/presets.php' );
        require_once get_theme_file_path( '/includes/config/skin-css.php' );

        require_once get_theme_file_path( '/includes/config/fonts.php' );
        require_once get_theme_file_path( '/includes/config/fonts/families.php' );
        require_once get_theme_file_path( '/includes/config/fonts/data.php' );

        if ( is_admin() ) {
            require_once get_theme_file_path( '/includes/config/metabox/meta-boxes.php' );
        }
    
        require_once get_theme_file_path( '/includes/config/metabox/meta-box-operations.php' );

        require_once get_theme_file_path( '/includes/config/options.php' );
        require_once get_theme_file_path( '/includes/config/strings.php' );
    }

    function _include_function() {
        require_once get_theme_file_path( '/includes/functions/common.php' );
        require_once get_theme_file_path( '/includes/functions/markup.php' );
        require_once get_theme_file_path( '/includes/functions/formatting.php' );
        require_once get_theme_file_path( '/includes/functions/conditionals.php' );

        require_once get_theme_file_path( '/includes/structure/general/template-tags.php' );
        require_once get_theme_file_path( '/includes/structure/general/template-parts.php' );

        require_once get_theme_file_path( '/includes/functions/sidebar-manager.php' );
        require_once get_theme_file_path( '/includes/functions/widgets.php' );
        require_once get_theme_file_path( '/includes/functions/extras.php' );

        /*
        // Used by both front and admin
        require_once get_theme_file_path( '/includes/functions/options.php' );
        require_once get_theme_file_path( '/includes/functions/conditionals.php' );
        require_once get_theme_file_path( '/includes/functions/queries.php' );
        require_once get_theme_file_path( '/includes/functions/layout-page.php' );
        require_once get_theme_file_path( '/includes/functions/common.php' ); // loaded early
        require_once get_theme_file_path( '/includes/functions/slider.php' );

        // Not crucial for the admin
        require_once get_theme_file_path( '/includes/functions/breadcrumb.php' );
        require_once get_theme_file_path( '/includes/functions/colors.php' );
        require_once get_theme_file_path( '/includes/functions/formatting.php' );
        require_once get_theme_file_path( '/includes/functions/images.php' );
        require_once get_theme_file_path( '/includes/functions/markup.php' );
        require_once get_theme_file_path( '/includes/functions/mobile.php' );
        require_once get_theme_file_path( '/includes/functions/upgrade.php' );

        // Load Widgets
        require_once get_theme_file_path( '/includes/functions/widgetize.php' ); // Load Default Widget Areas
        require_once get_theme_file_path( '/includes/functions/qazana.php' ); */
    }

    function _include_profiles() {
        require_once get_theme_file_path( '/includes/config/profiles/customizer/default.php' );
        require_once get_theme_file_path( '/includes/config/profiles/plugins/default.php' );
    }

    function _include_options() {
        if ( ! analytica_detect_plugin( [ 'classes' => [ 'Kirki' ] ] ) ) {
            require_once get_theme_file_path( '/vendor/kirki/kirki.php' );
        }

        require_once get_theme_file_path( '/includes/extensions/customizer/kirki-integration.php' );
        require_once get_theme_file_path( '/includes/extensions/customizer/kirki-custom.php' );

        // Fields
        require_once get_theme_file_path( '/includes/extensions/customizer/fields/html.php' );

        require_once get_theme_file_path( '/includes/config/customizer/01-general.php' );
        require_once get_theme_file_path( '/includes/config/customizer/02-site-header.php' );
        require_once get_theme_file_path( '/includes/config/customizer/03-page-header.php' );
        require_once get_theme_file_path( '/includes/config/customizer/04-site-footer.php' );
        require_once get_theme_file_path( '/includes/config/customizer/05-typography.php' );
        require_once get_theme_file_path( '/includes/config/customizer/06-posts-layout.php' );
        require_once get_theme_file_path( '/includes/config/customizer/07-customizer.php' );
        require_once get_theme_file_path( '/includes/config/customizer/09-comments.php' );
        require_once get_theme_file_path( '/includes/config/customizer/08-breadcrumbs.php' );
        require_once get_theme_file_path( '/includes/config/customizer/04-social-accounts.php' );
        require_once get_theme_file_path( '/includes/config/customizer/10-404.php' );
        require_once get_theme_file_path( '/includes/config/customizer/90-utilities.php' );

        require_once get_theme_file_path( '/includes/extensions/customizer/assets.php' );
    }

    function _include_admin() {
        require_once get_theme_file_path( '/includes/admin/functions.php' );
        // require_once get_theme_file_path( '/includes/admin/assets.php' );
        require_once get_theme_file_path( '/includes/admin/helper.php' );

        // We've separated admin and frontend specific files for the best performance
        if ( is_admin() ) {
            require_once get_template_directory() . '/includes/admin/about-page.php';
        }

        /*require_once get_theme_file_path( '/includes/config/page/layout.php' );
        require_once get_theme_file_path( '/includes/config/page/header.php' );
        require_once get_theme_file_path( '/includes/config/page/footer.php' );
        require_once get_theme_file_path( '/includes/config/page/one-page.php' );

        require_once get_theme_file_path( '/includes/config/posts/audio.php' );
        require_once get_theme_file_path( '/includes/config/posts/gallery.php' );
        require_once get_theme_file_path( '/includes/config/posts/general.php' );
        require_once get_theme_file_path( '/includes/config/posts/layout.php' );
        require_once get_theme_file_path( '/includes/config/posts/video.php' );*/

    }

    function _include_menus() {
        // Load Navigation Tools
        require_once get_theme_file_path( '/includes/classes/nav/megamenu.php' );
        require_once get_theme_file_path( '/includes/functions/menu.php' );

        require_once get_theme_file_path( '/includes/structure/navigation/menu.php' );
    }

    function _include_extensions() {
        // require_once get_theme_file_path( '/includes/extensions/header-composer.php' );
        // require_once get_theme_file_path( '/includes/extensions/skins.php' );
        // require_once get_theme_file_path( '/includes/extensions/metaboxes.php' );
   
        // /**
        //  * Compatibility
        //  */
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-jetpack.php' );
        // require_once get_theme_file_path( '/includes/extensions/woocommerce/class-analytica-woocommerce.php' );
        // require_once get_theme_file_path( '/includes/extensions/lifterlms/class-analytica-lifterlms.php' );
        // require_once get_theme_file_path( '/includes/extensions/learndash/class-analytica-learndash.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-beaver-builder.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-bb-ultimate-addon.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-contact-form-7.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-visual-composer.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-site-origin.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-gravity-forms.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-bne-flyout.php' );
        // require_once get_theme_file_path( '/includes/extensions/class-analytica-ubermeu.php' );

        // // Elementor Compatibility requires PHP 5.4 for namespaces.
        // if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
        // 	require_once get_theme_file_path( '/includes/extensions/class-analytica-elementor.php' );
        // 	require_once get_theme_file_path( '/includes/extensions/class-analytica-elementor-pro.php' );
        // }

        // // Beaver Themer compatibility requires PHP 5.3 for anonymus functions.
        // if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
        // 	require_once get_theme_file_path( '/includes/extensions/class-analytica-beaver-themer.php' );
        // }

    }

    function _include_structure_base() {

        // // General
        // require_once get_theme_file_path( '/includes/structure/general/functions.php' );
        // require_once get_theme_file_path( '/includes/structure/general/layout.php' );
        // require_once get_theme_file_path( '/includes/structure/general/header.php' );
         require_once get_theme_file_path( '/includes/structure/general/site-loop.php' );
        // require_once get_theme_file_path( '/includes/structure/general/css-classes.php' );

        // require_once get_theme_file_path( '/includes/structure/general/site-footer.php' );
        // require_once get_theme_file_path( '/includes/structure/general/sidebar.php' );
        // require_once get_theme_file_path( '/includes/structure/general/comments.php' );
        // require_once get_theme_file_path( '/includes/structure/general/search.php' );
        // require_once get_theme_file_path( '/includes/structure/general/meta.php' );

        // // Load Structure
        // if ( analytica_detect_plugin( [
        //         'functions' => [
        //             'header_composer',
        //         ],
        //     ] ) && header_composer_get_active_header_id()
        // ) {
        //     // this is simpler
        //     // skip header
        // } else {
        //     require_once get_theme_file_path( '/includes/structure/general/site-header.php' );
        // }
    }

    function _include_structure_pages() {
        require_once get_theme_file_path( '/includes/structure/pages/header.php' );
        require_once get_theme_file_path( '/includes/structure/pages/layout.php' );
    }

    function _include_structure_post_archives() {

        require_once get_theme_file_path( '/includes/structure/archives/blog/blog-config.php' );
        require_once get_theme_file_path( '/includes/structure/archives/blog/blog.php' );
        require_once get_theme_file_path( '/includes/structure/archives/blog/single-blog.php' );

        // require_once get_theme_file_path( '/includes/structure/posts/formats/audio.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/formats/gallery.php' );

        // // Post archives - search, taxonomies etc
        // require_once get_theme_file_path( '/includes/structure/posts/archives/layout-loops.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/actions.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/modules.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/schemer.php' );

        // require_once get_theme_file_path( '/includes/structure/posts/archives/inbuilt-posts-loop.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-1.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-2.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-3.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-4.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-5.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-6.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-7.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/card-8.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/box-1.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/list-1.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/loops/list-2.php' );
        // require_once get_theme_file_path( '/includes/structure/posts/archives/ajax/ajax-handler.php' );
     }

    function _include_structure_single_posts() {

        require_once get_theme_file_path( '/includes/structure/posts/single/functions.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/header.php' );

        require_once get_theme_file_path( '/includes/structure/posts/single/classes/base.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/classes/amp.php' );

        require_once get_theme_file_path( '/includes/structure/posts/single/skins/default.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/skins/qazana.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/skins/wide-overlay.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/skins/wide-boxed.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/skins/classic.php' );

        require_once get_theme_file_path( '/includes/structure/posts/single/actions.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/next-post.php' );
        require_once get_theme_file_path( '/includes/structure/posts/single/related-posts.php' );
    }

    function _include_builder() {
        if ( analytica_detect_plugin( [ 'classes' => [ 'Qazana\Plugin' ] ] ) ) {
            require_once get_theme_file_path( '/qazana/functions/conditionals.php' );
            require_once get_theme_file_path( '/qazana/functions/layout.php' );
            require_once get_theme_file_path( '/qazana/functions/integration.php' );
        }
    }
}

/**
 * The main function responsible for returning the one true analytica Instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Thanks bbpress :)
 *
 * Example: <?php $core = analytica(); ?>
 *
 * @return The one true analytica Instance
 */
function analytica() {
    return Core::instance();
}
analytica(); // All systems go
