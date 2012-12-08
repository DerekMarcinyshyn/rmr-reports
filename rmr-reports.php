<?php
/**
 * @package RMR Reports
 * @since   December 7, 2012
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */
/*
Plugin Name: RMR Reports
Plugin URI: https://github.com/DerekMarcinyshyn/rmr-reports
Description: Revelstoke Mountain Resort Reports is a WordPress plugins displaying weather, snow, grooming and lift status updates.
Author: Derek Marcinyshyn
Author URI: http://derek.marcinyshyn.com
Version: 1.0
License: GPLv2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Exit if called directly
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

// Plugin version
define( 'RMR_REPORTS_VERSION', '1.0');

// Plugin
define( 'RMR_REPORTS_PLUGIN', __FILE__ );

// Plugin directory
define( 'RMR_REPORTS_DIRECTORY', dirname( plugin_basename(__FILE__) ) );

// Plugin path
define( 'RMR_REPORTS_PATH', WP_PLUGIN_DIR . '/' . RMR_REPORTS_DIRECTORY );

// App path
define( 'RMR_REPORTS_APP_PATH', RMR_REPORTS_PATH . '/app' );

// Lib path
define( 'RMR_REPORTS_LIB_PATH', RMR_REPORTS_PATH . '/lib' );

// URL
define( 'RMR_REPORTS_URL', WP_PLUGIN_URL . '/' . RMR_REPORTS_DIRECTORY );


// Require main class
require_once( RMR_REPORTS_APP_PATH . '/code/Block/App.php' );

// Require widgets class
require_once( RMR_REPORTS_APP_PATH . '/code/View/Widgets.php' );

// Require updater class
//include_once( RMR_REPORTS_LIB_PATH . '/vendor/updater/updater.php' );

// ====================================
// = Initialize and setup application =
// ====================================

global  $rmr_reports_app,
        $rmr_reports_widgets;

// widgets class
use rmr_reports\Widgets;
$rmr_reports_widgets = \rmr_reports\Widgets::get_instance();

// Main class app initialization in App::__construct()
use rmr_reports\App;
$rmr_reports_app = \rmr_reports\App::get_instance();