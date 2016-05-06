<?php

/*
Plugin Name: ACF Option Pages
Description: Creates options pages using ACF interface and ACF functions
Version: 0.9.1

TO DO:

Make ACF field group
  Page or subpage (parent_slug)
    page_title
    menu_title
    menu_slug
    capability
    redirect
Write addOptionsPagePostType to add CT
Parse all the options pages
Call either acf_add_options_page() or acf_add_options_sub_page()

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
    $op = new OptionPage;
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
