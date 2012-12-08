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

if ( ! class_exists( 'App' ) ) :

    class App {

        /**
         * _instance class variable
         *
         * Class instance
         *
         * @var null | object
         */
        private static $_instance = NULL;

        static function get_instance() {
            if( self::$_instance === NULL ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Constructor
         *
         * Default constructor -- application initialization
         */
        private function __construct() {

            // register the ripper snow widget
            add_action( 'widgets_init', function(){ return register_widget( 'rmr_reports\Widget_Ripper_Snow' ); } );

            // add css
            add_action( 'init', array( $this, 'rmr_reports_css' ) );

            // check for update
            add_action( 'admin_init', array( $this, 'rmr_reports_updater' ) );
        }

        /**
         * rmr_reports_css function
         *
         * Add CSS rules
         */
        function rmr_reports_css() {
            wp_register_style( 'rmr-ripper-snow-css', RMR_REPORTS_URL . '/assets/css/rmr-reports.css', true, RMR_REPORTS_VERSION );
            wp_enqueue_style( 'rmr-ripper-snow-css' );
        }

        /**
         * rmr_reports_updater class
         *
         * Check GitHub to see if there is an update available
         */
        function rmr_reports_updater() {
            define( 'RMR_REPORTS_FORCE_UPDATE', true );

            if ( is_admin() ) {
                $config = array(
                    'slug'                  => RMR_REPORTS_DIRECTORY . '/rmr-reports.php',
                    'proper_folder_name'    => 'rmr-reports',
                    'api_url'               => 'https://api.github.com/repos/DerekMarcinyshyn/rmr-reports',
                    'raw_url'               => 'https://raw.github.com/DerekMarcinyshyn/rmr-reports/master',
                    'github_url'            => 'https://github.com/DerekMarcinyshyn/rmr-reports',
                    'zip_url'               => 'https://github.com/DerekMarcinyshyn/rmr-reports/zipball/master',
                    'sslverify'             => false,
                    'requires'              => '3.0',
                    'tested'                => '3.5',
                    'readme'                => 'README.md',
                    'access_token'          => '',
                );

                new \RMR_Reports_Updater( $config );
            }
        }
    }

endif; // end if class_exists