<?php

class BP_Friend_Request_Widget extends WP_Widget {

    public function __construct() {

        $widget_ops = array(
            'description' => __( 'List of friend request for current users', 'bp-friend-request-widget' ),
        );

        parent::__construct( false, _x( 'BP Friend Request List', 'widget name', 'bp-friend-request-widget' ), $widget_ops );

    }

    public function widget( $args, $instance ) {

        if ( ! is_user_logged_in() ) {
            return;
        }

        $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];

        echo $args['before_title'] . $title . $args['after_title'];

        $after_widget = $args['after_widget'];

        $args = array(
            'max'       => 5,
            'type'      => 'alphabetical',
            'include'   => bp_get_friendship_requests( get_current_user_id() )
        );

        $r = bp_parse_args( $instance, $args );

    ?>

        <?php if ( bp_has_members( $r ) ) : ?>

            <ul id="friend-list" class="item-list">

                <?php while ( bp_members() ) : bp_the_member(); ?>

                    <li id="friendship-<?php bp_friend_friendship_id(); ?>">

                        <div class="item-avatar">
                            <a href="<?php bp_member_link(); ?>"><?php bp_member_avatar(); ?></a>
                        </div>

                        <div class="item">

                            <div class="item-title"><a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a></div>
                            <div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>

                            <?php do_action( 'bp_friend_requests_item' ); ?>

                        </div>

                        <div class="action">

                            <a class="button accept" href="<?php bp_friend_accept_request_link(); ?>"><?php _e( 'Accept', 'bp-friend-request-widget' ); ?></a> &nbsp;
                            <a class="button reject" href="<?php bp_friend_reject_request_link(); ?>"><?php _e( 'Reject', 'bp-friend-request-widget' ); ?></a>

                            <?php do_action( 'bp_friend_requests_item_action' ); ?>

                        </div>
                    </li>

                <?php endwhile; ?>
            </ul>

        <?php else: ?>

            <div id="message" class="info">
                <p><?php _e( 'You have no pending friendship requests.', 'bp-friend-request-widget' ); ?></p>
            </div>

        <?php endif;?>

        <?php echo $after_widget; ?>

    <?php

    }

    public function update($new_instance, $old_instance) {

        $instance          = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['max']   = strip_tags( $new_instance['max'] );

        return $instance;
    }

    public function form($instance) {

        $default = array(
            'title' => __( 'Friend Requests List', 'bp-friend-request-widget' ),
            'max'   => 5
        );

        $instance = wp_parse_args( (array) $instance, $default );
        $title    = strip_tags( $instance['title'] );
        $max      = strip_tags( $instance['max'] );

    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:', 'bp-friend-request-widget' ); ?>&nbsp;
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" style="width: 100%"/>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'max' ); ?>">
                <?php _e( 'No. of Request to Show', 'bp-friend-request-widget' ); ?>&nbsp;
                <input class="widefat" id="<?php echo $this->get_field_id( 'max' ); ?>" name="<?php echo $this->get_field_name( 'max' ); ?>" type="text" value="<?php echo esc_attr( $max ); ?>" style="width: 100%"/>
            </label>
        </p>
    <?php
    }

}