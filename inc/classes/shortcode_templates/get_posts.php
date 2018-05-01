<?php
/**
 * Get Posts Shortcode
 * 
 * @version 0.6
 * 
 * Params
 * posttype="[post|attachment|...]"
 * count="[number]"
 * title="[string]"
 */

if( $atts['posttype'] ) :
    $count = $atts['count'] ? $atts['count'] : 5;

    $args = array(
        'post_type' => $atts['posttype'],
        'posts_per_page' => $count
    );

    $query = new WP_Query( $args );

    if( $query->have_posts() ) :
?>
        <section class="shortcode-section">
            <?php if( $atts['title'] ) echo '<h3>' . $atts['title'] . '</h3>';

                while ( $query->have_posts() ) : $query->the_post();
?>
<figure>
    <?php codein_theme_post_thumbnail(); ?>
    <figcaption>
        <?php the_title(); ?>
    </figcaption>
</figure>
<?              
                endwhile;
            ?>
        </section>
<?php
    else: 
        get_template_part( 'template-parts/content', 'none' );
    endif;

    // wp_reset_postdata();
else :
    echo 'No';
endif;