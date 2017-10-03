<?php
/**
	* Plugin Name: WPspring Remove Gravity Forms License Notice
	* Plugin URI: https://wpspring.com/
	* Description: This plugin makes it easy to remove the Gravity Forms license notice from the WP Admin plugins page.
	* Version: 1.0.0
	* Author: WPspring
	* Author URI: https://wpspring.com
	* Requires at least: 3.0
	* Tested up to: 4.8.2
	*
	* @author WPspring
	*/

if ( !class_exists( 'RemoveGravityformsLicenseNotice' ) ) :

class RemoveGravityformsLicenseNotice {

	public function __construct() {

		add_action( 'init', array( $this, 'init' ), 99 );

	}

	public function init() {

		if ( is_admin() && class_exists( 'GFForms') && null !== RG_CURRENT_PAGE && RG_CURRENT_PAGE == "plugins.php" ) {

			remove_action( 'after_plugin_row_gravityforms/gravityforms.php', array( 'GFForms', 'plugin_row' ) );

			$this->wpspring_remove_anonymous_object_filter( 'after_plugin_row_gravityformsaweber/aweber.php','GFAutoUpgrade','rg_plugin_row' );

		}

	}

	// https://wordpress.stackexchange.com/questions/57079/how-to-remove-a-filter-that-is-an-anonymous-object/57088#57088
	public function wpspring_remove_anonymous_object_filter( $tag, $class, $method ) {   

		if ( !isset( $GLOBALS['wp_filter'][ $tag ] ) ) {

			return;

		}

		$filters = $GLOBALS['wp_filter'][ $tag ];

		if ( empty ( $filters ) ) {   

			return;

		}

		foreach ( $filters as $priority => $filter ) {   

			foreach ( $filter as $identifier => $function ) {   

				if ( is_array( $function) and is_a( $function['function'][0], $class ) and $method === $function['function'][1] ) {   

					remove_filter( $tag, array ( $function['function'][0], $method ), $priority );

				}

			}

		}

	}

}

$GLOBALS['wpspring_removegravityformslicensenotice'] = new RemoveGravityformsLicenseNotice();

endif;

?>
