<?php
/**
 * Plugin Name: Custom Events Plugin
 * Description: A plugin to create a custom post type for Events with AJAX filtering.
 * Version: 1.0
 * Author: AADYA PARASAR
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Step 1: Register Custom Post Type
function create_events_post_type() {
    register_post_type('events', array(
        'labels' => array(
            'name' => __('Events'),
            'singular_name' => __('Event')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies' => array('category', 'post_tag'),
        'rewrite' => array('slug' => 'events'),
    ));
}
add_action('init', 'create_events_post_type');

// Step 2: Add Meta Boxes
function add_event_meta_boxes() {
    add_meta_box('event_details', 'Event Details', 'render_event_meta_box', 'events', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

function render_event_meta_box($post) {
    wp_nonce_field('event_details_nonce', 'event_nonce');

    $event_date = get_post_meta($post->ID, 'event_date', true);
    $rsvp_link = get_post_meta($post->ID, 'rsvp_link', true);
    $organizer_email = get_post_meta($post->ID, 'organizer_email', true);

    echo '<label for="event_date">Event Date:</label>';
    echo '<input type="text" id="event_date" name="event_date" value="'.esc_attr($event_date).'" class="datepicker" />';
    
    echo '<label for="rsvp_link">RSVP Link:</label>';
    echo '<input type="url" id="rsvp_link" name="rsvp_link" value="'.esc_attr($rsvp_link).'" />';
    
    echo '<label for="organizer_email">Organizer Email:</label>';
    echo '<input type="email" id="organizer_email" name="organizer_email" value="'.esc_attr($organizer_email).'" />';
}

// Step 3: Save Meta Data
function save_event_meta($post_id) {
    if (!isset($_POST['event_nonce']) || !wp_verify_nonce($_POST['event_nonce'], 'event_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, 'event_date', sanitize_text_field($_POST['event_date']));
    }
    if (isset($_POST['rsvp_link'])) {
        update_post_meta($post_id, 'rsvp_link', sanitize_text_field($_POST['rsvp_link']));
    }
    if (isset($_POST['organizer_email'])) {
        update_post_meta($post_id, 'organizer_email', sanitize_email($_POST['organizer_email']));
    }
}
add_action('save_post', 'save_event_meta');

// Step 4: Enqueue Scripts and Styles
function enqueue_event_scripts() {
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    wp_enqueue_script('event-ajax', plugins_url('/ajax.js', __FILE__), array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_event_scripts');

// Step 5: Frontend Display with AJAX Filter
function display_events() {
    ob_start(); ?>

    <div id="event-filter">
        <button id="upcoming-events">Upcoming Events</button>
        <button id="past-events">Past Events</button>
    </div>

    <div id="events-list">
        <?php echo fetch_events('upcoming'); ?>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#upcoming-events').click(function() {
                $.post(ajaxurl, { action: 'filter_events', type: 'upcoming' }, function(data) {
                    $('#events-list').html(data);
                });
            });

            $('#past-events').click(function() {
                $.post(ajaxurl, { action: 'filter_events', type: 'past' }, function(data) {
                    $('#events-list').html(data);
                });
            });
        });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('events_display', 'display_events');

// Fetch Events Function
function fetch_events($type) {
    $today = date('Ymd');
    $args = array(
        'post_type' => 'events',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'posts_per_page' => -1,
    );

    if ($type == 'upcoming') {
        $args['meta_query'] = array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'DATE'
            )
        );
    } else {
        $args['meta_query'] = array(
            array(
                'key' => 'event_date',
                'compare' => '<',
                'value' => $today,
                'type' => 'DATE'
            )
        );
        $args['order'] = 'DESC';
    }

    $events = new WP_Query($args);
    ob_start();
    if ($events->have_posts()) {
        while ($events->have_posts()) {
            $events->the_post();
            $event_date = get_post_meta(get_the_ID(), 'event_date', true);
            ?>
            <div class="event-item">
                <h3><?php the_title(); ?></h3>
                <p>Date: <?php echo esc_html($event_date); ?></p>
                <p><?php the_content(); ?></p>
                <p>Location: <?php echo esc_html(get_post_meta(get_the_ID(), 'event_location', true)); ?></p>
                <p><a href="<?php echo esc_url(get_permalink()); ?>">Read More</a></p>
            </div>
            <?php
        }
    } else {
        echo '<p>No events found.</p>';
    }
    wp_reset_postdata();
    return ob_get_clean();
}

// Step 6: AJAX Handler
function filter_events() {
    $type = $_POST['type'];
    echo fetch_events($type);
    wp_die();
}
add_action('wp_ajax_filter_events', 'filter_events');
add_action('wp_ajax_nopriv_filter_events', 'filter_events');
