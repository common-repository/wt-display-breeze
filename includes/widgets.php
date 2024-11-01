<?php

/*-----------------------------------------------------------------------------------*/
/* Display Breeze Campaigns Widgets */
/*-----------------------------------------------------------------------------------*/

function wtbreeze_campaign_register_widgets() {
	register_widget( 'wtbreeze_campaign_widget' );
}

add_action( 'widgets_init', 'wtbreeze_campaign_register_widgets' );

class wtbreeze_campaign_widget
	extends WP_Widget {

	function __construct() {
		$wtbreeze_campaign_widget_ops = array(
			'classname'   => 'wtbreeze_campaign_widget_class',
			'description' => 'Displays details about your Breeze campaigns.'
		);
		parent::__construct( 'wtbreeze_campaign_widget', 'Breeze Campaigns', $wtbreeze_campaign_widget_ops );
	}

	function form( $instance ) {
		global $wt_breeze_campaign_trans;

		$defaults = array(
			'title'                 => '',
			'campaign'              => '',
			'display_num_pleges'    => '',
			'display_amount_pleges' => '',
			'currency'              => '',
			'contrib_title'         => '',
			'contrib_amount'        => '',
			'contrib_name'          => '',
			'contrib_date'          => '',
		);

		$instance              = wp_parse_args( ( array ) $instance, $defaults );
		$title                 = $instance['title'];
		$campaign              = $instance['campaign'];
		$display_num_pleges    = $instance['display_num_pleges'];
		$display_amount_pleges = $instance['display_amount_pleges'];
		$currency              = $instance['currency'];
		$contrib_title         = $instance['contrib_title'];
		$contrib_amount        = $instance['contrib_amount'];
		$contrib_name          = $instance['contrib_name'];
		$contrib_date          = $instance['contrib_date'];

		?>
        <p>
            <label for="wt_widget_title"><?php _e( "Title: ", "pydnet" ); ?></label>
            <input class="widefat" id="wt_widget_title" name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
        <p>
            <label for="wt_campaign_select"><?php _e( "Campaign to display: ", "pydnet" ); ?></label>
            <select id="wt_campaign_select" name="<?php echo $this->get_field_name( 'campaign' ); ?>">
				<?php
				foreach ( $wt_breeze_campaign_trans as $wt_breeze_campaigns ) {
					?>
                    <option value="<?php echo $wt_breeze_campaigns->id; ?>" <?php if ( $campaign == $wt_breeze_campaigns->id ) {
						echo 'selected="selected"';
					} ?>>
						<?php echo $wt_breeze_campaigns->name; ?>
                    </option>
					<?php
				}
				?>
            </select>
        </p>
        <p>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'display_num_pleges' ); ?>"
                   id="<?php echo $this->get_field_name( 'display_num_pleges' ); ?>"
                   value="1"
				<?php
				if ( $display_num_pleges === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'display_num_pleges' ); ?>">Show the number of
                pledges</label>
        </p>
        <p>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'display_amount_pleges' ); ?>"
                   id="<?php echo $this->get_field_name( 'display_amount_pleges' ); ?>"
                   value="1"
				<?php
				if ( $display_amount_pleges === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'display_amount_pleges' ); ?>">Show the amount of
                pledged</label>
        </p>
        <p>
            <input class="widefat" id="wt_widget_currency" name="<?php echo $this->get_field_name( 'currency' ); ?>"
                   type="text" style="width: 35px"
                   value="<?php echo esc_attr( $currency ); ?>"/>
            <label for="wt_widget_currency"><?php _e( "Currency Symbol", "pydnet" ); ?></label>
        </p>
        <h4>Show Contributions</h4>
        <p>
            <label for="wt_widget_contrib_title"><?php _e( "Contribution title", "pydnet" ); ?></label>
            <br/>
            <input class="widefat" id="wt_widget_contrib_title"
                   name="<?php echo $this->get_field_name( 'contrib_title' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $contrib_title ); ?>"/>
        </p>
        <p>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'contrib_amount' ); ?>"
                   id="<?php echo $this->get_field_name( 'contrib_amount' ); ?>"
                   value="1"
				<?php
				if ( $contrib_amount === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'contrib_amount' ); ?>">List the amount of each
                contribution</label>
        </p>
        <p>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'contrib_name' ); ?>"
                   id="<?php echo $this->get_field_name( 'contrib_name' ); ?>"
                   value="1"
				<?php
				if ( $contrib_name === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'contrib_name' ); ?>">List the person for each
                contribution</label>
        </p>
        <p>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'contrib_date' ); ?>"
                   id="<?php echo $this->get_field_name( 'contrib_date' ); ?>"
                   value="1"
				<?php
				if ( $contrib_date === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'contrib_date' ); ?>">List the date of each
                contribution</label>
        </p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                          = $old_instance;
		$instance['title']                 = strip_tags( $new_instance['title'] );
		$instance['campaign']              = $new_instance['campaign'];
		$instance['display_num_pleges']    = $new_instance['display_num_pleges'];
		$instance['display_amount_pleges'] = $new_instance['display_amount_pleges'];
		$instance['currency']              = $new_instance['currency'];
		$instance['contrib_title']         = $new_instance['contrib_title'];
		$instance['contrib_amount']        = $new_instance['contrib_amount'];
		$instance['contrib_name']          = $new_instance['contrib_name'];
		$instance['contrib_date']          = $new_instance['contrib_date'];

		return $instance;
	}

	function widget( $args, $instance ) {
		global $wtbreeze_add_script, $wt_breeze_campaign_trans, $wt_breeze_contrib_trans;
		$wtbreeze_add_script = true;

		extract( $args );
		$title                 = apply_filters( 'widget_title', $instance['title'] );
		$campaign              = $instance['campaign'];
		$display_num_pleges    = $instance['display_num_pleges'];
		$display_amount_pleges = $instance['display_amount_pleges'];
		$currency              = $instance['currency'];
		$contrib_title         = $instance['contrib_title'];
		$contrib_amount        = $instance['contrib_amount'];
		$contrib_name          = $instance['contrib_name'];
		$contrib_date          = $instance['contrib_date'];

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}


		echo '<div class="wt_breeze_campaign_widget_wrap">';

		foreach ( $wt_breeze_campaign_trans as $wt_breeze_campaigns ) {
			if ( $wt_breeze_campaigns->id == $campaign ) {
				echo '<h4 class="wt_breeze_campaign_widget_title">' . $wt_breeze_campaigns->name . '</h4>';
				if ( $display_num_pleges == 1 ) {
					echo 'Total number of pledges: ' . $wt_breeze_campaigns->number_of_pledges . '<br />';
				}
				if ( $display_amount_pleges == 1 ) {
					echo 'Total amount of pledges: ' . $currency . $wt_breeze_campaigns->total_pledged . '<br />';
				}
				if ( $contrib_amount == 1 || $contrib_name == 1 || $contrib_date == 1 || $contrib_title != null ) {
					if ( $contrib_title != null ) {
						echo '<h5>' . $contrib_title . '</h5>';
					}
					echo '<ul>';
					foreach ( $wt_breeze_contrib_trans[ $campaign ] as $wt_breeze_widget_contribs ) {
						echo '<li>';
						if ( $contrib_date == 1 ) {
							$wt_breeze_contrib_date_ugly = date_create( $wt_breeze_widget_contribs->paid_on );
							$wt_breeze_clean_date        = date_format( $wt_breeze_contrib_date_ugly, "M j, Y" );
							echo $wt_breeze_clean_date . ' ';
						}
						if ( $contrib_name == 1 ) {
							echo $wt_breeze_widget_contribs->first_name . ' ' . $wt_breeze_widget_contribs->last_name . ' ';
						}
						if ( $contrib_date == 1 ) {
							echo $currency . $wt_breeze_widget_contribs->amount . ' ';
						}
						echo '</l1>';
					}
					echo '</ul>';
				}
			}
		}
		echo '</div>';

		echo $after_widget;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display Breeze Event Widgets */
/*-----------------------------------------------------------------------------------*/

function wtbreeze_register_widgets() {
	register_widget( 'wtbreeze_widget' );
}

add_action( 'widgets_init', 'wtbreeze_register_widgets' );

class wtbreeze_widget
	extends WP_Widget {

	function __construct() {
		$wtbreeze_widget_ops = array(
			'classname'   => 'wtbreeze_widget_class',
			'description' => 'Displays a list of your events from Breeze. '
		);
		parent::__construct( 'wtbreeze_widget', 'Breeze Events List', $wtbreeze_widget_ops );
	}

	function form( $instance ) {
		global $wt_breeze_calendars_trans;

		$defaults = array(
			'title'        => '',
			'num_display'  => '',
			'calendars'    => '',
			'time_display' => '',
			'info_display' => '',
			'location'     => '',
		);

		$instance     = wp_parse_args( ( array ) $instance, $defaults );
		$title        = $instance['title'];
		$num_display  = $instance['num_display'];
		$calendars    = $instance['calendars'];
		$time_display = $instance['time_display'];
		$info_display = $instance['info_display'];
		$location     = $instance['location'];

		?>
        <p>
            <label for="wt_widget_title"><?php _e( "Title: ", "pydnet" ); ?></label>
            <input class="widefat" id="wt_widget_title" name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
        <p>
            Calendars to display: <br/>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'calendars' ); ?>[all]"
                   id="<?php echo $this->get_field_name( 'calendars' ); ?>[all]"
                   value="all"
				<?php
				if ( isset( $calendars['all'] ) && $calendars['all'] == 'all' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'calendars' ); ?>['all']">Display All Calendars</label>
            <br/>
			<?php
			foreach ( $wt_breeze_calendars_trans as $wt_breeze_cal_save ) {
				?>
                <input type="checkbox"
                       name="<?php echo $this->get_field_name( 'calendars' ); ?>[<?php echo $wt_breeze_cal_save->id; ?>]"
                       id="<?php echo $this->get_field_name( 'calendars' ); ?>[<?php echo $wt_breeze_cal_save->id; ?>]"
                       value="<?php echo $wt_breeze_cal_save->id; ?>"
					<?php
					if ( isset( $calendars[ $wt_breeze_cal_save->id ] ) ) {
						if ( $calendars[ $wt_breeze_cal_save->id ] == $wt_breeze_cal_save->id || $calendars[ $wt_breeze_cal_save->id ] == '0' ) {
							echo 'checked="checked"';
						}
					}
					?>>
                <label for="<?php echo $this->get_field_name( 'calendars' ); ?>[<?php echo $wt_breeze_cal_save->id; ?>]"><?php echo $wt_breeze_cal_save->name; ?></label>
                <br/>
				<?php
			}
			?>
        </p>
        <p>
            <label for="wt_num_show"><?php _e( "Amount to display: ", "pydnet" ); ?></label>
            <br/>
            <select id="wt_num_show" name="<?php echo $this->get_field_name( 'num_display' ); ?>">
                <option value="1" <?php if ( $num_display == 1 ) {
					echo 'selected="selected"';
				} ?>>1
                </option>
                <option value="2" <?php if ( $num_display == 2 ) {
					echo 'selected="selected"';
				} ?>>2
                </option>
                <option value="3" <?php if ( $num_display == 3 ) {
					echo 'selected="selected"';
				} ?>>3
                </option>
                <option value="4" <?php if ( $num_display == 4 ) {
					echo 'selected="selected"';
				} ?>>4
                </option>
                <option value="5" <?php if ( $num_display == 5 ) {
					echo 'selected="selected"';
				} ?>>5
                </option>
                <option value="10" <?php if ( $num_display == 10 ) {
					echo 'selected="selected"';
				} ?>>10
                </option>
                <option value="15" <?php if ( $num_display == 15 ) {
					echo 'selected="selected"';
				} ?>>15
                </option>
                <option value="20" <?php if ( $num_display == 20 ) {
					echo 'selected="selected"';
				} ?>>20
                </option>
                <option value="25" <?php if ( $num_display == 25 ) {
					echo 'selected="selected"';
				} ?>>25
                </option>
                <option value="30" <?php if ( $num_display == 30 ) {
					echo 'selected="selected"';
				} ?>>30
                </option>
                <option value="40" <?php if ( $num_display == 40 ) {
					echo 'selected="selected"';
				} ?>>40
                </option>
                <option value="50" <?php if ( $num_display == 50 ) {
					echo 'selected="selected"';
				} ?>>50
                </option>
            </select>
        </p>
        <p>
            Additional display options: <br/>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'time_display' ); ?>"
                   id="<?php echo $this->get_field_name( 'time_display' ); ?>"
                   value="1"
				<?php
				if ( $time_display === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'time_display' ); ?>">Display time</label>
            <br/>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'info_display' ); ?>"
                   id="<?php echo $this->get_field_name( 'info_display' ); ?>"
                   value="1"
				<?php
				if ( $info_display === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'info_display' ); ?>">Display details</label>
            <br/>
            <input type="checkbox"
                   name="<?php echo $this->get_field_name( 'location' ); ?>"
                   id="<?php echo $this->get_field_name( 'location' ); ?>"
                   value="1"
				<?php
				if ( $location === '1' ) {
					echo 'checked="checked"';
				}
				?>>
            <label for="<?php echo $this->get_field_name( 'location' ); ?>">Display locations</label>
            <br/>
        </p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['num_display']  = strip_tags( $new_instance['num_display'] );
		$instance['calendars']    = $new_instance['calendars'];
		$instance['time_display'] = strip_tags( $new_instance['time_display'] );
		$instance['info_display'] = strip_tags( $new_instance['info_display'] );
		$instance['location']     = strip_tags( $new_instance['location'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		global $wtbreeze_add_script, $wt_breeze_events_trans;
		$wtbreeze_add_script = true;

		extract( $args );
		$title        = apply_filters( 'widget_title', $instance['title'] );
		$num_display  = $instance['num_display'];
		$calendars    = $instance['calendars'];
		$time_display = $instance['time_display'];
		$info_display = $instance['info_display'];
		$location     = $instance['location'];

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		} else {

		}
		do_action( 'wt_breeze_after_event_title_widget' );
		$i = 0;
		foreach ( $wt_breeze_events_trans as $wt_breeze_list ) {
			do_action( 'wt_breeze_before_single_event_widget' );
			if ( in_array( $wt_breeze_list['cal_id'], $calendars ) ) {

				$wt_breeze_date_display = '';
				if ( $wt_breeze_list['start_date'] == $wt_breeze_list['stop_date'] || $wt_breeze_list['stop_date'] == 'none' ) {
					$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'];
				} else {
					$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'] . ' - ' . $wt_breeze_list['stop_day'] . ' ' . $wt_breeze_list['stop_month'] . ' ' . $wt_breeze_list['stop_day_num'] . ', ' . $wt_breeze_list['stop_year'];
				}

				$wt_breeze_time_display = '';
				if ( $time_display == '1' && $wt_breeze_list['start_time'] != '12:00AM' ) {
					$wt_breeze_time_display = $wt_breeze_list['start_time'] . ' - ' . $wt_breeze_list['stop_time'];
				}
				?>
                <div class="wt_breeze_widget_event wt_breeze_widget_cal_<?php echo $wt_breeze_list['cal_id'] ?> wt_breeze_widget_id_<?php echo $wt_breeze_list['id']; ?> wt_breeze_widgetevent_id_<?php echo $wt_breeze_list['event_id']; ?> wt_breeze_widget_location_<?php echo $wt_breeze_list['location_id']; ?>">
                    <h4 class="wt_breeze_widget_title"><?php echo $wt_breeze_list['name'] ?></h4>
                    <span class="wt_breeze_date"><?php echo $wt_breeze_date_display; ?></span>
                    <br/>
					<?php if ( $wt_breeze_time_display != null ) { ?>
                        <span class="wt_breeze_time"><?php echo $wt_breeze_time_display; ?></span>
                        <br/>
					<?php }
					if ( $location == '1' && $wt_breeze_list['location_name'] != 'none' ) { ?>
                        <span class="wt_breeze_widget_location"><?php echo $wt_breeze_list['location_name']; ?></span>
                        <br/>
					<?php } ?>
					<?php if ( $info_display == '1' && $wt_breeze_list['details_clean'] != null ) { ?>
                        <p class="wt_breeze_info"><?php echo $wt_breeze_list['details_clean']; ?></p>
					<?php } ?>
                </div>
                <hr class="wt_breeze_hr"/>

				<?php
				$i ++;
				if ( $i == $num_display ) {
					break;
				}

			} elseif ( in_array( 'all', $calendars ) ) {
				$wt_breeze_date_display = '';
				if ( $wt_breeze_list['start_date'] == $wt_breeze_list['stop_date'] || $wt_breeze_list['stop_date'] == 'none' ) {
					$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'];
				} else {
					$wt_breeze_date_display = $wt_breeze_list['start_day'] . ' ' . $wt_breeze_list['start_month'] . ' ' . $wt_breeze_list['start_day_num'] . ', ' . $wt_breeze_list['start_year'] . ' - ' . $wt_breeze_list['stop_day'] . ' ' . $wt_breeze_list['stop_month'] . ' ' . $wt_breeze_list['stop_day_num'] . ', ' . $wt_breeze_list['stop_year'];
				}

				$wt_breeze_time_display = '';
				if ( $time_display == '1' && $wt_breeze_list['start_time'] != '12:00AM' ) {
					$wt_breeze_time_display = $wt_breeze_list['start_time'] . ' - ' . $wt_breeze_list['stop_time'];
				}
				?>
                <div class="wt_breeze_widget_event wt_breeze_widget_cal_<?php echo $wt_breeze_list['cal_id'] ?> wt_breeze_widget_id_<?php echo $wt_breeze_list['id']; ?> wt_breeze_widget_eventid_<?php echo $wt_breeze_list['event_id']; ?> wt_breeze_widget_location_<?php echo $wt_breeze_list['location_id']; ?>">
                    <h4 class="wt_breeze_widget_title"><?php echo $wt_breeze_list['name'] ?></h4>
                    <span class="wt_breeze_widget_date"><?php echo $wt_breeze_date_display; ?></span>
                    <br/>
					<?php if ( $wt_breeze_time_display != null ) { ?>
                        <span class="wt_breeze_widget_time"><?php echo $wt_breeze_time_display; ?></span>
                        <br/>
					<?php }
					if ( $location == '1' && $wt_breeze_list['location_name'] != 'none' ) { ?>
                        <span class="wt_breeze_widget_location"><?php echo $wt_breeze_list['location_name']; ?></span>
                        <br/>
					<?php } ?>
					<?php if ( $info_display == '1' && $wt_breeze_list['details_clean'] != null ) { ?>
                        <p class="wt_breeze_widget_info"><?php echo $wt_breeze_list['details_clean']; ?></p>
					<?php } ?>
                </div>
                <hr class="wt_breeze_widget_hr"/>

				<?php
				$i ++;
				if ( $i == $num_display ) {
					break;
				}
			}
			do_action( 'wt_breeze_after_single_event_widget' );
		}
		do_action( 'wt_breeze_after_events_widget' );
		echo $after_widget;
	}
}