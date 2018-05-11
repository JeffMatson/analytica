/**
 * Customizer controls toggles
 *
 * @package Analytica
 */

( function( $ ) {

	/* Internal shorthand */
	var api = wp.customize;

	/**
	 * Trigger hooks
	 */
	ASTControlTrigger = {

	    /**
	     * Trigger a hook.
	     *
	     * @since 1.0.0
	     * @method triggerHook
	     * @param {String} hook The hook to trigger.
	     * @param {Array} args An array of args to pass to the hook.
		 */
	    triggerHook: function( hook, args )
	    {
	    	$( 'body' ).trigger( 'analytica-control-trigger.' + hook, args );
	    },

	    /**
	     * Add a hook.
	     *
	     * @since 1.0.0
	     * @method addHook
	     * @param {String} hook The hook to add.
	     * @param {Function} callback A function to call when the hook is triggered.
	     */
	    addHook: function( hook, callback )
	    {
	    	$( 'body' ).on( 'analytica-control-trigger.' + hook, callback );
	    },

	    /**
	     * Remove a hook.
	     *
	     * @since 1.0.0
	     * @method removeHook
	     * @param {String} hook The hook to remove.
	     * @param {Function} callback The callback function to remove.
	     */
	    removeHook: function( hook, callback )
	    {
		    $( 'body' ).off( 'analytica-control-trigger.' + hook, callback );
	    },
	};

	/**
	 * Helper class that contains data for showing and hiding controls.
	 *
	 * @since 1.0.0
	 * @class ASTCustomizerToggles
	 */
	ASTCustomizerToggles = {

		'analytica-settings[display-site-title]' :
		[
			{
				controls: [
					'analytica-settings[divider-section-header-typo-title]',
					'analytica-settings[font-size-site-title]',
				],
				callback: function( value ) {

					if ( value ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var site_tagline = api( 'analytica-settings[display-site-tagline]' ).get();
					var has_custom_logo = api( 'custom_logo' ).get();
					var has_retina_logo = api( 'analytica-settings[ast-header-retina-logo]' ).get();

					if ( ( value || site_tagline ) && ( has_custom_logo || has_retina_logo ) ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[display-site-tagline]' :
		[
			{
				controls: [
					'analytica-settings[divider-section-header-typo-tagline]',
					'analytica-settings[font-size-site-tagline]',
				],
				callback: function( value ) {

					if ( value ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var site_title = api( 'analytica-settings[display-site-title]' ).get();
					var has_custom_logo = api( 'custom_logo' ).get();
					var has_retina_logo = api( 'analytica-settings[ast-header-retina-logo]' ).get();

					if ( ( value || site_title ) && ( has_custom_logo || has_retina_logo ) ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[ast-header-retina-logo]' :
		[
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var has_custom_logo = api( 'custom_logo' ).get();
					var site_tagline = api( 'analytica-settings[display-site-tagline]' ).get();
					var site_title = api( 'analytica-settings[display-site-title]' ).get();

					if ( ( value || has_custom_logo ) && ( site_title || site_tagline ) ) {
						return true;
					}
					return false;
				}
			},
		],

		'custom_logo' :
		[
			{
				controls: [
					'analytica-settings[logo-title-inline]',
				],
				callback: function( value ) {

					var has_retina_logo = api( 'analytica-settings[ast-header-retina-logo]' ).get();
					var site_tagline = api( 'analytica-settings[display-site-tagline]' ).get();
					var site_title = api( 'analytica-settings[display-site-title]' ).get();

					if ( ( value || has_retina_logo ) && ( site_title || site_tagline ) ) {
						return true;
					}
					return false;
				}
			},
		],

		/**
		 * Section - Header
		 *
		 * @link  ?autofocus[section]=section-header
		 */

		/**
		 * Layout 2
		 */
		// Layout 2 > Right Section > Text / HTML
		// Layout 2 > Right Section > Search Type
		// Layout 2 > Right Section > Search Type > Search Box Type.
		'analytica-settings[header-main-rt-section]' :
		[
			{
				controls: [
					'analytica-settings[header-main-rt-section-html]'
				],
				callback: function( val ) {

					if ( 'text-html' == val ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[header-main-menu-label]',
					'analytica-settings[header-main-menu-label-divider]',
				],
				callback: function( custom_menu ) {
					var menu = api( 'analytica-settings[disable-primary-nav]' ).get();
					if ( !menu || 'none' !=  custom_menu) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[header-display-outside-menu]',
				],
				callback: function( custom_menu ) {
					
					if ( 'none' !=  custom_menu ) {
						return true;
					}
					return false;
				}
			}
		],

		/**
		 * Blog
		 */
		'analytica-settings[blog-width]' :
		[
			{
				controls: [
					'analytica-settings[blog-max-width]'
				],
				callback: function( blog_width ) {

					if ( 'custom' == blog_width ) {
						return true;
					}
					return false;
				}
		}
		],
		'analytica-settings[blog-post-structure]' :
		[
			{
				controls: [
					'analytica-settings[blog-meta]',
				],
				callback: function( blog_structure ) {
					if ( jQuery.inArray ( "title-meta", blog_structure ) !== -1 ) {
						return true;
					}
					return false;
				}
			}
		],

		/**
		 * Blog Single
		 */
		 'analytica-settings[blog-single-post-structure]' :
		[
			{
				controls: [
					'analytica-settings[blog-single-meta]',
				],
				callback: function( blog_structure ) {
					if ( jQuery.inArray ( "single-title-meta", blog_structure ) !== -1 ) {
						return true;
					}
					return false;
				}
			}
		],
		'analytica-settings[blog-single-width]' :
		[
			{
				controls: [
					'analytica-settings[blog-single-max-width]'
				],
				callback: function( blog_width ) {

					if ( 'custom' == blog_width ) {
						return true;
					}
					return false;
				}
		}
		],
		'analytica-settings[blog-single-meta]' :
		[
			{
				controls: [
					'analytica-settings[blog-single-meta-comments]',
					'analytica-settings[blog-single-meta-cat]',
					'analytica-settings[blog-single-meta-author]',
					'analytica-settings[blog-single-meta-date]',
					'analytica-settings[blog-single-meta-tag]',
				],
				callback: function( enable_postmeta ) {

					if ( '1' == enable_postmeta ) {
						return true;
					}
					return false;
				}
		}
		],

		/**
		 * Small Footer
		 */
		'analytica-settings[footer-sml-layout]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-section-1]',
					'analytica-settings[footer-sml-section-2]',
					'analytica-settings[section-ast-small-footer-background-styling]',
					'analytica-settings[ast-small-footer-color]',
					'analytica-settings[ast-small-footer-link-color]',
					'analytica-settings[ast-small-footer-link-hover-color]',
					'analytica-settings[ast-small-footer-bg-img]',
					'analytica-settings[section-ast-small-footer-typography]',
					'analytica-settings[ast-small-footer-text-font]',
					'analytica-settings[footer-sml-divider]',
					'analytica-settings[section-ast-small-footer-layout-info]',
					'analytica-settings[footer-layout-width]',
					'analytica-settings[footer-color]',
					'analytica-settings[footer-link-color]',
					'analytica-settings[footer-link-h-color]',
					'analytica-settings[footer-bg-obj]',
					'analytica-settings[divider-footer-image]',
				],
				callback: function( small_footer_layout ) {

					if ( 'disabled' != small_footer_layout ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[footer-sml-section-1-credit]',
				],
				callback: function( small_footer_layout ) {

					var footer_section_1 = api( 'analytica-settings[footer-sml-section-1]' ).get();

					if ( 'disabled' != small_footer_layout && 'custom' == footer_section_1 ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[footer-sml-section-2-credit]',
				],
				callback: function( small_footer_layout ) {

					var footer_section_2 = api( 'analytica-settings[footer-sml-section-2]' ).get();

					if ( 'disabled' != small_footer_layout && 'custom' == footer_section_2 ) {
						return true;
					}
					return false;
				}
			},
			{
				controls: [
					'analytica-settings[footer-sml-divider-color]',
				],
				callback: function( small_footer_layout ) {

					var border_width = api( 'analytica-settings[footer-sml-divider]' ).get();

					if ( '1' <= border_width && 'disabled' != small_footer_layout ) {
						return true;
					}
					return false;
				}
			},
		],
		'analytica-settings[footer-sml-section-1]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-section-1-credit]',
				],
				callback: function( enabled_section_1 ) {

					var footer_layout = api( 'analytica-settings[footer-sml-layout]' ).get();

					if ( 'custom' == enabled_section_1 && 'disabled' != footer_layout ) {
						return true;
					}
					return false;
				}
			}
		],
		'analytica-settings[footer-sml-section-2]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-section-2-credit]',
				],
				callback: function( enabled_section_2 ) {

					var footer_layout = api( 'analytica-settings[footer-sml-layout]' ).get();

					if ( 'custom' == enabled_section_2 && 'disabled' != footer_layout ) {
						return true;
					}
					return false;
				}
			}
		],

		'analytica-settings[footer-sml-divider]' :
		[
			{
				controls: [
					'analytica-settings[footer-sml-divider-color]',
				],
				callback: function( border_width ) {

					var footer_layout = api( 'analytica-settings[footer-sml-layout]' ).get();

					if ( '1' <= border_width && 'disabled' != footer_layout ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[header-main-sep]' :
		[
			{
				controls: [
					'analytica-settings[header-main-sep-color]',
				],
				callback: function( border_width ) {

					if ( '1' <= border_width ) {
						return true;
					}
					return false;
				}
			},
		],

		'analytica-settings[disable-primary-nav]' :
		[
			{
				controls: [
					'analytica-settings[header-main-menu-label]',
					'analytica-settings[header-main-menu-label-divider]',
				],
				callback: function( menu ) {
					var custom_menu = api( 'analytica-settings[header-main-rt-section]' ).get();
					if ( !menu || 'none' !=  custom_menu) {
						return true;
					}
					return false;
				}
			},
		],

		/**
		 * Footer Widgets
		 */
		'analytica-settings[footer-adv]' :
		[
			{
				controls: [
					'analytica-settings[footer-adv-background-divider]',
					'analytica-settings[footer-adv-wgt-title-color]',
					'analytica-settings[footer-adv-text-color]',
					'analytica-settings[footer-adv-link-color]',
					'analytica-settings[footer-adv-link-h-color]',
					'analytica-settings[footer-adv-bg-obj]',
				],
				callback: function( footer_widget_area ) {

					if ( 'disabled' != footer_widget_area ) {
						return true;
					}
					return false;
				}
			},
		],
		'analytica-settings[shop-archive-width]' :
		[
			{
				controls: [
					'analytica-settings[shop-archive-max-width]'
				],
				callback: function( blog_width ) {

					if ( 'custom' == blog_width ) {
						return true;
					}
					return false;
				}
			}
		],
	};
} )( jQuery );