<?php
/**
	* Plugin Name: Remove Gravity Forms License Notice
	* Plugin URI: https://wordpress.org/plugins/wpspring-remove-gravity-forms-license-notice/
	* Description: This plugin makes it easy to remove the Gravity Forms license notice from the WP Admin plugins page.
	* Version: 1.0.2
	* Author: WPspring
	* Author URI: https://wpspring.com/
	* Requires at least: 3.0
	* Tested up to: 4.9.5
	*
	* @author WPspring
	*/

if ( !class_exists( 'WPspring_Remove_Gravity_Forms_License_Notice' ) ) :

class WPspring_Remove_Gravity_Forms_License_Notice {

	public function __construct() {

		add_action( 'init', array( $this, 'init' ), 99 );

	}

	public function init() {

		if ( is_admin() && class_exists( 'GFForms') && null !== RG_CURRENT_PAGE && RG_CURRENT_PAGE == "plugins.php" ) {

			// Gravity Forms Core
			remove_action( 'after_plugin_row_gravityforms/gravityforms.php', array( 'GFForms', 'plugin_row' ) );

			// Legacy PayPal Pro Add-On
			if ( is_plugin_active( 'gravityformspaypalpro/paypalpro.php' ) ) {

				remove_action( 'after_plugin_row_gravityformspaypalpro/paypalpro.php', array( 'GFPayPalPro', 'plugin_row' ) );

			}

			// Gravity Forms Zapier Add-On
   if ( is_plugin_active( 'gravityformszapier/zapier.php' ) ) {

    remove_action( 'after_plugin_row_gravityformszapier/zapier.php', array( 'GFZapier', 'plugin_row' ) );

   }

			// Gravity Forms Add-Ons
			$plugin_paths_array = array(

				'gravityformsactivecampaign/activecampaign.php',
				'gravityformsaweber/aweber.php',
				'gravityformscampaignmonitor/campaignmonitor.php',
				'gravityformscleverreach/cleverreach.php',
				'gravityformsemma/emma.php',
				'gravityformsgetresponse/getresponse.php',
				'gravityformsicontact/icontact.php',
				'gravityformsmadmimi/madmimi.php',
				'gravityformsmailchimp/mailchimp.php',
				'gravityformsagilecrm/agilecrm.php',
				'gravityformsauthorizenet/authorizenet.php',
				'gravityformsbatchbook/batchbook.php',
				'gravityformsbreeze/breeze.php',
				'gravityformscampfire/campfire.php',
				'gravityformscapsulecrm/capsulecrm.php',
				'gravityformschainedselects/chainedselects.php',
				'gravityformscoupons/coupons.php',
				'gravityformsdropbox/dropbox.php',
				'gravityformsfreshbooks/freshbooks.php',
				'gravityformshelpscout/helpscout.php',
				'gravityformshighrise/highrise.php',
				'gravityformshipchat/hipchat.php',
				'gravityformspartialentries/partialentries.php',
				'gravityformspaypal/paypal.php',
				'gravityformspaypalpaymentspro/paypalpaymentspro.php',
				'gravityformspipe/pipe.php',
				'gravityformspolls/polls.php',
				'gravityformsquiz/quiz.php',
				'gravityformssignature/signature.php',
				'gravityformsslack/slack.php',
				'gravityformsstripe/stripe.php',
				'gravityformssurvey/survey.php',
				'gravityformstrello/trello.php',
				'gravityformstwilio/twilio.php',
				'gravityformsuserregistration/userregistration.php',
				'gravityformswebhooks/webhooks.php',
				'gravityformszohocrm/zohocrm.php'

			);

			foreach ( $plugin_paths_array as $plugin_path ) {

				if ( is_plugin_active( $plugin_path ) ) {

					$this->wpspring_remove_anonymous_object_filter( 'after_plugin_row_' . $plugin_path, 'GFAutoUpgrade', 'rg_plugin_row' );

				}

			}

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

$GLOBALS['wpspring_remove_gravity_forms_license_notice'] = new WPspring_Remove_Gravity_Forms_License_Notice();

endif;
