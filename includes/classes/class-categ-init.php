<?php

/**
* Initializes plugin
*
* @package categ-primary-category
*/


namespace Categ\PrimaryCategory\Core;

if ( ! defined( 'ABSPATH' ) ) exit(); // No direct access

class Categ_Init {

  public function __construct() {
    $this->conditional_filters();
    $this->load_dependencies();
  }

  private function conditional_filters() {
    global $wp_version;

    if( version_compare( $wp_version, '4.9', '>=' ) ) {
      add_filter('use_block_editor_for_post', '__return_false', 10);
      add_filter('use_block_editor_for_post_type', '__return_false', 10);
    }
  }

  /**
  * Load plugin dependency files
  * @return void
  */
  private function load_dependencies() {
    require( CATEG_INC . '/classes/class-categ-taxonomies.php' );

    if( is_admin() ) {
      require( CATEG_INC . '/classes/class-categ-assets.php' );
      require( CATEG_INC . '/classes/class-categ-admin.php' );
    }
  }
}
