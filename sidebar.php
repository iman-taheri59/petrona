<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Petrona
 * @since 1.0
 */
if( is_single() ) {
    $sidebar_id = "sidebar-single";
} elseif ( is_page() ) {
    $sidebar_id = "sidebar-page";
} else {
    $sidebar_id = "sidebar-blog";
}
if ( is_active_sidebar( $sidebar_id ) ) : ?>
    <div class="sidebar-block" <?php techt_schema_markup('sidebar') ?>>
        <?php dynamic_sidebar( $sidebar_id ); ?>
    </div><!-- /.sidebar-items -->
<?php endif; ?>