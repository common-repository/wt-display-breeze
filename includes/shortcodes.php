<?php

/*-----------------------------------------------------------------------------------*/
/* Shortcode for displaying ajax giving form  */
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'wt_breeze_giving', 'wt_breeze_giving_shortcode' );

function wt_breeze_giving_shortcode( $wt_atts ) {
	global $wtbreeze_add_script, $wt_option_breeze_subdomain, $wtbreeze_add_contrib_script;
	$wtbreeze_add_script         = true;
	$wtbreeze_add_contrib_script = true;

	if ( $_SERVER["HTTPS"] != "on" ) {
		header( "Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );
		exit();
	}

	echo '<div id="breeze_giving_embed" data-subdomain="' . $wt_option_breeze_subdomain . '"></div>';
}


/*-----------------------------------------------------------------------------------*/
/* Shortcode Generator for full calendar */
/*-----------------------------------------------------------------------------------*/

add_filter( 'media_upload_tabs', 'wt_breeze_donate_tab' );

function wt_breeze_donate_tab( $tabs ) {
	$newtab = array( 'wt_breeze_donate_tab' => __( 'Breeze Donate Form', 'insertgmap' ) );

	return array_merge( $tabs, $newtab );
}

add_action( 'media_upload_wt_breeze_donate_tab', 'wt_breeze_donate_upload_tab' );

function wt_breeze_donate_upload_tab() {
	global $errors;

	return wp_iframe( 'wt_breeze_donate_form', $errors );
}

function wt_breeze_donate_form() {
	?>
    <script>
        function PydInsertbreezedonate() {

            parent.send_to_editor("[wt_breeze_giving]");
        }
    </script>

    <div id="pyd_select_donate_breeze_form">
        <div class="wrap">
            <div>

                <div style="padding:10px 15px 0 15px;">
                    <p><strong>Pleaes note, the use of this form requires SSL encryption.</strong></p>
                    <p>If you insert this shortcode it will force your page to redirect to https.</p>
                    <p>If there is no SSL cert installed on your server your website will error out.</p>
                </div>

                <div style="padding:15px;">
                    <input type="button" class="button-primary" value="Insert Breeze Donation Form"
                           onclick="PydInsertbreezedonate();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#"
                       onclick="tb_remove(); return false;"><?php _e( "Cancel", "pydnet" ); ?></a>
                </div>
            </div>
        </div>
    </div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Shortcode for displaying Breeze full calendar  */
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'wt_breeze_full_cal', 'wt_breeze_full_cal_shortcode' );

function wt_breeze_full_cal_shortcode( $wt_atts ) {
	global $wtbreeze_add_script, $wt_option_breeze_subdomain;
	$wtbreeze_add_script = true;

	$wt_atts = shortcode_atts( array(
		'cal_size'  => 'medium',
		'cal_color' => 'defined',
		'cal_ids'   => '',
	), $wt_atts, 'wt_breeze_full_cal' );

	$cal_size  = $wt_atts['cal_size'];
	$cal_color = $wt_atts['cal_color'];
	$cal_ids   = $wt_atts['cal_ids'];

	if ( $cal_ids != null ) {
		$cal_ids = str_replace( ",", "---", $cal_ids );
	}

	if ( $cal_size == 'small' ) {
		$wt_cal_width  = '500';
		$wt_cal_height = '400';
	} elseif ( $cal_size == 'medium' ) {
		$wt_cal_width  = '700';
		$wt_cal_height = '800';
	} elseif ( $cal_size == 'large' ) {
		$wt_cal_width  = '900';
		$wt_cal_height = '1000';
	} else {
		$wt_cal_width  = '700';
		$wt_cal_height = '800';
	}

	ob_start();
	?>
    <iframe src="https://<?php echo $wt_option_breeze_subdomain; ?>.breezechms.com/embed/calendar/grid?size=<?php echo $cal_size; ?>&color=<?php echo $cal_color; ?>&calendars=<?php echo $cal_ids; ?>"
            seamless="seamless" width="<?php echo $wt_cal_width; ?>" height="<?php echo $wt_cal_height; ?>"
            scrolling="auto" frameborder="0"
            style="border-width: 0px;"></iframe>
	<?php

	$output_string = ob_get_contents();
	ob_end_clean();

	return $output_string;
}


/*-----------------------------------------------------------------------------------*/
/* Shortcode Generator for full calendar */
/*-----------------------------------------------------------------------------------*/

add_filter( 'media_upload_tabs', 'wt_breeze_fullcal_tab' );

function wt_breeze_fullcal_tab( $tabs ) {
	$newtab = array( 'wt_breeze_fullcal_tab' => __( 'Breeze Full Calendar', 'insertgmap' ) );

	return array_merge( $tabs, $newtab );
}

add_action( 'media_upload_wt_breeze_fullcal_tab', 'wt_breeze_fullcal_upload_tab' );

function wt_breeze_fullcal_upload_tab() {
	global $errors;

	return wp_iframe( 'wt_breeze_fullcal_form', $errors );
}

function wt_breeze_fullcal_form() {
	global $wt_breeze_calendars_trans;
	$wt_cal_id_array = array();
	foreach ( $wt_breeze_calendars_trans as $wt_cal_id ) {
		$wt_cal_id_array[ $wt_cal_id->name ] = $wt_cal_id->embed_key;
	}
	?>
    <script>

        function PydInsertbreezefullcal() {
            var breeze_cal = '';
            jQuery('.wt_add_cals:checked').each(function () {
                breeze_cal += jQuery(this).val() + ",";
            });
            breeze_cal = breeze_cal.slice(0, -1);

            var breeze_cal_size = jQuery("#wt_cal_size").val();
            var breeze_cal_color = jQuery("#wt_cal_color").val();

            parent.send_to_editor("[wt_breeze_full_cal cal_size=\"" + breeze_cal_size + "\" cal_color=\"" + breeze_cal_color + "\" cal_ids=\"" + breeze_cal + "\" ]");
        }
    </script>

    <div id="pyd_select_fullcal_breeze_form">
        <div class="wrap">
            <div>

                <div style="padding:10px 15px 0 15px;">
                    <label for="wt_cal_size"><?php _e( "Calendar Size: ", "pydnet" ); ?></label>
                    <br/>
                    <select id="wt_cal_size">
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <label for="wt_cal_color"><?php _e( "Calendar Color: ", "pydnet" ); ?></label>
                    <br/>
                    <select id="wt_cal_color">
                        <option value="grey">Gray</option>
                        <option value="green">Green</option>
                        <option value="blue">Blue</option>
                        <option value="orange">Orange</option>
                        <option value="red">Red</option>
                        <option value="defined">Same as calendar</option>
                    </select>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <label for="wt_add_cals"><?php _e( "Calendars to List: ", "pydnet" ); ?></label>
                    <br/>
					<?php
					foreach ( $wt_cal_id_array as $wt_cal_id_key => $wt_cal_value ) {
						echo '<input type="checkbox" class="wt_add_cals" value="' . $wt_cal_value . '">' . $wt_cal_id_key . '<br/>';
					}
					?>
                </div>

                <div style="padding:15px;">
                    <input type="button" class="button-primary" value="Insert Breeze Calendar"
                           onclick="PydInsertbreezefullcal();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#"
                       onclick="tb_remove(); return false;"><?php _e( "Cancel", "pydnet" ); ?></a>
                </div>
            </div>
        </div>
    </div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Shortcode for displaying Breeze campaigns  */
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'wt_breeze_campaigns', 'wt_breeze_campaigns_shortcode' );

function wt_breeze_campaigns_shortcode( $wt_atts ) {
	global $wtbreeze_add_script, $wt_breeze_campaign_trans, $wt_breeze_contrib_trans;
	$wtbreeze_add_script = true;

	$wt_atts = shortcode_atts( array(
		'campaign'           => '',
		'show_pledges'       => '',
		'show_pledge_amount' => '',
		'currency_symbol'    => '',
		'contrib_amount'     => '',
		'contrib_name'       => '',
		'contrib_date'       => '',
		'contrib_title'      => ''
	), $wt_atts, 'wt_breeze_campaigns' );

	$wt_campaign           = $wt_atts['campaign'];
	$wt_show_pledges       = $wt_atts['show_pledges'];
	$wt_show_pledge_amount = $wt_atts['show_pledge_amount'];
	$wt_currency_symbol    = $wt_atts['currency_symbol'];
	$wt_contrib_amount     = $wt_atts['contrib_amount'];
	$wt_contrib_name       = $wt_atts['contrib_name'];
	$wt_contrib_date       = $wt_atts['contrib_date'];
	$wt_contrib_title      = $wt_atts['contrib_title'];

	ob_start();

	echo '<div class="wt_breeze_campaign_wrap">';
	foreach ( $wt_breeze_campaign_trans as $wt_breeze_campaign ) {
		if ( $wt_breeze_campaign->id == $wt_campaign ) {
			echo '<h4 class="wt_breeze_campaign_title">' . $wt_breeze_campaign->name . '</h4>';
			if ( $wt_show_pledges == 1 ) {
				echo 'Total number of pledges: ' . $wt_breeze_campaign->number_of_pledges . '<br />';
			}
			if ( $wt_show_pledge_amount == 1 ) {
				echo 'Total amount of pledges: ' . $wt_currency_symbol . $wt_breeze_campaign->total_pledged . '<br />';
			}
			if ( $wt_contrib_amount == 1 || $wt_contrib_name == 1 || $wt_contrib_date == 1 || $wt_contrib_title != null ) {
				if ( $wt_contrib_title != null ) {
					echo '<h5>' . $wt_contrib_title . '</h5>';
				}
				echo '<ul>';
				foreach ( $wt_breeze_contrib_trans[ $wt_campaign ] as $wt_breeze_contribs ) {
					echo '<li>';
					if ( $wt_contrib_date == 1 ) {
						$wt_breeze_contrib_date_ugly = date_create( $wt_breeze_contribs->paid_on );
						$wt_breeze_clean_date        = date_format( $wt_breeze_contrib_date_ugly, "F j, Y" );
						echo $wt_breeze_clean_date . ' ';
					}
					if ( $wt_contrib_name == 1 ) {
						echo $wt_breeze_contribs->first_name . ' ' . $wt_breeze_contribs->last_name . ' ';
					}
					if ( $wt_contrib_date == 1 ) {
						echo $wt_currency_symbol . $wt_breeze_contribs->amount . ' ';
					}
					echo '</l1>';
				}
				echo '</ul>';
			}
		}
	}
	echo '</div>';

	$output_string = ob_get_contents();
	ob_end_clean();

	return $output_string;
}


/*-----------------------------------------------------------------------------------*/
/* Shortcode Generator for campaigns */
/*-----------------------------------------------------------------------------------*/

add_filter( 'media_upload_tabs', 'wt_breeze_campaign_tab' );

function wt_breeze_campaign_tab( $tabs ) {
	$newtab = array( 'wt_breeze_campaign_tab' => __( 'Breeze Campaigns', 'insertgmap' ) );

	return array_merge( $tabs, $newtab );
}

add_action( 'media_upload_wt_breeze_campaign_tab', 'wt_breeze__campaignupload_tab' );

function wt_breeze__campaignupload_tab() {
	global $errors;

	return wp_iframe( 'wt_breeze_campaign_form', $errors );
}

function wt_breeze_campaign_form() {
	global $wt_breeze_campaign_trans;
	?>
    <script>
        function PydInsertbreezeCampaign() {

            var breeze_campaign = jQuery('#wt_breeze_campaigns_select').val();
            var breeze_show_pledges = jQuery('#wt_show_pledges:checked').length;
            var breeze_pledge_amount = jQuery('#show_pledge_amount:checked').length;
            var breeze_currency_label = jQuery('#currency_label').val();
            var breeze_contrib_amount = jQuery('#contrib_amount:checked').length;
            var breeze_contrib_name = jQuery('#contrib_name:checked').length;
            var breeze_contrib_date = jQuery('#contrib_date:checked').length;
            var breeze_contrib_title = jQuery('#contrib_title').val();

            parent.send_to_editor("[wt_breeze_campaigns campaign=\"" + breeze_campaign + "\" show_pledges=\"" + breeze_show_pledges + "\" show_pledge_amount=\"" + breeze_pledge_amount + "\" currency_symbol=\"" + breeze_currency_label + "\" contrib_amount=\"" + breeze_contrib_amount + "\" contrib_name=\"" + breeze_contrib_name + "\" contrib_date=\"" + breeze_contrib_date + "\" contrib_title=\"" + breeze_contrib_title + "\" ]");
        }
    </script>

    <div id="pyd_select_breeze_form">
        <div class="wrap">
            <div>
                <div style="padding:10px 15px 0 15px;">
                    <label
                            for="wt_breeze_campaigns_select"><?php _e( "Select the campaign to show: ", "pydnet" ); ?></label>
                    <br/>
                    <select id="wt_breeze_campaigns_select">
						<?php
						foreach ( $wt_breeze_campaign_trans as $wt_breeze_campaign ) {
							echo '<option value="' . $wt_breeze_campaign->id . '">' . $wt_breeze_campaign->name . '</option>';
						}
						?>
                    </select>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="checkbox"
                           id="wt_show_pledges"
                           value="1">
                    <label for="wt_show_pledges"><?php _e( "Show the number of pledges", "pydnet" ); ?></label>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="checkbox"
                           id="show_pledge_amount"
                           value="1">
                    <label for="show_pledge_amount"><?php _e( "Show the amount of pledged", "pydnet" ); ?></label>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="text" style="width: 35px"
                           id="currency_label">
                    <label for="currency_label"><?php _e( "Currency symbol", "pydnet" ); ?></label>
                </div>

                <div style="padding:0 15px 0 15px;">
                    <h4>Show Contributions</h4>
                    <label for="contrib_title"><?php _e( "Contributions title: ", "pydnet" ); ?></label>
                    <input type="text"
                           id="contrib_title">
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="checkbox"
                           id="contrib_amount" value="1">
                    <label for="contrib_amount"><?php _e( "List the amount of each contribution", "pydnet" ); ?></label>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="checkbox"
                           id="contrib_name" value="1">
                    <label for="contrib_name"><?php _e( "List the person for each contribution", "pydnet" ); ?></label>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="checkbox"
                           id="contrib_date" value="1">
                    <label for="contrib_date"><?php _e( "List the date of each contribution", "pydnet" ); ?></label>
                </div>

                <div style="padding:15px;">
                    <input type="button" class="button-primary" value="Insert Breeze Campaign"
                           onclick="PydInsertbreezeCampaign();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#"
                       onclick="tb_remove(); return false;"><?php _e( "Cancel", "pydnet" ); ?></a>
                </div>
            </div>
        </div>
    </div>
	<?php
}


/*-----------------------------------------------------------------------------------*/
/* Shortcode for displaying Breeze events list  */
/*-----------------------------------------------------------------------------------*/

add_shortcode( 'wt_breeze_list', 'wt_breeze_list_shortcode' );

function wt_breeze_list_shortcode( $wt_atts ) {
	global $wtbreeze_add_script, $wt_breeze_events_trans;
	$wtbreeze_add_script        = true;
	$wt_option_breeze_subdomain = esc_attr( get_option( 'wt_breeze_subdomain' ) );

	$wt_atts = shortcode_atts( array(
		'num_display'  => '10',
		'calendars'    => '',
		'time_display' => '',
		'info_display' => '',
		'location'     => '',
	), $wt_atts, 'wt_breeze_list' );

	$wt_num_display  = $wt_atts['num_display'];
	$wt_calendars    = $wt_atts['calendars'];
	$wt_time_display = $wt_atts['time_display'];
	$wt_info_display = $wt_atts['info_display'];
	$wt_location     = $wt_atts['location'];

	ob_start();
	do_action( 'wt_breeze_before_events_shortcode' );
	$wt_cal_array = explode( ",", $wt_calendars );

	$i = 0;
	echo '<div class="wt_breeze_events_wrap">';
	foreach ( $wt_breeze_events_trans as $wt_breeze_list ) {
		do_action( 'wt_breeze_before_signle_event_shortcode' );
		if ( in_array( $wt_breeze_list['cal_id'], $wt_cal_array ) ) {

			$wt_breeze_date_display = '';
			if ( $wt_breeze_list['start_date'] == $wt_breeze_list['stop_date'] || $wt_breeze_list['stop_date'] == 'none' ) {
				$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'];
			} else {
				$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'] . ' - ' . $wt_breeze_list['stop_day'] . ' ' . $wt_breeze_list['stop_month'] . ' ' . $wt_breeze_list['stop_day_num'] . ', ' . $wt_breeze_list['stop_year'];
			}

			$wt_breeze_time_display = '';
			if ( $wt_time_display == '1' && $wt_breeze_list['start_time'] != '12:00AM' ) {
				$wt_breeze_time_display = $wt_breeze_list['start_time'] . ' - ' . $wt_breeze_list['stop_time'];
			}
			?>
            <div class="wt_breeze_event wt_breeze_cal_<?php echo $wt_breeze_list['cal_id'] ?> wt_breeze_id_<?php echo $wt_breeze_list['id']; ?> wt_breeze_eventid_<?php echo $wt_breeze_list['event_id']; ?> wt_breeze_location_<?php echo $wt_breeze_list['location_id']; ?>">
                <h4 class="wt_breeze_title"><?php echo $wt_breeze_list['name'] ?></h4>
                <span class="wt_breeze_date"><?php echo $wt_breeze_date_display; ?></span>
                <br/>
				<?php if ( $wt_breeze_time_display != null ) { ?>
                    <span class="wt_breeze_time"><?php echo $wt_breeze_time_display; ?></span>
                    <br/>
				<?php }
				if ( $wt_location == '1' && $wt_breeze_list['location_name'] != 'none' ) { ?>
                    <span class="wt_breeze_location"><?php echo $wt_breeze_list['location_name']; ?></span>
                    <br/>
				<?php } ?>
				<?php if ( $wt_info_display == '1' && $wt_breeze_list['details_clean'] != null ) { ?>
                    <p class="wt_breeze_info"><?php echo $wt_breeze_list['details_clean']; ?></p>
				<?php } ?>
            </div>
            <hr class="wt_breeze_hr"/>

			<?php
			$i ++;
			if ( $i == $wt_num_display ) {
				break;
			}
		} elseif ( in_array( 'all', $wt_cal_array ) ) {
			$wt_breeze_date_display = '';
			if ( $wt_breeze_list['start_date'] == $wt_breeze_list['stop_date'] || $wt_breeze_list['stop_date'] == 'none' ) {
				$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'];
			} else {
				$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'] . ' - ' . $wt_breeze_list['stop_day'] . ' ' . $wt_breeze_list['stop_month'] . ' ' . $wt_breeze_list['stop_day_num'] . ', ' . $wt_breeze_list['stop_year'];
			}

			$wt_breeze_time_display = '';
			if ( $wt_time_display == '1' && $wt_breeze_list['start_time'] != '12:00AM' ) {
				$wt_breeze_time_display = $wt_breeze_list['start_time'] . ' - ' . $wt_breeze_list['stop_time'];
			}
			?>
            <div class="wt_breeze_event wt_breeze_cal_<?php echo $wt_breeze_list['cal_id'] ?> wt_breeze_id_<?php echo $wt_breeze_list['id']; ?> wt_breeze_eventid_<?php echo $wt_breeze_list['event_id']; ?> wt_breeze_location_<?php echo $wt_breeze_list['location_id']; ?>">
                <h4 class="wt_breeze_title"><?php echo $wt_breeze_list['name'] ?></h4>
                <span class="wt_breeze_date"><?php echo $wt_breeze_date_display; ?></span>
                <br/>
				<?php if ( $wt_breeze_time_display != null ) { ?>
                    <span class="wt_breeze_time"><?php echo $wt_breeze_time_display; ?></span>
                    <br/>
				<?php }
				if ( $wt_location == '1' && $wt_breeze_list['location_name'] != 'none' ) { ?>
                    <span class="wt_breeze_location"><?php echo $wt_breeze_list['location_name']; ?></span>
                    <br/>
				<?php } ?>
				<?php if ( $wt_info_display == '1' && $wt_breeze_list['details_clean'] != null ) { ?>
                    <p class="wt_breeze_info"><?php echo $wt_breeze_list['details_clean']; ?></p>
				<?php } ?>
            </div>
            <hr class="wt_breeze_hr"/>
			<?php
			$i ++;
			if ( $i == $wt_num_display ) {
				break;
			}
		}
		do_action( 'wt_breeze_after_single_event_shortcode' );
	}
	echo '</div>';

	do_action( 'wt_breeze_after_events_shortcode' );

	$output_string = ob_get_contents();
	ob_end_clean();

	return $output_string;
}


/*-----------------------------------------------------------------------------------*/
/* Shortcode Generator for events */
/*-----------------------------------------------------------------------------------*/

add_filter( 'media_upload_tabs', 'wt_breeze_tab' );

function wt_breeze_tab( $tabs ) {
	$newtab = array( 'wt_breeze_tab' => __( 'Breeze Events List', 'insertgmap' ) );

	return array_merge( $tabs, $newtab );
}

add_action( 'media_upload_wt_breeze_tab', 'wt_breeze_upload_tab' );

function wt_breeze_upload_tab() {
	global $errors;

	return wp_iframe( 'wt_breeze_form', $errors );
}

function wt_breeze_form() {
	global $wt_breeze_calendars_trans;
	?>
    <script>
        function PydInsertbreeze() {
            var breeze_cal = '';
            jQuery('.wt_add_cals:checked').each(function () {
                breeze_cal += jQuery(this).val() + ",";
            });
            breeze_cal = breeze_cal.slice(0, -1);

            var breeze_time = jQuery('#wt_time_show:checked').length;
            var breeze_info = jQuery('#wt_info_display:checked').length;
            var breeze_location = jQuery('#wt_location:checked').length;
            var breeze_num = jQuery("#wt_num_show").val();

            parent.send_to_editor("[wt_breeze_list calendars=\"" + breeze_cal + "\" time_display=\"" + breeze_time + "\" location=\"" + breeze_location + "\" info_display=\"" + breeze_info + "\" num_display=\"" + breeze_num + "\"]");
        }
    </script>

    <div id="pyd_select_breeze_form">
        <div class="wrap">
            <div>

                <div style="padding:10px 15px 0 15px;">
                    <label for="wt_add_cals"><?php _e( "Calendars to List: ", "pydnet" ); ?></label>
                    <br/>
					<?php
					echo '<input type="checkbox" class="wt_add_cals" value="all">Show All Calendars<br/>';
					foreach ( $wt_breeze_calendars_trans as $wt_breeze_cals ) {
						echo '<input type="checkbox" class="wt_add_cals" value="' . $wt_breeze_cals->id . '">' . $wt_breeze_cals->name . '<br/>';
					}
					?>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <label for="wt_num_show"><?php _e( "Amount to display: ", "pydnet" ); ?></label>
                    <br/>
                    <select id="wt_num_show">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <h4>Additional Options</h4>
                    <input type="checkbox"
                           id="wt_time_show"
                           value="1">
                    <label for="wt_time_show"><?php _e( "Display the time", "pydnet" ); ?></label>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="checkbox"
                           id="wt_info_display"
                           value="1">
                    <label for="wt_info_display"><?php _e( "Display the description", "pydnet" ); ?></label>
                </div>

                <div style="padding:10px 15px 0 15px;">
                    <input type="checkbox"
                           id="wt_location"
                           value="1">
                    <label for="wt_location"><?php _e( "Display the location", "pydnet" ); ?></label>
                </div>

                <div style="padding:15px;">
                    <input type="button" class="button-primary" value="Insert Breeze Events"
                           onclick="PydInsertbreeze();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#"
                       onclick="tb_remove(); return false;"><?php _e( "Cancel", "pydnet" ); ?></a>
                </div>
            </div>
        </div>
    </div>
	<?php
}