<?php
/*-----------------------------------------------------------------------------------*/
/* Add Submenu  */
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_menu', 'register_breeze_submenu_page' );

function register_breeze_submenu_page() {
	add_submenu_page( 'options-general.php', 'Breeze Settings', 'Breeze Settings', 'manage_options', 'wt-breeze-settings', 'wt_breeze_settings' );
}

/*-----------------------------------------------------------------------------------*/
/* Build Options Page  */
/*-----------------------------------------------------------------------------------*/

function wt_breeze_settings() {
	global $wtbreeze_add_script, $wt_breeze_date_day, $wt_breeze_date_hour, $wt_breeze_campaign_trans, $wt_breeze_contrib_trans, $wt_breeze_calendars_trans, $wt_breeze_events_trans, $wt_option_breeze_api_key, $wt_option_breeze_subdomain, $wt_option_breeze_days, $wt_livebar_activated, $wt_breeze_date_time, $wt_breeze_duration, $wt_breeze_layout, $wt_breeze_dismissable, $wt_breeze_message, $wt_breeze_url, $wt_head_background_color, $wt_head_button_color, $wt_head_text_color, $wt_head_button_text_color, $wt_breeze_button_text;
	$wtbreeze_add_script = true;

	/*-----------------------------------------------------------------------------------*/
	/* Get episode data by playlist  */
	/*-----------------------------------------------------------------------------------*/
	?>
    <div class="wrap">
    <h2>Breeze Settings</h2>
    <form method="post" action="options.php">
		<?php settings_fields( 'wt-breeze-settings-group' ); ?>
		<?php do_settings_sections( 'wt-breeze-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Breeze API Key</th>
                <td>
                    <input type="password" class="wt_breeze_text_long"
                           name="wt_breeze_id"
                           value="<?php echo $wt_option_breeze_api_key; ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Breeze Subdomain</th>
                <td>
                    https://<input type="text" class="wt_breeze_text_med"
                                   name="wt_breeze_subdomain"
                                   value="<?php echo $wt_option_breeze_subdomain; ?>"/>.breezechms.com
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Number of Future Days to Get Data For</th>
                <td>
                    <input type="text" class="wt_breeze_text_small"
                           name="wt_breeze_days"
                           value="<?php echo $wt_option_breeze_days; ?>"/> Example: 120
                </td>
            </tr>
        </table>
		<?php submit_button( 'Save Breeze Settings' ); ?>
    </form>

    <h2>Breeze Livebar Settings</h2>
    <form method="post" action="options.php">
		<?php settings_fields( 'wt-breeze-livebar-settings-group' ); ?>
		<?php do_settings_sections( 'wt-breeze-livebar-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Is Activated</th>
                <td>
                    <input type="checkbox" id="livebar_activated"
                           name="wt_livebar_activated" <?php echo ( $wt_livebar_activated == "Activated" ) ? "checked" : ""; ?>
                           value="Activated">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Service/Livestream Day</th>
                <td>
                    <select class="form-control" id="date-time-day" name="wt_breeze_date_day">
                        <option value="0" <?php echo ( $wt_breeze_date_day == "0" ) ? "selected" : ""; ?>>Sundays
                        </option>
                        <option value="1" <?php echo ( $wt_breeze_date_day == "1" ) ? "selected" : ""; ?>>Mondays
                        </option>
                        <option value="2" <?php echo ( $wt_breeze_date_day == "2" ) ? "selected" : ""; ?>>Tuesdays
                        </option>
                        <option value="3" <?php echo ( $wt_breeze_date_day == "3" ) ? "selected" : ""; ?>>Wednesdays
                        </option>
                        <option value="4" <?php echo ( $wt_breeze_date_day == "4" ) ? "selected" : ""; ?>>Thursdays
                        </option>
                        <option value="5" <?php echo ( $wt_breeze_date_day == "5" ) ? "selected" : ""; ?>>Fridays
                        </option>
                        <option value="6" <?php echo ( $wt_breeze_date_day == "6" ) ? "selected" : ""; ?>>Saturdays
                        </option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Service/Livestream Time</th>
                <td>
                    <input type="time" name="wt_breeze_date_hour" id="date-time-hour" class="form-control"
                           value="<?php echo $wt_breeze_date_hour; ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Service Duration</th>
                <td>
                    <select class="form-control" id="duration" name="wt_breeze_duration">
                        <option value="5" <?php echo ( $wt_breeze_duration == "5" ) ? "selected" : ""; ?>>5 Minutes
                        </option>
                        <option value="10" <?php echo ( $wt_breeze_duration == "10" ) ? "selected" : ""; ?>>10 Minutes
                        </option>
                        <option value="15" <?php echo ( $wt_breeze_duration == "15" ) ? "selected" : ""; ?>>15 Minutes
                        </option>
                        <option value="20" <?php echo ( $wt_breeze_duration == "20" ) ? "selected" : ""; ?>>20 Minutes
                        </option>
                        <option value="25" <?php echo ( $wt_breeze_duration == "25" ) ? "selected" : ""; ?>>25 Minutes
                        </option>
                        <option value="30" <?php echo ( $wt_breeze_duration == "30" ) ? "selected" : ""; ?>>30 Minutes
                        </option>
                        <option value="35" <?php echo ( $wt_breeze_duration == "35" ) ? "selected" : ""; ?>>35 Minutes
                        </option>
                        <option value="40" <?php echo ( $wt_breeze_duration == "40" ) ? "selected" : ""; ?>>40 Minutes
                        </option>
                        <option value="45" <?php echo ( $wt_breeze_duration == "45" ) ? "selected" : ""; ?>>45 Minutes
                        </option>
                        <option value="50" <?php echo ( $wt_breeze_duration == "50" ) ? "selected" : ""; ?>>50 Minutes
                        </option>
                        <option value="55" <?php echo ( $wt_breeze_duration == "55" ) ? "selected" : ""; ?>>55 Minutes
                        </option>
                        <option value="60" <?php echo ( $wt_breeze_duration == "60" ) ? "selected" : ""; ?>>60 Minutes
                        </option>
                        <option value="65" <?php echo ( $wt_breeze_duration == "65" ) ? "selected" : ""; ?>>65 Minutes
                        </option>
                        <option value="70" <?php echo ( $wt_breeze_duration == "70" ) ? "selected" : ""; ?>>70 Minutes
                        </option>
                        <option value="75" <?php echo ( $wt_breeze_duration == "75" ) ? "selected" : ""; ?>>75 Minutes
                        </option>
                        <option value="80" <?php echo ( $wt_breeze_duration == "80" ) ? "selected" : ""; ?>>80 Minutes
                        </option>
                        <option value="85" <?php echo ( $wt_breeze_duration == "85" ) ? "selected" : ""; ?>>85 Minutes
                        </option>
                        <option value="90" <?php echo ( $wt_breeze_duration == "90" ) ? "selected" : ""; ?>>90 Minutes
                        </option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Layout</th>
                <td>
                    <select class="form-control" id="layout" name="wt_breeze_layout">
                        <option value="header" <?php echo ( $wt_breeze_layout == "header" ) ? "selected" : ""; ?>>Header
                            Bar
                        </option>
                        <option value="sidebar" <?php echo ( $wt_breeze_layout == "sidebar" ) ? "selected" : ""; ?>>
                            Sidebar Widget
                        </option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Dismissable</th>
                <td>
                    <select class="form-control" id="dismissable" name="wt_breeze_dismissable">
                        <option value="no" <?php echo ( $wt_breeze_dismissable == "no" ) ? "selected" : ""; ?>>No, users
                            cannot close Livebar
                        </option>
                        <option value="yes" <?php echo ( $wt_breeze_dismissable == "yes" ) ? "selected" : ""; ?>>Yes,
                            users can close Livebar
                        </option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Message in Bar</th>
                <td>
                    <input type="text" class="wt_breeze_text_long" id="message" name="wt_breeze_message"
                           value="<?php echo $wt_breeze_message; ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Web address you want people to watch at</th>
                <td>
                    <input type="text" class="wt_breeze_text_long" id="url" name="wt_breeze_url"
                           placeholder="https://www.facebook.com/my-church-page"
                           value="<?php echo $wt_breeze_url; ?>"><br/>
                    <small class="form-text text-muted">
                        This is the website where you want people to go when clicking on the "Watch Live" button. It
                        could be your church Facebook page, a Youtube channel, a Zoom link, or wherever you'd like.
                    </small>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Button Text</th>
                <td>
                    <input type="text" class="wt_breeze_text_long" id="url" name="wt_breeze_button_text"
                           value="<?php echo $wt_breeze_button_text; ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Specify Colors</th>
                <td>
                    <div>
                        <input type="color" id="background-color" name="wt_head_background_color"
                               value="<?php echo $wt_head_background_color; ?>">
                        <label>Background Color</label>
                    </div>
                    <div>
                        <input type="color" id="button-color" name="wt_head_button_color"
                               value="<?php echo $wt_head_button_color; ?>">
                        <label>Button</label>
                    </div>
                    <div>
                        <input type="color" id="text-color" name="wt_head_text_color"
                               value="<?php echo $wt_head_text_color; ?>">
                        <label>Text</label>
                    </div>
                    <div>
                        <input type="color" id="button-text-color" name="wt_head_button_text_color"
                               value="<?php echo $wt_head_button_text_color; ?>">
                        <label>Button Text</label>
                    </div>
                </td>
            </tr>
        </table>
		<?php submit_button( 'Save Breeze Livebar Settings' ); ?>
    </form>
	<?php

	/*-----------------------------------------------------------------------------------*/
	/* Clear Transient if requested  */
	/*-----------------------------------------------------------------------------------*/

	if ( $wt_option_breeze_api_key != null && $wt_option_breeze_subdomain != null && $wt_option_breeze_days != null ) {

		echo '<h3>If needed, use the below steps to force-reset your data from Breeze</h3>';
		echo '<p>This plugin stores your Breeze data in cache for 24 hours.  Following these steps will force the plugin to grab the most recent data.</p>';

		if ( isset( $_GET['breeze_reset'] ) && $_GET['breeze_reset'] == 'dump_data' ) {
			delete_transient( 'wt_breeze_campaign_trans' );
			delete_transient( 'wt_breeze_contrib_trans' );
			delete_transient( 'wt_breeze_calendars_trans' );
			delete_transient( 'wt_breeze_events_trans' );

			echo '1. Delete Breeze data from plugin.<br />';
			echo '<strong> 2. <a href="/wp-admin/options-general.php?page=wt-breeze-settings&breeze_reset=grab_data">Grab new data from Breeze.</a></strong><br />';
			echo '3. Store new data in cache.<br />';
		} elseif ( isset( $_GET['breeze_reset'] ) && $_GET['breeze_reset'] == 'grab_data' ) {
			echo '1. Delete Breeze data from plugin.<br />';
			echo '2. Grab new data from Breeze.<br />';
			echo '<strong> 3. <a href="/wp-admin/options-general.php?page=wt-breeze-settings">Store new data in cache.</a></strong><br />';
		} else {
			echo '<strong> 1. <a href="/wp-admin/options-general.php?page=wt-breeze-settings&breeze_reset=dump_data">Delete Breeze data from plugin.</a></strong><br />';
			echo '2. Grab new data from Breeze.<br />';
			echo '3. Store new data in cache.<br />';
			echo '<h3>Verify Breeze data</h3>';
			echo '<strong><a href="/wp-admin/options-general.php?page=wt-breeze-settings&breeze_reset=verify_data">Display Breeze data used by the plugin</a></strong><br />';

		}

		if ( isset( $_GET['breeze_reset'] ) && $_GET['breeze_reset'] == 'verify_data' ) {
			echo '<h3>Calendar Data</h3>';
			echo '<pre>';
			print_r( $wt_breeze_calendars_trans );
			echo '</pre>';
			echo '<h3>Events Data</h3>';
			echo '<pre>';
			print_r( $wt_breeze_events_trans );
			echo '</pre>';
			echo '<h3>Campaign Data</h3>';
			echo '<pre>';
			print_r( $wt_breeze_campaign_trans );
			echo '</pre>';
			echo '<h3>Contribution Data</h3>';
			echo '<pre>';
			print_r( $wt_breeze_contrib_trans );
			echo '</pre>';
		}
	}
}