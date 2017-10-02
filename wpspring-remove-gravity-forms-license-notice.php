<?php
/**
 * Plugin Name: WPspring Remove Gravity Forms License Notice
 * Plugin URI: https://wpspring.com/
 * Description: This plugin makes it easy to remove the Gravity Forms license notice from the WP Admin header and WordPress Admin plugins page.
 * Version: 1.0.0
 * Author: WPspring
 * Author URI: https://wpspring.com
 * Requires at least: 3.0
 * Tested up to: 4.8.2
 *
 * @author WPspring
 */

if(!class_exists('RemoveGravityformsLicenseNotice')) :

class RemoveGravityformsLicenseNotice {
  public function __construct() {
    add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
  }
  public function plugins_loaded() {
    if (is_admin() && class_exists('GFForms') && null !== RG_CURRENT_PAGE && RG_CURRENT_PAGE == "plugins.php") {
      add_action('wp_loaded', 'cleanup_gravityforms_notices', 20);
      function cleanup_gravityforms_notices() {
        remove_action('after_plugin_row_gravityforms/gravityforms.php', array('RGForms', 'plugin_row'));
        //rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformsauthorizenet/authorizenet.php', array('GFAuthorizeNet', 'plugin_row'));
        remove_action('after_plugin_row_gravityformsauthorizenet/authorizenet.php', array('GFAuthorizeNet', 'plugin_row'));
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformsaweber/aweber.php','GFAutoUpgrade','rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformscampaignmonitor/campaignmonitor.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        //rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformscoupons/coupons.php', array('GFCoupons', 'plugin_row'));
        remove_action('after_plugin_row_gravityformscoupons/coupons.php', array('GFCoupons', 'plugin_row'));
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformsfreshbooks/freshbooks.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformsmailchimp/mailchimp.php', 'GFAutoUpgrade', 'rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformspaypal/paypal.php', 'GFAutoUpgrade', 'rg_plugin_row', 10);
        //rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformspaypalpaymentspro/paypalpaymentspro.php', array('GFPayPalPaymentsPro', 'plugin_row'));
        remove_action('after_plugin_row_gravityformspaypalpaymentspro/paypalpaymentspro.php', array('GFPayPalPaymentsPro', 'plugin_row'));
        //rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformspaypalpro', array('GFPayPalPro', 'plugin_row'));
        remove_action('after_plugin_row_gravityformspaypalpro/paypalpro.php', array('GFPayPalPro', 'plugin_row'));
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformspicatcha', array('', 'plugin_row'));
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformspolls/polls.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformsquiz/quiz.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformssignature/signature.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformsstripe/stripe.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformssurvey/survey.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformstwilio/twilio.php','GFAutoUpgrade', 'rg_plugin_row', 10);
        remove_action('after_plugin_row_gravityformsuserregistration/userregistration.php', array('GFUser', 'plugin_row'));
        //rgln_remove_filters_for_anonymous_class('after_plugin_row_gravityformszapier', array('GFZapier', 'plugin_row'));
        remove_action('after_plugin_row_gravityformszapier/zapier.php', array('GFZapier', 'plugin_row'));
        rgln_remove_filters_for_anonymous_class('after_plugin_row_gravity-forms-custom-post-types/gfcptaddon.php', 'GFAutoUpgrade', 'rg_plugin_row', 10);
      }
      // https://github.com/herewithme/wp-filters-extras/blob/master/wp-filters-extras.php
      function rgln_remove_filters_for_anonymous_class( $hook_name = '', $class_name ='', $method_name = '', $priority = 0 ) {
        global $wp_filter;

        // Take only filters on right hook name and priority
        if ( !isset($wp_filter[$hook_name][$priority]) || !is_array($wp_filter[$hook_name][$priority]) )
          return false;

        // Loop on filters registered
        foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {
          // Test if filter is an array ! (always for class/method)
          if ( isset($filter_array['function']) && is_array($filter_array['function']) ) {
            // Test if object is a class, class and method is equal to param !
            if ( is_object($filter_array['function'][0]) && get_class($filter_array['function'][0]) && get_class($filter_array['function'][0]) == $class_name && $filter_array['function'][1] == $method_name ) {
              unset($wp_filter[$hook_name][$priority][$unique_id]);
            }
          }
        }
        return false;
      }
    }
  }
}
$GLOBALS['wpspring_removegravityformslicensenotice'] = new RemoveGravityformsLicenseNotice();
endif;
?>
