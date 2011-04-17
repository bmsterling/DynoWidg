console.log( 'core.js is loaded' );
jQuery( document )
.ready(
	function(){
		jQuery('#dynowidg-widget dt')
		.toggle(
			function(){
				jQuery(this)
					.find( 'span' )
					.eq( 0 )
						.hide()
					.end()
					.eq( 1 )
						.show()
					.end()
				.end()
				.next()
					.hide();
			},
			function(){
				jQuery(this)
					.find( 'span' )
					.eq( 1 )
						.hide()
					.end()
					.eq( 0 )
						.show()
					.end()
				.end()
				.next()
					.show();
			}
		);
		
		jQuery('.authenicationCheckbox')
		.live('click',
			function(){
				jQuery('.authenicationCheckbox').not(this).attr('checked', false);
			}
		);
	}
);