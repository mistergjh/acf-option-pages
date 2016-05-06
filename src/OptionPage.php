<?php

class OptionPage {

  public function add( $args ) {

    $page_title = $args['page_title'];
    $settings = $args['settings'];

    $args = array(
      'page_title' => $page_title,
      'menu_title' => $settings['menu_title'],
      'menu_slug' => '',
      'capability' => 'edit_posts',
      'position' => false,
      'parent_slug' => '',
      'icon_url' => false,
      'redirect' => true,
      'post_id' => 'options',
      'autoload' => false,
    );
    acf_add_options_page( $args );

  }

}
