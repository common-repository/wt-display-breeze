<?php
/*
 Plugin Name: Breeze Display
 Plugin URI: https://worshiptimes.org
 Description: A plugin that brings in your Breeze church management software data (events, full calendar, pledges, donations and contributions) for display on your WordPress website. It can be displayed via widget on a sidebar or shortcode within pages and posts. This plugin is built and supported by Worship Times and is not an official product of Breeze.
 Version: 1.2.3
 Author: Michael Gyura
 Author URI: https://worshiptimes.org
*/

/*-----------------------------------------------------------------------------------*/
/* Register Setting  */
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_init', 'wt_breeze_settings_group' );

function wt_breeze_settings_group() {
	register_setting( 'wt-breeze-settings-group', 'wt_breeze_id' );
	register_setting( 'wt-breeze-settings-group', 'wt_breeze_subdomain' );
	register_setting( 'wt-breeze-settings-group', 'wt_breeze_days' );
}

$wt_option_breeze_api_key   = esc_attr( get_option( 'wt_breeze_id' ) );
$wt_option_breeze_subdomain = esc_attr( get_option( 'wt_breeze_subdomain' ) );
$wt_option_breeze_days      = esc_attr( get_option( 'wt_breeze_days' ) );

add_action( 'admin_init', 'wt_breeze_livebar_settings_group' );

function wt_breeze_livebar_settings_group() {
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_livebar_activated' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_date_time' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_date_day' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_date_hour' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_duration' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_layout' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_dismissable' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_message' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_url' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_head_background_color' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_head_button_color' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_breeze_button_text' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_head_text_color' );
	register_setting( 'wt-breeze-livebar-settings-group', 'wt_head_button_text_color' );
}

$wt_livebar_activated      = esc_attr( get_option( 'wt_livebar_activated' ) );
$wt_breeze_date_time       = esc_attr( get_option( 'wt_breeze_date_time' ) );
$wt_breeze_date_day        = esc_attr( get_option( 'wt_breeze_date_day' ) );
$wt_breeze_date_hour       = esc_attr( get_option( 'wt_breeze_date_hour' ) );
$wt_breeze_duration        = esc_attr( get_option( 'wt_breeze_duration' ) );
$wt_breeze_layout          = esc_attr( get_option( 'wt_breeze_layout' ) );
$wt_breeze_dismissable     = esc_attr( get_option( 'wt_breeze_dismissable' ) );
$wt_breeze_message         = esc_attr( get_option( 'wt_breeze_message' ) );
$wt_breeze_url             = esc_attr( get_option( 'wt_breeze_url' ) );
$wt_head_background_color  = esc_attr( get_option( 'wt_head_background_color' ) );
$wt_head_button_color      = esc_attr( get_option( 'wt_head_button_color' ) );
$wt_breeze_button_text     = esc_attr( get_option( 'wt_breeze_button_text' ) );
$wt_head_text_color        = esc_attr( get_option( 'wt_head_text_color' ) );
$wt_head_button_text_color = esc_attr( get_option( 'wt_head_button_text_color' ) );
$wt_breeze_timezone        = get_option( 'timezone_string' );


if ( ! empty( $wt_breeze_date_hour ) ) {
	$wt_breeze_date_hour_clean = str_replace( ':', '-', $wt_breeze_date_hour );
	$wt_breeze_date_time       = $wt_breeze_date_day . '-' . $wt_breeze_date_hour_clean;
}

if ( empty( $wt_breeze_date_time ) ) {
	$wt_breeze_date_time = "0-9-45";
}

if ( empty( $wt_breeze_duration ) ) {
	$wt_breeze_duration = "40";
}

if ( empty( $wt_breeze_layout ) ) {
	$wt_breeze_layout = "sidebar";
}

if ( empty( $wt_breeze_dismissable ) ) {
	$wt_breeze_dismissable = "yes";
}

if ( empty( $wt_breeze_message ) ) {
	$wt_breeze_message = "Join us online this Sunday live at 9am!";
}

if ( empty( $wt_breeze_url ) ) {
	$wt_breeze_url = "";
}

if ( empty( $wt_breeze_button_text ) ) {
	$wt_breeze_button_text = "Watch Live in";
}

if ( empty( $wt_head_background_color ) ) {
	$wt_head_background_color = "#006fba";
}

if ( empty( $wt_head_button_color ) ) {
	$wt_head_button_color = "#003462";
}

if ( empty( $wt_head_text_color ) ) {
	$wt_head_text_color = "#ffffff";
}

if ( empty( $wt_head_button_text_color ) ) {
	$wt_head_button_text_color = "#ffffff";
}

if ( ! empty( $wt_breeze_date_time ) ) {
	$arr_wt_breeze_date_time = explode( "-", $wt_breeze_date_time );
	$day_of_week             = $arr_wt_breeze_date_time[0];
	$day_of_hours            = $arr_wt_breeze_date_time[1];
	$day_of_minutes          = $arr_wt_breeze_date_time[2];
}

if ( ! empty( $wt_livebar_activated ) and ( $wt_livebar_activated == "Activated" ) ) {
	add_action( 'wp_head', 'breeze_livebar_javascript' );
	function breeze_livebar_javascript() {
		global $wt_livebar_activated, $wt_breeze_date_time, $wt_breeze_duration, $wt_breeze_layout, $wt_breeze_dismissable, $wt_breeze_message, $wt_breeze_url, $wt_head_background_color, $wt_head_button_color, $wt_head_text_color, $wt_head_button_text_color, $wt_breeze_button_text, $day_of_week, $day_of_hours, $day_of_minutes, $wt_breeze_timezone;
		?>
        <style>
            .livebar-header {
                position: relative;
            }
        </style>
        <script type="text/javascript"
                src="https://livebar.church/livebar.js"
                data-layout="<?php echo $wt_breeze_layout; ?>"
                data-background-color="<?php echo $wt_head_background_color; ?>"
                data-button-color="<?php echo $wt_head_button_color; ?>"
                data-text-color="<?php echo $wt_head_text_color; ?>"
                data-button-text-color="<?php echo $wt_head_button_text_color; ?>"
                data-button-text="<?php echo $wt_breeze_button_text; ?>"
                data-header-text="<?php echo $wt_breeze_message; ?>"
                data-service-1-day-of-week="<?php echo $day_of_week; ?>"
                data-service-1-hours="<?php echo $day_of_hours; ?>"
                data-service-1-minutes="<?php echo $day_of_minutes; ?>"
                data-service-1-duration-minutes="<?php echo $wt_breeze_duration; ?>"
                data-dismissable="<?php echo $wt_breeze_dismissable; ?>"
                data-live-url="<?php echo $wt_breeze_url; ?>"
                data-timezone="<?php echo $wt_breeze_timezone; ?>"
        ></script>
		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Bring in required files and scripts */
/*-----------------------------------------------------------------------------------*/

require_once( dirname( __FILE__ ) . '/includes/options.php' );

if ( $wt_option_breeze_api_key != null && $wt_option_breeze_subdomain != null && $wt_option_breeze_days != null ) {
	require_once( dirname( __FILE__ ) . '/includes/breeze.php' );
	require_once( dirname( __FILE__ ) . '/includes/process-feeds.php' );
	require_once( dirname( __FILE__ ) . '/includes/shortcodes.php' );
	require_once( dirname( __FILE__ ) . '/includes/widgets.php' );
}

/*-----------------------------------------------------------------------------------*/
/* Bring in needed scripts and files just for the Breeze pages  */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'wt_breeze_register_scripts' );
add_action( 'admin_enqueue_scripts', 'wt_breeze_register_scripts' );
add_action( 'wp_footer', 'wt_breeze_print_scripts' );
add_action( 'wp_footer', 'wt_breeze_print_contrib_scripts' );
add_action( 'admin_footer', 'wt_breeze_print_scripts' );

function wt_breeze_register_scripts() {
	wp_register_style( 'wtbreeze_style', plugins_url( '/includes/style.css', __FILE__ ) );
}

function wt_breeze_print_scripts() {
	global $wtbreeze_add_script;

	if ( ! $wtbreeze_add_script ) {
		return;
	}

	wp_enqueue_style( 'wtbreeze_style' );
}

function wt_breeze_print_contrib_scripts() {
	global $wtbreeze_add_contrib_script;

	if ( ! $wtbreeze_add_contrib_script ) {
		return;
	}
	wp_enqueue_script( 'breeze-script-ui', 'https://www.breezechms.com/js/give.js', array( 'jquery' ) );
}


/*-----------------------------------------------------------------------------------*/
/* Admin Message when plugin needs to be authorized by sermon.net */
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_notices', 'wt_breeze_showAdminMessages' );

function wt_breeze_showAdminMessages() {
	global $wt_option_breeze_api_key, $wt_option_breeze_subdomain, $wt_option_breeze_days;

	if ( $wt_option_breeze_api_key == null || $wt_option_breeze_subdomain == null || $wt_option_breeze_days == null ) {
		echo '<div id="message" class="error"><p><strong>The Breeze plugin needs to be linked with your account.  Please <a href="/wp-admin/options-general.php?page=wt-breeze-settings" title="authorize Breeze">click here</a> to add your Breeze API Key, subdomain and future days</strong></p></div>';
	}
}

/*-----------------------------------------------------------------------------------*/
/* Activation Hook.  Check WP Version */
/*-----------------------------------------------------------------------------------*/

register_activation_hook( __FILE__, 'wt_breeze_activation' );

function wt_breeze_activation() {
	global $wp_version;

	if ( version_compare( $wp_version, "4.9", "<" ) ) {

		deactivate_plugins( basename( __file__ ) );
		wp_die( "This plugin requires WordPress version 4.9 or higher." );
	}
}