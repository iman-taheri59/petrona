<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Petrona
 * @since 1.0
 */
?>
<div class="post-meta">
	<div class="entry-author"><i class="techt-icon-user"></i><span><?php esc_html_e('By', 'petrona'); ?>&nbsp;</span><span><?php the_author_meta('display_name'); ?></span></div>
	<div class="entry-date"><i class="techt-icon-calendar"></i><span><?php the_time(get_option('date_format')); ?></span></div>
</div><!-- /post-meta -->