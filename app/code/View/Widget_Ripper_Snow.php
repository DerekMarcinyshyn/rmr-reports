<?php

namespace rmr_reports;

/**
 * Widgets class for displaying Ripper Chair Snow Report
 *
 * PHP version 5
 *
 * Copyright (c) 2012 Derek Marcinyshyn
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    RMR Reports
 * @author     Derek Marcinyshyn <derek@marcinyshyn.com>
 * @copyright  Copyright (c) 2012 Derek Marcinyshyn
 * @version    1.0
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/DerekMarcinyshyn/rmr-reports
 */

if ( ! class_exists( 'Widget_Ripper_Snow' ) ) :

    class Widget_Ripper_Snow extends \WP_Widget {

        /**
         * Register the widget with WordPress.
         */
        public function __construct() {
            parent::__construct(
                'ripper_snow',
                'Ripper Snow Report',
                array( 'description' => __( 'Revelstoke Mountain Resort Ripper Chair Snow Report', 'rmr_reports') ) );
        }

        /**
         * Back-end widget form
         *
         * @param array $instance
         * @return string|void
         */
        public function form( $instance ) {
            if ( isset( $instance[ 'title' ] ) ) {
                $title = $instance[ 'title' ];
            }
            else {
                $title = __( 'RMR Ripper Snow Report', 'rmr_reports' );
            }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance
         * @param array $old_instance
         *
         * @return array|void
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = strip_tags( $new_instance['title'] );

            return $instance;
        }

        /**
         * Front-end display of the widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args
         * @param array $instance
         */
        public function widget( $args, $instance ) {
            extract( $args);

            $title = apply_filters( 'widget_title', $instance['title'] );

            echo $before_widget;

            if ( ! empty( $title ) )
                echo $before_title . $title . $after_title;

            echo __( $this->get_rmr_ripper_data(), 'rmr_reports' );

            echo $after_widget;
        }

        /**
         * Get the xml data feed and parse the data and return an html object
         *
         * @return string
         */
        private function get_rmr_ripper_data() {
            $ripper = 'http://www.revelstokemountainresort.com/conditions/xml';
            $output = '';

            // get the file headers to check if file exists
            $get_headers = @get_headers( $ripper );

            if ( preg_match( "|200|", $get_headers[0] ) ) {
                // load the data
                $ripper_data = simplexml_load_file( $ripper );

                $output .= '<p class="date-time">' . date( 'l, F j, Y g:ia', strtotime( $ripper_data->timestamp->value ) ) . '</p>';
                $output .= '<p class="current-temp">Current temp: <strong>' . $ripper_data->temperature->value . '</strong></p>';
                $output .= '<p class="humidity">Humidity: <strong>' . $ripper_data->{'relative-humidity'}->value . '</strong></p>';
                $output .= '<p class="new-snow">New snow (reset at 4pm): <strong>' . $ripper_data->{'new-snow'}->value . '</strong></p>';
                $output .= '<p class="hourly-snow">Hourly snow: <strong>' . $ripper_data->{'hourly-snow'}->value . '</strong></p>';
                $output .= '<p class="twenty-four-snow">24 hour: <strong>' . $ripper_data->{'twenty-four-hour-snow'}->value . '</strong></p>';
                $output .= '<p class="base-depth">Base depth: <strong>' . $ripper_data->{'base-depth'}->value . '</strong></p>';

            } else {
                $output .= '<p>Sorry data feed unavailable</p>';
            }

            return $output;
        }

    }

endif; // end if class_exists