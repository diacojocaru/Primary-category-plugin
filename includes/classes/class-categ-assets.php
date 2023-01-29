<?php

/**
* Loads all plugin assets
*
* @package categ-primary-category
*/


namespace Categ\PrimaryCategory\Core;

if ( ! defined( 'ABSPATH' ) ) exit(); // No direct access

class Categ_Assets {

  public function __construct() {
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ), 10, 1 );
  }

  /**
  * Check that we are on the post edit page 
  * @param  string $hook 
  * @return void
  */
  public function admin_assets( $hook ) {
    if ( 'post.php' == $hook ) {
      // Admin styles
      wp_enqueue_style( 'categ-admin-style', CATEG_URL . 'assets/styles/categ.css', array(), CATEG_VERSION );

      // Admin scripts
      wp_enqueue_script( 'categ-admin-script', CATEG_URL . "assets/js/categ.js", array( 'jquery' ), CATEG_VERSION, true );

      // Localized Variables
      wp_localize_script( 'categ-admin-script', 'categVars', $this->localize_admin_scripts() );
    }
  }

  /**
  * Localize the post taxonomies for JS
  * @return array 
  */
  private function localize_admin_scripts() {
    $tax = new Categ_Taxonomies();

    $localized = array(
      'taxonomies' => $tax->get_primary_term()
    );

    return $localized;
  }
}

new \Categ\PrimaryCategory\Core\Categ_Assets();
