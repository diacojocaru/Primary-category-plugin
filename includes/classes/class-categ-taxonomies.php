<?php

/**
* Primary category core functionality
*
* Includes getter/setter functions for primary taxonomies
*
* @package categ-primary-category
*/


namespace Categ\PrimaryCategory\Core;

if ( ! defined( 'ABSPATH' ) ) exit(); // No direct access

class Categ_Taxonomies {

  /**
  * Primary category meta prefix
  * @var string
  */
  private $meta_prefix;

  public function __construct() {
    $this->meta_prefix = '_categ_primary_';

    add_filter( 'post_link_category', array( $this, 'adjust_post_link' ), 10, 3 );
  }

  /**
  * Get primary taxonomy for a given post
  * @param  int||object  
  * @return array        
  */
  public function get_primary_term( $post = null ) {

    $post = $this->get_post_object( $post );

    $taxonomies = array();

    if ( ! empty( $post ) ) {

      $post_taxonomies = get_object_taxonomies( $post->post_type, 'objects' );

      if( is_array( $post_taxonomies ) && ! empty( $post_taxonomies ) ) {
        foreach( $post_taxonomies as $tax ) {

          $taxonomies[] = array(
            'taxonomy' => $tax->name,
            'primary' => get_post_meta( $post->ID, $this->meta_prefix . $tax->name, true )
          );
        }
      }
    }

    return $taxonomies;
  }

  /**
  * Set the primary taxonomy for a post
  * @param int $post_id    
  * @param object $post    
  * @return void
  */
  public function set_primary_term( $post_id, $post ) {

    $taxonomies = $this->get_primary_term( $post );

    if ( is_array( $taxonomies ) && ! empty( $taxonomies ) ) {
      foreach ( $taxonomies as $taxonomy ) {

        $input_name = ltrim( $this->meta_prefix, '_' ) . $taxonomy['taxonomy'];
        $primary = filter_input( INPUT_POST, $input_name, FILTER_SANITIZE_NUMBER_INT );

        if ( has_term( $primary, $taxonomy['taxonomy'], $post ) && $primary ) {
          if( $taxonomy['primary'] !== $primary ) {
            update_post_meta( $post_id, $this->meta_prefix . $taxonomy['taxonomy'], $primary );
          }
        } else {
          delete_post_meta( $post_id, $this->meta_prefix . $taxonomy['taxonomy'], $taxonomy['primary'] );
        }
      }
    }
  }

  /**
   * Change the post link to include the selected primary category
   * @param  object $category  
   * @param  array $categories  
   * @param  object $post      
   * @return object             
   */
  public function adjust_post_link( $category, $categories = null, $post = null ) {
    $post = $this->get_post_object( $post );

    $post_taxonomies = $this->get_primary_term( $post );

    $primary = 0;

    if( is_array( $post_taxonomies ) && ! empty( $post_taxonomies ) ) {
      foreach( $post_taxonomies as $taxonomies ) {
        if( $taxonomies['taxonomy'] === 'category' && ! empty( $taxonomies['primary'] ) ) {
          $primary = $taxonomies['primary'];
        }
      }

      if( $primary ) {
        $category = get_category( $primary );
      }
    }

    return $category;
  }

  /**
   * Return the WP post object
   * @param  int||object  
   * @return object      
   */
  private function get_post_object( $post ) {
    if( ! $post || $post === null ) {
      global $post;
    }

    if ( ! is_a( $post, 'WP_Post' ) ) {
      $post = get_post( $post );
    }

    return $post;
  }

}

new Categ_Taxonomies;
