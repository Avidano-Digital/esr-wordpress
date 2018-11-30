/**
 * Give 2Checkout Gateway
 *
 * @description: Tokenizes credit card data for 2Checkout
 */

var give_twocheckout_js;

jQuery( document ).ready( function ( $ ) {

	// Loop through donation forms on page
	$( '.give-form' ).each( function ( element, value ) {

		var form = $( this );
		var form_submit_btn = form.find( '.give-submit' );
		var form_loader = form.find( '.give-loading-animation' );
		var error_output = form.find( '.give-form-wrap' );

		/**
		 * Set per form submission
		 */
		form.submit( function ( e ) {

			// Prevent multiple requests
			form_submit_btn.attr( 'disabled', 'disabled' );
			// Make sure the proper gateway is set
			if ( form.find( 'input[name="give-gateway"]' ).val() === 'twocheckout' ) {
				if ( give_twocheckout_js.sellerId && give_twocheckout_js.publishableKey ) {
					// Call our token request function
					tokenRequest();
					return false;
				} else {
					// Missing credentials
					give_2checkout_error( give_twocheckout_js.keys_error );
					return false;
				}
			}
		} );


		/**
		 * 2Checkout Error
		 *
		 * @param message
		 */
		function give_2checkout_error( message ) {

			var html = '';
			html += '<div class="give_errors">';
			html += '<div class="give_error" id="give_error_private_key">';
			html += '<p><strong>' + give_twocheckout_js.error + '</strong>: ';
			html += message;
			html += '</p></div></div>';

			form_loader.hide();
			form_submit_btn.attr( 'disabled', false );
			form_submit_btn.val( 'Donate Now' );
			error_output.append( html );
			error_output.prepend( html );

		}

		/**
		 * 2Checkout Success Callback
		 *
		 * @param data
		 */
		var successCallback = function ( data ) {
			// Set the token as the value for the token input
			form.find( '.twocheckout-token' ).val( data.response.token.token );
			// IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
			form.unbind( 'submit' ).submit();
		};

		/**
		 * Error Callback
		 *
		 * Called when token creation fails.
		 *
		 * @param data
		 */
		var errorCallback = function ( data ) {
			if ( 200 === data.errorCode ) {
				// Ajax failed
				give_2checkout_error( give_twocheckout_js.api_error );
			} else if ( 'Unauthorized' === data.errorMsg ) {
				// Incorrect credentials
				give_2checkout_error( give_twocheckout_js.keys_error );
			} else {
				// Other errors
				give_2checkout_error( data.errorMsg );
			}
		};

		/**
		 * Token Request
		 */
		var tokenRequest = function () {
			// Setup token request arguments
			var args = {
				sellerId      : give_twocheckout_js.sellerId,
				publishableKey: give_twocheckout_js.publishableKey,
				ccNo          : form.find( '.card-number' ).val(),
				cvv           : form.find( '.card-cvc' ).val(),
				expMonth      : form.find( '.card-expiry' ).val().substring( 0, 2 ),
				expYear       : form.find( '.card-expiry' ).val().substring( 5, 7 )
			};
			// Make the token request
			TCO.requestToken( successCallback, errorCallback, args );
		};

		// Create the token input
		form.append( '<input class="twocheckout-token" name="token" type="hidden" value="">' );

		// Pull in the public key for the environment (sandbox or production)
		TCO.loadPubKey( give_twocheckout_js.env );

	} );

} );
