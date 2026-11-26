<?php $this->nonce_field(); ?>
<div class="techt_metabox template-metaboxs">
	<div class="techt_metabox_tab" id="techt_tab_template">
		<?php 
        $this->select ( 'template_types', esc_html__( 'Select Template For:', 'petrona' ), array (
            '' => esc_html__( 'Select For Template', 'petrona' ),
            'header' => esc_html__( 'Header', 'petrona' ),
            'footer' => esc_html__( 'Footer', 'petrona' ),
            'block' => esc_html__( 'Block', 'petrona' ),
            'megamenu' => esc_html__( 'Mega Menu', 'petrona' ),
            'preloader' => esc_html__( 'Preloader', 'petrona' ),
        ), esc_html__( 'Choose for where you want to added this template.', 'petrona' ) ); ?>
	</div>
</div>