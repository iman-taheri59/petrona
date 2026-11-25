( function( $ ) {

	'use strict';

	var TechtElementsEditor = {

		activeSection: null,
		editedElement: null,
		modal: false,

		init: function() {
			elementor.channels.editor.on( 'section:activated', TechtElementsEditor.onSearchSectionActivated );
			elementor.channels.editor.on( 'section:activated', TechtElementsEditor.onAnimatedBoxSectionActivated );
			// elementor.channels.editor.on( 'section:activated', TechtElementsEditor.onCartSectionActivated );

			window.elementor.on( 'preview:loaded', function() {
				elementor.$preview[0].contentWindow.TechtElementsEditor = TechtElementsEditor;

				TechtElementsEditor.onPreviewLoaded();
			});
		},


		onSearchSectionActivated: function( sectionName, editor ) {

			var editedElement = editor.getOption( 'editedElementView' );

			if ( 'techt-search' !== editedElement.model.get( 'widgetType' ) ) {
				return;
			}

			window.TechtElementsEditor.activeSection = sectionName;

			var isPopup = -1 !== [ 'section_popup_style', 'section_popup_close_style', 'section_form_style' ].indexOf( sectionName );

			if ( isPopup ) {
				editedElement.$el.find( '.techt-search' ).addClass( 'techt-search-popup-active' );
			} else {
				editedElement.$el.find( '.techt-search' ).removeClass( 'techt-search-popup-active' );
			}

		},

		onPreviewLoaded: function() {
			var $previewContents = window.elementor.$previewContents,
				elementorFrontend = $('#elementor-preview-iframe')[0].contentWindow.elementorFrontend;

			elementorFrontend.hooks.addAction( 'frontend/element_ready/techt-hamburger-panel.default', function( $scope ){
				$scope.find( '.techt__edit-cover' ).on( 'click', TechtElementsEditor.showTemplatesModal );

				$scope.find( '.techt-new-template-link' ).on( 'click', function( event ) {
					//window.location.href = $( this ).attr( 'href' );
					window.open( $( this ).attr( 'href' ) ); // changed on this for the opened link in new tab
				} );
			} );

			TechtElementsEditor.getModal().on( 'hide', function() {
				window.elementor.reloadPreview();
			});
		},

		showTemplatesModal: function() {
			var editLink = $( this ).data( 'template-edit-link' );

			TechtElementsEditor.showModal( editLink );
		},

		showModal: function( link ) {
			var $iframe,
				$loader;

			TechtElementsEditor.getModal().show();

			$( '#techt-edit-template-modal .dialog-message' ).html( '<iframe src="' + link + '" id="techt-edit-frame" width="100%" height="100%"></iframe>' );
			$( '#techt-edit-template-modal .dialog-message' ).append( '<div id="techt-loading"><div class="elementor-loader-wrapper"><div class="elementor-loader"><div class="elementor-loader-boxes"><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div></div></div><div class="elementor-loading-title">Loading</div></div></div>' );

			$iframe = $( '#techt-edit-frame' );
			$loader = $( '#techt-loading' );

			$iframe.on( 'load', function() {
				$loader.fadeOut( 300 );
			} );
		},

		getModal: function() {

			if ( ! TechtElementsEditor.modal ) {
				this.modal = elementor.dialogsManager.createWidget( 'lightbox', {
					id: 'techt-edit-template-modal',
					closeButton: true,
					closeButtonClass: 'eicon-close',
					hide: {
						onBackgroundClick: false
					}
				} );
			}

			return TechtElementsEditor.modal;
		},

		onAnimatedBoxSectionActivated: function( sectionName, editor ) {
			var editedElement = editor.getOption( 'editedElementView' ),
				prevEditedElement = window.TechtElementsEditor.editedElement;

			if ( prevEditedElement
				&& 'techt-animated-box' === prevEditedElement.model.get( 'widgetType' )
				&& 'techt-animated-box' !== editedElement.model.get( 'widgetType' )
			) {

				prevEditedElement.$el.find( '.techt-animated-box' ).removeClass( 'flipped' );
				prevEditedElement.$el.find( '.techt-animated-box' ).removeClass( 'flipped-stop' );

				window.TechtElementsEditor.editedElement = null;
			}

			if ( 'techt-animated-box' !== editedElement.model.get( 'widgetType' ) ) {
				return;
			}

			window.TechtElementsEditor.editedElement = editedElement;
			window.TechtElementsEditor.activeSection = sectionName;

			var isBackSide = -1 !== [ 'section_back_content', 'section_action_button_style' ].indexOf( sectionName );

			if ( isBackSide ) {
				editedElement.$el.find( '.techt-animated-box' ).addClass( 'flipped' );
				editedElement.$el.find( '.techt-animated-box' ).addClass( 'flipped-stop' );
			} else {
				editedElement.$el.find( '.techt-animated-box' ).removeClass( 'flipped' );
				editedElement.$el.find( '.techt-animated-box' ).removeClass( 'flipped-stop' );
			}
		}

	};

	$( window ).on( 'elementor:init', TechtElementsEditor.init );

	window.TechtElementsEditor = TechtElementsEditor;

}( jQuery ) );
