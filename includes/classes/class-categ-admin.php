<?php

/**
* Primary category admin display
*
* @package categ-primary-category
*/


namespace Categ\PrimaryCategory\Admin;

use \Categ\PrimaryCategory\Core\Categ_Taxonomies as Taxonomies;

if ( ! defined( 'ABSPATH' ) ) exit(); 
class Categ_Admin {

  public function __construct() {

    if( ! is_admin() ) {
      return;
    }

    add_action( 'submitpost_box', array( $this, 'render_admin_view' ), 10 );
    add_action( 'save_post', array( $this, 'save_primary_tax' ), 10, 2 );
  }

  /**
  * Load  JS templates for post editting
  * @return void
  */
  public function render_admin_view() {
    require( CATEG_PATH . 'assets/partials/categ-views.php' );
  }

  /**
  * Save selected primary taxonomy to the post
  * @param  int $post_id    
  * @param  object $post   
  * @return void
  */
  public function save_primary_tax( $post_id, $post ) {
    $nonce = $_POST['categ_primary_nonce'];

    if ( wp_verify_nonce( $nonce, 'categ_primary_nonce' ) ) {
      $tax_obj = new Taxonomies();
      $tax_obj->set_primary_term( $post_id, $post );
    }
  }
}

new \Categ\PrimaryCategory\Admin\Categ_Admin;
