<?php
/**
 * Plugin Name: BuddyPress Friend Request Listing Widget
 * Plugin URI: http://buddypress.com/plugins/bp-friend-request-widget
 * Description: This plugin allows admin to list of friend requests of the current user
 * Version: 1.0.0
 * Author: Ravi Sharma
 * Author Uri: http://buddydev.com
 */

Class BP_Friend_Request_Widget_Helper {

    private static $instance = null;

    private function __construct() {
        $this->setup();
    }

    public static function get_instance() {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setup() {

        add_action( 'bp_loaded', array( $this, 'load' ) );
        add_action( 'bp_widgets_init', array( $this, 'register_widget' ) );

    }

    public function load() {
        require_once plugin_dir_path( __FILE__ ) . 'class-bp-friend-requests-widget.php';
    }

    public function register_widget() {
        register_widget( 'BP_Friend_Request_Widget' );
    }

}
BP_Friend_Request_Widget_Helper::get_instance();