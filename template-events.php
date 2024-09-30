<?php
//Template Name: Events
get_header();
?>

<div id="event-filter">
    <button id="upcoming-events">Upcoming Events</button>
    <button id="past-events">Past Events</button>
</div>

<div id="events-list">
    <?php
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
        'posts_per_page' => -1
    );
    
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
    }
    wp_reset_postdata();
    ?>
</div>

<script>
    jQuery(document).ready(function($) {
        $('#upcoming-events').click(function() {
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'filter_events',
                    type: 'upcoming'
                },
                success: function(data) {
                    $('#events-list').html(data);
                }
            });
        });

        $('#past-events').click(function() {
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'filter_events',
                    type: 'past'
                },
                success: function(data) {
                    $('#events-list').html(data);
                }
            });
        });
    });
</script>

<?php get_footer(); ?>
