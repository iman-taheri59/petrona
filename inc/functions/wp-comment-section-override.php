<?php
/**
 * Move Comment Field To Bottom
 *
 * @package Petrona
 * @subpackage Comment Forms
 */
function techt_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'techt_move_comment_field_to_bottom' );

/**
 * Comment Form
 *
 * @package Petrona
 * @subpackage Comment Forms
 */
function techt_comment_form($args) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );

	$args['id_form'] = "comment_form";
	$args['class_form'] = "row comment-form";
	$args['id_submit'] = "submit";
	$args['class_submit'] = "btn submit";
	$args['name_submit'] = "submit";
	$args['title_reply'] = wp_kses( __( '<span>Leave A Reply</span>', 'petrona' ), Techt_Static::html_allow() );

	/* translators: %s: Extra words for comment title */
	$args['title_reply_to'] = wp_kses( __( 'Leave A Reply to %s', 'petrona' ), Techt_Static::html_allow() );
	$args['cancel_reply_link'] = esc_html__( 'Cancel Reply', 'petrona' );
    if( is_user_logged_in() ) {
    $args['comment_notes_before'] = "";
    } else {
	$args['comment_notes_before'] = '<div class="col-md-12"><p class="comment-notes"><span id="email-notes">'. wp_kses( __( 'Your email address will not be published.</span> Required fields are marked <span class="required">*</span>', 'petrona' ), Techt_Static::html_allow() ) .'</p></div>';
    }
	$args['comment_notes_after'] = "";
	$args['label_submit'] = esc_html__( 'Post Comment', 'petrona' );
	$args['comment_field'] = '<div class="col-md-12 form-group"><textarea id="message" placeholder="'. esc_attr__( 'Your Comment', 'petrona' ) .'" class="form-controller" name="comment" aria-required="true" rows="5" cols="25"></textarea></div>';

    $args['fields'] = array(
      'author' =>
        '<div class="col-md-4 form-group"><input id="name" class="form-controller" placeholder="'. esc_attr__( 'Name', 'petrona' ) . ( $req ? '*' : '' ) .'" name="author" required="required" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30"' . ( $req ? " aria-required='true'" : '' ) . ' /></div>',

      'email' =>
        '<div class="col-md-4 form-group"><input id="email" class="form-controller" placeholder="'. esc_attr__( 'Email', 'petrona' ) . ( $req ? '*' : '' ) .'" name="email" required="required" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
        '" size="30"' . ( $req ? " aria-required='true'" : '' ) . ' /></div>',

      'url' =>
        '<div class="col-md-4 form-group"><input id="url" class="form-controller" name="url" placeholder="'. esc_attr__( 'Website', 'petrona' ) .'" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
        '" size="30"/></div>',
    );

	return $args;
}

add_filter('comment_form_defaults', 'techt_comment_form');

/**
 * Comment Lists
 *
 * @package Petrona
 * @subpackage Comment Forms
 */
function techt_comment_list($comment, $args, $depth) {
    $comment_id = $comment->comment_ID; 
	extract($args, EXTR_SKIP);
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>

<<?php echo wp_kses_post( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php $comment_id ?>">
<?php if ( 'div' != $args['style'] ) : ?>
<div id="div-comment-<?php $comment_id ?>" class="comment-body">
<?php endif; ?>
    <div class="comments-main-wrap">    
        <div class="comment-meta">
            <div class="comment-author vcard">
            	<?php if(get_avatar($comment, $size='80')) { ?>
                <div class="author-img">
                    <?php echo get_avatar($comment, $size='80'); ?>	
                </div>
                <?php } ?>
            </div><!--/.comment-author-->
        </div><!--/.comment-meta-->
        <div class="comment-details">
            <h4 class="author w-600"><?php /* translators: %1$s: Comments Authors */ ?>
                <?php printf( esc_html__( ' %1$s ', 'petrona' ), get_comment_author_link() ); ?></h4>
            <div class="comment-content">
                <?php comment_text(); ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                	<p><em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'petrona' ); ?></em></p>
                <?php endif; ?>
            </div><!--/.comment-content-->
            <div class="comment-footer">
                <div class="date"><?php
                        /* translators: Comments date, edit link. */
                        printf( esc_html__('%1$s at %2$s', 'petrona'), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( esc_html__( '(Edit)', 'petrona' ), '  ', '' );
                ?></div>
                <div class="reply-button">
                    <?php 
                    echo techt_get_simple_likes_button($comment_id, true);
                    comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
                     ?>
                </div><!--  /.reply-button -->
            </div><!--  /.comment-footer -->
        </div><!-- /.comment-details-->
    </div><!--  /.comments-main-wrap -->
	<?php if ( 'div' != $args['style'] ) : ?>
	</div><!-- /.comment-body -->
	<?php endif; ?>
<?php }