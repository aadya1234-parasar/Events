<?php
/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/**
 * Register block styles.
 */

if ( ! function_exists( 'twentytwentyfour_block_styles' ) ) :
	/**
	 * Register custom block styles
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_styles() {

		register_block_style(
			'core/details',
			array(
				'name'         => 'arrow-icon-details',
				'label'        => __( 'Arrow icon', 'twentytwentyfour' ),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-arrow-icon-details {
					padding-top: var(--wp--preset--spacing--10);
					padding-bottom: var(--wp--preset--spacing--10);
				}

				.is-style-arrow-icon-details summary {
					list-style-type: "\2193\00a0\00a0\00a0";
				}

				.is-style-arrow-icon-details[open]>summary {
					list-style-type: "\2192\00a0\00a0\00a0";
				}',
			)
		);
		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill',
				'label'        => __( 'Pill', 'twentytwentyfour' ),
				/*
				 * Styles variation for post terms
				 * https://github.com/WordPress/gutenberg/issues/24956
				 */
				'inline_style' => '
				.is-style-pill a,
				.is-style-pill span:not([class], [data-rich-text-placeholder]) {
					display: inline-block;
					background-color: var(--wp--preset--color--base-2);
					padding: 0.375rem 0.875rem;
					border-radius: var(--wp--preset--spacing--20);
				}

				.is-style-pill a:hover {
					background-color: var(--wp--preset--color--contrast-3);
				}',
			)
		);
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfour' ),
				/*
				 * Styles for the custom checkmark list block style
				 * https://github.com/WordPress/gutenberg/issues/51480
				 */
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
		register_block_style(
			'core/navigation-link',
			array(
				'name'         => 'arrow-link',
				'label'        => __( 'With arrow', 'twentytwentyfour' ),
				/*
				 * Styles for the custom arrow nav link block style
				 */
				'inline_style' => '
				.is-style-arrow-link .wp-block-navigation-item__label:after {
					content: "\2197";
					padding-inline-start: 0.25rem;
					vertical-align: middle;
					text-decoration: none;
					display: inline-block;
				}',
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'         => 'asterisk',
				'label'        => __( 'With asterisk', 'twentytwentyfour' ),
				'inline_style' => "
				.is-style-asterisk:before {
					content: '';
					width: 1.5rem;
					height: 3rem;
					background: var(--wp--preset--color--contrast-2, currentColor);
					clip-path: path('M11.93.684v8.039l5.633-5.633 1.216 1.23-5.66 5.66h8.04v1.737H13.2l5.701 5.701-1.23 1.23-5.742-5.742V21h-1.737v-8.094l-5.77 5.77-1.23-1.217 5.743-5.742H.842V9.98h8.162l-5.701-5.7 1.23-1.231 5.66 5.66V.684h1.737Z');
					display: block;
				}

				/* Hide the asterisk if the heading has no content, to avoid using empty headings to display the asterisk only, which is an A11Y issue */
				.is-style-asterisk:empty:before {
					content: none;
				}

				.is-style-asterisk:-moz-only-whitespace:before {
					content: none;
				}

				.is-style-asterisk.has-text-align-center:before {
					margin: 0 auto;
				}

				.is-style-asterisk.has-text-align-right:before {
					margin-left: auto;
				}

				.rtl .is-style-asterisk.has-text-align-left:before {
					margin-right: auto;
				}",
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_styles' );

/**
 * Enqueue block stylesheets.
 */

if ( ! function_exists( 'twentytwentyfour_block_stylesheets' ) ) :
	/**
	 * Enqueue custom block stylesheets
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_stylesheets() {
		/**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'twentytwentyfour-button-style-outline',
				'src'    => get_parent_theme_file_uri( 'assets/css/button-outline.css' ),
				'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
				'path'   => get_parent_theme_file_path( 'assets/css/button-outline.css' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_stylesheets' );

/**
 * Register pattern categories.
 */

if ( ! function_exists( 'twentytwentyfour_pattern_categories' ) ) :
	/**
	 * Register pattern categories
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfour_page',
			array(
				'label'       => _x( 'Pages', 'Block pattern category', 'twentytwentyfour' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfour' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_pattern_categories' );

// Widget added
class Upcoming_Event_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'upcoming_event_widget',
            __('Upcoming Event', 'text_domain'),
            array('description' => __('Displays the next upcoming event', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $today = date('Ymd');
        $args = array(
            'post_type' => 'events',
            'meta_key' => 'event_date',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'DATE'
                )
            ),
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'posts_per_page' => 1
        );

        $events = new WP_Query($args);
        if ($events->have_posts()) {
            while ($events->have_posts()) {
                $events->the_post();
                $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                ?>
                <div class="upcoming-event">
                    <h4><?php the_title(); ?></h4>
                    <p>Date: <?php echo esc_html($event_date); ?></p>
                    <a href="<?php echo esc_url(get_permalink()); ?>">View Event</a>
                </div>
                <?php
            }
        } else {
            echo '<p>No upcoming events found.</p>';
        }
        wp_reset_postdata();

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Upcoming Events', 'text_domain');
        ?>
        <p>
		    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

function register_upcoming_event_widget() {
    register_widget('Upcoming_Event_Widget');
}
add_action('widgets_init', 'register_upcoming_event_widget');


// Events related code:-
function create_events_post_type() {
    register_post_type('events',
        array(
            'labels' => array(
                'name' => __('Events'),
                'singular_name' => __('Event')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'taxonomies' => array('category', 'post_tag'),
            'rewrite' => array('slug' => 'events'),
        )
    );
}
add_action('init', 'create_events_post_type');

function add_event_meta_boxes() {
    add_meta_box('event_details', 'Event Details', 'render_event_meta_box', 'events', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

function render_event_meta_box($post) {
    // Nonce field for security
    wp_nonce_field('event_details_nonce', 'event_nonce');

    $rsvp_link = get_post_meta($post->ID, 'rsvp_link', true);
    $organizer_email = get_post_meta($post->ID, 'organizer_email', true);
    
    echo '<label for="rsvp_link">RSVP Link:</label>';
    echo '<input type="url" id="rsvp_link" name="rsvp_link" value="'.esc_attr($rsvp_link).'" />';
    
    echo '<label for="organizer_email">Organizer Contact Email:</label>';
    echo '<input type="email" id="organizer_email" name="organizer_email" value="'.esc_attr($organizer_email).'" />';
}

function save_event_meta($post_id) {
    if (!isset($_POST['event_nonce']) || !wp_verify_nonce($_POST['event_nonce'], 'event_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['rsvp_link'])) {
        update_post_meta($post_id, 'rsvp_link', sanitize_text_field($_POST['rsvp_link']));
    }
    if (isset($_POST['organizer_email'])) {
        update_post_meta($post_id, 'organizer_email', sanitize_email($_POST['organizer_email']));
    }
}
add_action('save_post', 'save_event_meta');


// AJAX handler
function filter_events() {
    $today = date('Ymd');
    $type = $_POST['type'];
    
    if ($type == 'upcoming') {
        $args = array(
            'post_type' => 'events',
            'meta_key' => 'event_date',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'DATE'
                )
            ),
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'posts_per_page' => -1
        );
    } else {
        $args = array(
            'post_type' => 'events',
            'meta_key' => 'event_date',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '<',
                    'value' => $today,
                    'type' => 'DATE'
                )
            ),
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'posts_per_page' => -1
        );
    }

    $events = new WP_Query($args);
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
                <a href="<?php echo esc_url(get_permalink()); ?>">Read More</a>
            </div>
            <?php
        }
    } else {
        echo '<p>No events found.</p>';
    }
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_filter_events', 'filter_events');
add_action('wp_ajax_nopriv_filter_events', 'filter_events');


