<?php

/*-----------------------------------------------------------------------------------*/
/* On uninstall clear the options database  */
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
} else {
	delete_option( 'wt_breeze_id' );
	delete_option( 'wt_breeze_subdomain' );
	delete_option( 'wt_breeze_days' );

	unregister_setting( 'wt-breeze-settings-group', 'wt_breeze_id' );
	unregister_setting( 'wt-breeze-settings-group', 'wt_breeze_subdomain' );
	unregister_setting( 'wt-breeze-settings-group', 'wt_breeze_days' );

	delete_transient( 'wt_breeze_campaign_trans' );
	delete_transient( 'wt_breeze_contrib_trans' );
	delete_transient( 'wt_breeze_calendars_trans' );
	delete_transient( 'wt_breeze_events_trans' );
}