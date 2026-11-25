<ul class="techt_metabox_tabs">
	<li class="active"><a href="#header"><?php echo esc_html__( "Header", 'petrona' ) ?></a></li>
	<li><a href="#contents"><?php echo esc_html__( "Content Area", 'petrona' ) ?></a></li>
	<li><a href="#footer"><?php echo esc_html__( "Footer", 'petrona' ) ?></a></li>
	<li><a href="#preloader"><?php echo esc_html__( "Preloader", 'petrona' ) ?></a></li>
</ul>
<div class='techt_metabox'>
	<div class="techt_metabox_tab" id="techt_tab_header">
		<?php
		$this->select ( 'header_show_header', esc_html__( 'Show header', 'petrona' ), array (
			'' 	=> esc_html__( 'Theme Setting', 'petrona' ),
			'yes' 		=> esc_html__( 'Yes', 'petrona' ),
			'no' 		=> esc_html__( 'No', 'petrona' )
		), esc_html__( 'Choose to show or hide the header.', 'petrona' ) ); ?>
	</div>
	<div class="techt_metabox_tab" id="techt_tab_sidebars">
		<?php
		$this->select ( 'sidebar_position', esc_html__( 'Sidebar Position', 'petrona' ),
			array (
				'' => esc_html__( 'Theme Setting', 'petrona' ),
				'right' => esc_html__( 'Right', 'petrona' ),
				'left' => esc_html__( 'Left', 'petrona' ),
		), esc_html__( 'Select the sidebar position.', 'petrona' ) );
		?>
	</div>
	<div class="techt_metabox_tab" id="techt_tab_contents">
	    <?php 
	    $this->text ( 'content_padding_top',  
	        esc_html__( 'Padding Top', 'petrona' ),  
	        esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );

	    $this->text ( 'content_padding_bottom',  
	        esc_html__( 'Padding Bottom', 'petrona' ),  
	        esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );
	    ?>
	</div>
	<div class="techt_metabox_tab" id="techt_tab_footer">
		<?php
		$this->select ( 'footer_show_footer', esc_html__( 'Show footer', 'petrona' ), array (
			'' => esc_html__( 'Default', 'petrona' ),
			'yes' => esc_html__( 'Yes', 'petrona' ),
			'no' => esc_html__( 'No', 'petrona' ),
		), esc_html__( 'Choose to show or hide the footer.', 'petrona' ) );
		?>
	</div>
	<div class="techt_metabox_tab" id="techt_tab_preloader">
		<?php
		$this->select ( 'show_preloader', esc_html__( 'Show Preloader', 'petrona' ), array (
			'' 	=> esc_html__( 'Theme Setting', 'petrona' ),
			'yes' 		=> esc_html__( 'Yes', 'petrona' ),
			'no' 		=> esc_html__( 'No', 'petrona' )
		), esc_html__( 'Choose to show or hide the Preloader.', 'petrona' ) );
		?>
	</div>
</div>
<div class="clear"></div>