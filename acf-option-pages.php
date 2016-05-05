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
    add_action('init', array( $this, 'includeAcfFields' ));
    add_action('init', array( $this, 'addAcfPostType' ));
    add_action('init', array( $this, 'addRegisteredPostTypes' ));
  }

  public function includeAcfFields() {

    require('assets/acf/fields.php');

    acf_add_options_page();

  }

  public function addOptionsPagePostType() {
    $op = new OptionsPage;
    $args = array(
      'key' => 'acf_post_type',
      'name' => 'Post Type',
    );
    $op->addPostType( $args );
  }

  public function addRegisteredPostTypes() {
    $cts = $this->getPostTypes();
    foreach( $cts as $ctPost ) {
      $this->registerPostType( $ctPost );
    }
  }

  public function registerPostType( $ctPost ) {
    $ct = new PostType;
    $fields = get_fields( $ctPost->ID );

    $args = array(
      'key' => $fields['key'],
      'name' => $ctPost->post_title,
      'settings' => $fields,
    );

    $ct->addPostType( $args );
  }

  public function getPostTypes() {
    return get_posts( array( 'post_type' => 'acf_post_type' ));
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
