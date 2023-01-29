<?php
/**
* Plugin initialization and setup
*
* @package categ-primary-category
*/

namespace Categ\PrimaryCategory\Core;

if ( ! defined( 'ABSPATH' ) ) exit(); // No direct access

/**
* Default setup routine
* @return void
*/
function setup() {

	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n( 'init' ) );
	add_action( 'plugins_loaded', $n( 'i18n' ) );
}

/**
* Initializes the plugin
* @return void
*/
function init() {
	require CATEG_INC . 'classes/class-categ-init.php';
	new Categ_Init;
}

/**
* Activate the plugin
* @return void
*/
function activate() {
	return;
}

/**
* Deactivate the plugin
* Uninstall routines are located in uninstall.php
* @return void
*/
function deactivate() {
	return;
}

/**
* Registers the default textdomain
* @return void
*/
function i18n() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'categ' );
	load_textdomain( 'categ', WP_LANG_DIR . '/categ/categ-' . $locale . '.mo' );
	load_plugin_textdomain( 'categ', false, plugin_basename( CATEG_PATH ) . '/languages/' );
}
