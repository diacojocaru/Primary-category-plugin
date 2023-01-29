<?php

// Global constants
define( 'CATEG_VERSION', '1.0.0' );
define( 'CATEG_URL', plugin_dir_url( __FILE__ ) );
define( 'CATEG_PATH', dirname( __FILE__ ) . '/' );
define( 'CATEG_INC', CATEG_PATH . 'includes/' );

// Setup file
require_once( CATEG_INC . 'functions/setup.php' );

// Activation/Deactivation
register_activation_hook( __FILE__, '\Categ\PrimaryCategory\Core\activate' );
register_deactivation_hook( __FILE__, '\Categ\PrimaryCategory\Core\deactivate' );

// Bootstrap plugin
\Categ\PrimaryCategory\Core\setup();
