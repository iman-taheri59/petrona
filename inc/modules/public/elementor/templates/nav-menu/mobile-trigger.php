<?php
/**
 * Mobile menu trigger template
 */
?>

<div class="techt-nav__mobile-trigger techt-nav-mobile-trigger-align-<?php echo esc_attr( $trigger_align ); ?>">
	<?php $this->__icon( 'mobile_trigger_icon', '<span class="techt-nav__mobile-trigger-open techt-elements-icon">%s</span>' ); ?>
	<?php $this->__icon( 'mobile_trigger_close_icon', '<span class="techt-nav__mobile-trigger-close techt-elements-icon">%s</span>' ); ?>
</div>