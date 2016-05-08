<?php

/*
Plugin Name: ACF Option Pages
Description: Creates options pages using ACF interface and ACF functions
Version: 0.9.3
*/

new ACF_Option_Pages;

class ACF_Option_Pages {

  public function __construct() {
    require('src/PostType.php');
    require('src/OptionPage.php');
    add_action('init', array( $this, 'includeAcfFields' ));
    add_action('init', array( $this, 'addOptionsPagePostType' ));
    add_action('init', array( $this, 'addRegisteredOptionsPages' ));
  }

  public function includeAcfFields() {
    require('assets/acf/fields.php');
  }

  public function addOptionsPagePostType() {
    $pt = new ACFOP_PostType;
    $args = array(
      'key' => 'acf_option_page',
      'name' => 'Option Page',
      'settings' => array(
        'lbl_name' => 'Option Pages',
        'lbl_add_new' => 'Add Option Page',
      )
    );
    $pt->add( $args );
  }

  public function addRegisteredOptionsPages() {
    $ops = $this->getOptionPages();
    foreach( $ops as $opPost ) {
      $this->registerOptionPage( $opPost );
    }
  }

  public function registerOptionPage( $opPost ) {
    $op = new ACFOP_OptionPage;
    $fields = get_fields( $opPost->ID );

    $args = array(
      'page_title' => $ctPost->post_title,
      'settings' => $fields,
    );

    $op->add( $args );
  }

  public function getOptionPages() {
    return get_posts( array(
      'post_type'     => 'acf_option_page',
      'meta_key'	    => 'is_subpage',
      'orderby'			  => 'meta_value_num',
	    'order'				  => 'DESC'
    ));
  }

  public function unregisterPostType( $post_type ) {
    global $wp_post_types;
    if ( isset( $wp_post_types[ $post_type ] ) ) {
      unset( $wp_post_types[ $post_type ] );
      return true;
    }
    return false;
  }


}
