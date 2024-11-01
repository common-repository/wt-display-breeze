<?php
global $wt_option_breeze_api_key, $wt_option_breeze_subdomain, $wt_option_breeze_days;
$wt_breeze_api = new Breeze( $wt_option_breeze_api_key );

/*-----------------------------------------------------------------------------------*/
/* Get the list of campaigns from Breeze  */
/*-----------------------------------------------------------------------------------*/

$wt_breeze_campaign_trans = get_transient( 'wt_breeze_campaign_trans' );

if ( $wt_breeze_campaign_trans === false || empty( $wt_breeze_campaign_trans ) ) {
	$wt_breeze_campaigns       = $wt_breeze_api->url( 'https://' . $wt_option_breeze_subdomain . '.breezechms.com/api/pledges/list_campaigns' );
	$wt_breeze_campaigns_array = json_decode( $wt_breeze_campaigns );
	if ( empty( $wt_breeze_campaigns_array ) ) {
		$wt_breeze_campaigns_array = array( 'No Data' );
		set_transient( 'wt_breeze_campaign_trans', $wt_breeze_campaigns_array, 12 * HOUR_IN_SECONDS );
	} else {
		set_transient( 'wt_breeze_campaign_trans', $wt_breeze_campaigns_array, 12 * HOUR_IN_SECONDS );
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get the list of contributions from Breeze  */
/*-----------------------------------------------------------------------------------*/

$wt_breeze_contrib_trans = get_transient( 'wt_breeze_contrib_trans' );

if ( $wt_breeze_contrib_trans === false || empty( $wt_breeze_contrib_trans ) ) {
	if ( $wt_breeze_campaign_trans != null ) {
		$wt_breeze_contributions_array = array();
		foreach ( $wt_breeze_campaign_trans as $wt_breeze_contibs ) {
			${'wt_breeze_contributions_' . $wt_breeze_contibs->id}   = $wt_breeze_api->url( 'https://' . $wt_option_breeze_subdomain . '.breezechms.com/api/giving/list?pledge_ids=' . $wt_breeze_contibs->id );
			$wt_breeze_contributions_array[ $wt_breeze_contibs->id ] = json_decode( ${'wt_breeze_contributions_' . $wt_breeze_contibs->id} );
		}
		if ( empty( $wt_breeze_contributions_array ) ) {
			$wt_breeze_contributions_array = array( 'No Data' );
			set_transient( 'wt_breeze_contrib_trans', $wt_breeze_contributions_array, 4 * HOUR_IN_SECONDS );
		} else {
			set_transient( 'wt_breeze_contrib_trans', $wt_breeze_contributions_array, 4 * HOUR_IN_SECONDS );
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get the list of calendars from Breeze  */
/*-----------------------------------------------------------------------------------*/

$wt_breeze_calendars_trans = get_transient( 'wt_breeze_calendars_trans' );

if ( $wt_breeze_calendars_trans === false || empty( $wt_breeze_calendars_trans ) ) {
	$wt_breeze_calendars      = $wt_breeze_api->url( 'https://' . $wt_option_breeze_subdomain . '.breezechms.com/api/events/calendars/list' );
	$wt_breeze_calendar_array = json_decode( $wt_breeze_calendars );
	if ( empty( $wt_breeze_calendar_array ) ) {
		$wt_breeze_calendar_array = array( 'No Data' );
		set_transient( 'wt_breeze_calendars_trans', $wt_breeze_calendar_array, 4 * HOUR_IN_SECONDS );
	} else {
		set_transient( 'wt_breeze_calendars_trans', $wt_breeze_calendar_array, 4 * HOUR_IN_SECONDS );
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get the list of events from Breeze  */
/*-----------------------------------------------------------------------------------*/

$wt_breeze_events_trans = get_transient( 'wt_breeze_events_trans' );

if ( $wt_breeze_events_trans === false || empty( $wt_breeze_events_trans ) ) {

	$wt_timezone = get_option( 'timezone_string' );
	//date_default_timezone_set( $wt_timezone );
	$wt_breeze_date_today    = date( 'm/d/Y' );
	$wt_breeze_date_plus_120 = date( 'm/d/Y', strtotime( '+' . $wt_option_breeze_days . 'days' ) );

	$wt_breeze_events_json  = $wt_breeze_api->url( 'https://' . $wt_option_breeze_subdomain . '.breezechms.com/api/events?details=1&start=' . $wt_breeze_date_today . '&end=' . $wt_breeze_date_plus_120 );
	$wt_breeze_events_array = json_decode( $wt_breeze_events_json );

	$wt_breeze_locations       = $wt_breeze_api->url( 'https://' . $wt_option_breeze_subdomain . '.breezechms.com/api/events/locations' );
	$wt_breeze_locations_array = json_decode( $wt_breeze_locations );

	$wt_breeze_events_clean_array = array();
	if ( empty( $wt_breeze_events_array ) ) {
		$wt_breeze_events_clean_array = array( 'No Data' );
		set_transient( 'wt_breeze_events_trans', $wt_breeze_events_clean_array, 6 * HOUR_IN_SECONDS );
	} else {
		foreach ( $wt_breeze_events_array as $wt_breeze_events ) {
			if ( isset( $wt_breeze_events->details->location_ids_json ) ) {
				$wt_breeze_location_json   = $wt_breeze_events->details->location_ids_json;
				$wt_breeze_decode_location = json_decode( $wt_breeze_location_json );
				$wt_location_name          = '';
				$wt_location_id            = '';
				foreach ( $wt_breeze_locations_array as $wt_breeze_locations ) {
					if ( $wt_breeze_locations->id == $wt_breeze_decode_location[0]->id ) {
						$wt_location_name = $wt_breeze_locations->name;
						$wt_location_id   = $wt_breeze_locations->id;
					} else {
						$wt_location_name = 'none';
						$wt_location_id   = 'none';
					}
				}

				$wt_start_date_start_ugly = $wt_breeze_events->start_datetime;
				$wt_start_date_stop_ugly  = $wt_breeze_events->end_datetime;

				$wt_date_create_start     = date_create( $wt_start_date_start_ugly );
				$wt_start_date_day_start  = date_format( $wt_date_create_start, "m/d/Y" );
				$wt_start_date_time_start = date_format( $wt_date_create_start, "g:iA" );
				$wt_start_day_start       = date_format( $wt_date_create_start, "l" );
				$wt_start_month_start     = date_format( $wt_date_create_start, "F" );
				$wt_start_date_start      = date_format( $wt_date_create_start, "d" );
				$wt_start_year_start      = date_format( $wt_date_create_start, "Y" );

				if ( $wt_start_date_stop_ugly != '0000-00-00 00:00:00' ) {
					$wt_date_create_stop     = date_create( $wt_start_date_stop_ugly );
					$wt_start_date_day_stop  = date_format( $wt_date_create_stop, "m/d/Y" );
					$wt_start_date_time_stop = date_format( $wt_date_create_stop, "g:iA" );
					$wt_start_day_stop       = date_format( $wt_date_create_stop, "l" );
					$wt_start_month_stop     = date_format( $wt_date_create_stop, "F" );
					$wt_start_date_stop      = date_format( $wt_date_create_stop, "d" );
					$wt_start_year_stop      = date_format( $wt_date_create_stop, "Y" );
				} else {
					$wt_start_date_day_stop  = 'none';
					$wt_start_date_time_stop = 'none';
					$wt_start_day_stop       = 'none';
					$wt_start_month_stop     = 'none';
					$wt_start_date_stop      = 'none';
					$wt_start_year_stop      = 'none';
				}

				$wt_breeze_details_clean = strip_tags( $wt_breeze_events->details->event_description, '<a><b><strong><br>' );

				$wt_breeze_events_clean_array[] = array(
					'id'             => $wt_breeze_events->id,
					'name'           => $wt_breeze_events->name,
					'cal_id'         => $wt_breeze_events->category_id,
					'start_datetime' => $wt_breeze_events->start_datetime,
					'end_datetime'   => $wt_breeze_events->end_datetime,
					'created_on'     => $wt_breeze_events->created_on,
					'event_id'       => $wt_breeze_events->event_id,
					'start_date'     => $wt_start_date_day_start,
					'start_time'     => $wt_start_date_time_start,
					'start_day'      => $wt_start_day_start,
					'start_month'    => $wt_start_month_start,
					'start_day_num'  => $wt_start_date_start,
					'start_year'     => $wt_start_year_start,
					'stop_date'      => $wt_start_date_day_stop,
					'stop_time'      => $wt_start_date_time_stop,
					'stop_day'       => $wt_start_day_stop,
					'stop_month'     => $wt_start_month_stop,
					'stop_day_num'   => $wt_start_date_stop,
					'stop_year'      => $wt_start_year_stop,
					'details'        => $wt_breeze_events->details->event_description,
					'details_clean'  => $wt_breeze_details_clean,
					'location_json'  => $wt_breeze_events->details->location_ids_json,
					'location_name'  => $wt_location_name,
					'location_id'    => $wt_location_id
				);
			}

			set_transient( 'wt_breeze_events_trans', $wt_breeze_events_clean_array, 6 * HOUR_IN_SECONDS );
		}
	}
}