<?php
/**
 * This template Custom Header Template
 *
 * @package Petrona
 * @since 1.0
 */
$header_class = array('techt-custom-header');
if( techt_header_transparent() == 'yes' ) {
    $header_class[] = 'header-transparent';
} 

if( techt_header_sticky() == 'yes' ) {
    $header_class[] = 'sticky-header';
    if(techt_sticky_header_template_id() != 'default'){
        $header_class[] = 'has-sticky-template';
    }
} ?>

<header class="<?php echo esc_attr( join(' ',$header_class) ); ?>"<?php techt_schema_markup('header') ?>>
    <?php
        $args = array( 'post_type' => 'petrona_templates', 'p' => techt_header_template_id() );

        $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
                the_content();
            endwhile;
        wp_reset_postdata();
    ?>
    <?php

?>
</header><!--  /.techt-custom-header -->

<?php
if(in_array('has-sticky-template', $header_class)){
    $sticky_header_template_wrap = '<header class="sticky-header sticky-header-template-wrap sticky-hide">';
    $args = array( 'post_type' => 'petrona_templates', 'p' => techt_sticky_header_template_id() );
    $loop = new WP_Query( $args );
    ob_start();
    while ( $loop->have_posts() ) : $loop->the_post();
        the_content();
    endwhile;
    wp_reset_postdata();
    $sticky_header_template_wrap .= ob_get_clean() . '</header>';
    echo $sticky_header_template_wrap;
}