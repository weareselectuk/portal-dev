jQuery( document ).ready(function( $ ) {
	$( '.health-check-accordion' ).on( 'click', '.health-check-accordion-trigger', function() {
		var isExpanded = ( 'true' === $( this ).attr( 'aria-expanded' ) );

		if ( isExpanded ) {
			$( this ).attr( 'aria-expanded', 'false' );
			$( '#' + $( this ).attr( 'aria-controls' ) ).attr( 'hidden', true );
		} else {
			$( this ).attr( 'aria-expanded', 'true' );
			$( '#' + $( this ).attr( 'aria-controls' ) ).attr( 'hidden', false );
		}
	} );
});

/* global ClipboardJS, SiteHealth, wp */
jQuery( document ).ready( function( $ ) {
	var clipboard;

	if ( 'undefined' !== typeof ClipboardJS ) {
		clipboard = new ClipboardJS( '.site-health-copy-buttons .copy-button' );

		// Debug information copy section.
		clipboard.on( 'success', function( e ) {
			var $wrapper = $( e.trigger ).closest( 'div' );

			$( '.success', $wrapper ).addClass( 'visible' );

			wp.a11y.speak( SiteHealth.string.site_info_copied );
		});
	}
});

/* global ajaxurl, SiteHealth */
jQuery( document ).ready(function( $ ) {
    var isDebugTab = $( '.health-check-debug-tab.active' ).length;
    var pathsSizesSection = $( '#health-check-accordion-block-wp-paths-sizes' );

    function getDirectorySizes() {
        var data = {
            action: 'health-check-get-sizes',
            _wpnonce: SiteHealth.nonce.site_status_result
        };

        var timestamp = ( new Date().getTime() );

        // After 3 seconds announce that we're still waiting for directory sizes.
        var timeout = window.setTimeout( function() {
            wp.a11y.speak( SiteHealth.string.please_wait );
        }, 3000 );

        $.post( {
            type: 'POST',
            url: ajaxurl,
            data: data,
            dataType: 'json'
        } ).done( function( response ) {
            updateDirSizes( response.data || {} );
        } ).always( function() {
            var delay = ( new Date().getTime() ) - timestamp;

            $( '.health-check-wp-paths-sizes.spinner' ).css( 'visibility', 'hidden' );

            if ( delay > 3000 ) {

                // We have announced that we're waiting.
                // Announce that we're ready after giving at least 3 seconds for the first announcement
                // to be read out, or the two may collide.
                if ( delay > 6000 ) {
                    delay = 0;
                } else {
                    delay = 6500 - delay;
                }

                window.setTimeout( function() {
                    wp.a11y.speak( SiteHealth.string.site_health_complete );
                }, delay );
            } else {

                // Cancel the announcement.
                window.clearTimeout( timeout );
            }

            $( document ).trigger( 'site-health-info-dirsizes-done' );
        } );
    }

    function updateDirSizes( data ) {
        var copyButton = $( 'button.button.copy-button' );
        var clipdoardText = copyButton.attr( 'data-clipboard-text' );

        $.each( data, function( name, value ) {
            var text = value.debug || value.size;

            if ( 'undefined' !== typeof text ) {
                clipdoardText = clipdoardText.replace( name + ': loading...', name + ': ' + text );
            }
        } );

        copyButton.attr( 'data-clipboard-text', clipdoardText );

        pathsSizesSection.find( 'td[class]' ).each( function( i, element ) {
            var td = $( element );
            var name = td.attr( 'class' );

            if ( data.hasOwnProperty( name ) && data[ name ].size ) {
                td.text( data[ name ].size );
            }
        } );
    }

    if ( isDebugTab ) {
        if ( pathsSizesSection.length ) {
            getDirectorySizes();
        }
    }
});

/* global ajaxurl */
jQuery( document ).ready(function( $ ) {
	function healthCheckFailureModal( markup, action, parent ) {
		$( '#dynamic-content' ).html( markup );
		$( '.health-check-modal' ).data( 'modal-action', action ).data( 'parent-field', parent ).show();
	}

	function healthCheckFailureModalClose( modal ) {
		modal.hide();
	}

	$( '.modal-close' ).click(function( e ) {
		e.preventDefault();
		healthCheckFailureModalClose( $( this ).closest( '.health-check-modal' ) );
	});

	$( '.health-check-modal' ).on( 'submit', 'form', function( e ) {
		var data = $( this ).serializeArray(),
			modal = $( this ).closest( '.health-check-modal' );

		e.preventDefault();

		$.post(
			ajaxurl,
			data,
			function( response ) {
				if ( true === response.success ) {
					$( modal.data( 'parent-field' ) ).append( response.data.message );
				} else {
					healthCheckFailureModal( response.data.message, data.action, modal.data( 'parent-field' ) );
				}
			}
		);

		healthCheckFailureModalClose( modal );
	});
});

/* global SiteHealth, ajaxurl, healthCheckFailureModal */
jQuery( document ).ready(function( $ ) {
	function testDefaultTheme() {
		var $parent = $( '.individual-loopback-test-status', '#test-single-no-theme' ),
			data = {
				'action': 'health-check-loopback-default-theme',
				'_wpnonce': SiteHealth.nonce.loopback_default_theme
			};

		$.post(
			ajaxurl,
			data,
			function( response ) {
				if ( true === response.success ) {
					$parent.html( response.data.message );
				} else {
					healthCheckFailureModal( response.data, data.action, $parent );
				}
			},
			'json'
		);
	}

	function testSinglePlugin() {
		var $testLines = $( '.not-tested', '#loopback-individual-plugins-list' );
		var $parentField,
			$testLine,
			data;

		if ( $testLines.length < 1 ) {
			testDefaultTheme();
			return null;
		}

		$testLine = $testLines.first();
		data = {
			'action': 'health-check-loopback-individual-plugins',
			'plugin': $testLine.data( 'test-plugin' ),
			'_wpnonce': SiteHealth.nonce.loopback_individual_plugins
		};

		$parentField = $( '.individual-loopback-test-status', $testLine );

		$parentField.html( SiteHealth.string.running_tests );

		$.post(
			ajaxurl,
			data,
			function( response ) {
				if ( true === response.success ) {
					$testLine.removeClass( 'not-tested' );
					$parentField.html( response.data.message );
					testSinglePlugin();
				} else {
					healthCheckFailureModal( response.data, data.action, $parentField );
				}
			},
			'json'
		);
	}

	$( '.dashboard_page_health-check' ).on( 'click', '#loopback-no-plugins', function( e ) {
		var $trigger = $( this ),
			$parent = $( this ).closest( 'p' ),
			data = {
				'action': 'health-check-loopback-no-plugins',
				'_wpnonce': SiteHealth.nonce.loopback_no_plugins
			};

		e.preventDefault();

		$( this ).html( '<span class="spinner" style="visibility: visible;"></span> ' + SiteHealth.string.please_wait );

		$.post(
			ajaxurl,
			data,
			function( response ) {
				$trigger.remove();
				if ( true === response.success ) {
					$parent.append( response.data.message );
				} else {
					healthCheckFailureModal( response.data, data.action, $parent );
				}
			},
			'json'
		);
	}).on( 'click', '#loopback-individual-plugins', function( e ) {
		e.preventDefault();

		$( this ).remove();

		testSinglePlugin();
	});
});

/* global ajaxurl, SiteHealth, wp */
jQuery( document ).ready(function( $ ) {
	var data;
	var isDebugTab = $( '.health-check-debug-tab.active' ).length;

	$( '.site-health-view-passed' ).on( 'click', function() {
		var goodIssuesWrapper = $( '#health-check-issues-good' );

		goodIssuesWrapper.toggleClass( 'hidden' );
		$( this ).attr( 'aria-expanded', ! goodIssuesWrapper.hasClass( 'hidden' ) );
	} );

	function AppendIssue( issue ) {
		var template = wp.template( 'health-check-issue' ),
			issueWrapper = $( '#health-check-issues-' + issue.status ),
			heading,
			count;

		SiteHealth.site_status.issues[ issue.status ]++;

		count = SiteHealth.site_status.issues[ issue.status ];

		if ( 'critical' === issue.status ) {
			if ( count <= 1 ) {
				heading = SiteHealth.string.site_info_heading_critical_single.replace( '%s', '<span class="issue-count">' + count + '</span>' );
			} else {
				heading = SiteHealth.string.site_info_heading_critical_plural.replace( '%s', '<span class="issue-count">' + count + '</span>' );
			}
		} else if ( 'recommended' === issue.status ) {
			if ( count <= 1 ) {
				heading = SiteHealth.string.site_info_heading_recommended_single.replace( '%s', '<span class="issue-count">' + count + '</span>' );
			} else {
				heading = SiteHealth.string.site_info_heading_recommended_plural.replace( '%s', '<span class="issue-count">' + count + '</span>' );
			}
		} else if ( 'good' === issue.status ) {
			if ( count <= 1 ) {
				heading = SiteHealth.string.site_info_heading_good_single.replace( '%s', '<span class="issue-count">' + count + '</span>' );
			} else {
				heading = SiteHealth.string.site_info_heading_good_plural.replace( '%s', '<span class="issue-count">' + count + '</span>' );
			}
		}

		if ( heading ) {
			$( '.site-health-issue-count-title', issueWrapper ).html( heading );
		}

		$( '.issues', '#health-check-issues-' + issue.status ).append( template( issue ) );
	}

	function RecalculateProgression() {
		var r, c, pct;
		var $progress = $( '.site-health-progress' );
		var $progressCount = $progress.find( '.site-health-progress-count' );
		var $circle = $( '.site-health-progress svg #bar' );
		var totalTests = parseInt( SiteHealth.site_status.issues.good, 0 ) + parseInt( SiteHealth.site_status.issues.recommended, 0 ) + ( parseInt( SiteHealth.site_status.issues.critical, 0 ) * 1.5 );
		var failedTests = parseInt( SiteHealth.site_status.issues.recommended, 0 ) + ( parseInt( SiteHealth.site_status.issues.critical, 0 ) * 1.5 );
		var val = 100 - Math.ceil( ( failedTests / totalTests ) * 100 );

		if ( 0 === totalTests ) {
			$progress.addClass( 'hidden' );
			return;
		}

		$progress.removeClass( 'loading' );

		r = $circle.attr( 'r' );
		c = Math.PI * ( r * 2 );

		if ( 0 > val ) {
			val = 0;
		}
		if ( 100 < val ) {
			val = 100;
		}

		pct = ( ( 100 - val ) / 100 ) * c;

		$circle.css( { strokeDashoffset: pct } );

		if ( 1 > parseInt( SiteHealth.site_status.issues.critical, 0 ) ) {
			$( '#health-check-issues-critical' ).addClass( 'hidden' );
		}

		if ( 1 > parseInt( SiteHealth.site_status.issues.recommended, 0 ) ) {
			$( '#health-check-issues-recommended' ).addClass( 'hidden' );
		}

		if ( 50 <= val ) {
			$circle.addClass( 'orange' ).removeClass( 'red' );
		}

		if ( 90 <= val ) {
			$circle.addClass( 'green' ).removeClass( 'orange' );
		}

		if ( 100 === val ) {
			$( '.site-status-all-clear' ).removeClass( 'hide' );
			$( '.site-status-has-issues' ).addClass( 'hide' );
		}

		$progressCount.text( val + '%' );

		if ( ! isDebugTab ) {
			$.post(
				ajaxurl,
				{
					'action': 'health-check-site-status-result',
					'_wpnonce': SiteHealth.nonce.site_status_result,
					'counts': SiteHealth.site_status.issues
				}
			);
		}

		wp.a11y.speak( SiteHealth.string.site_health_complete_screen_reader.replace( '%s', val + '%' ) );
	}

	function maybeRunNextAsyncTest() {
		var doCalculation = true;

		if ( 1 <= SiteHealth.site_status.async.length ) {
			$.each( SiteHealth.site_status.async, function() {
				var data = {
					'action': 'health-check-site-status',
					'feature': this.test,
					'_wpnonce': SiteHealth.nonce.site_status
				};

				if ( this.completed ) {
					return true;
				}

				doCalculation = false;

				this.completed = true;

				$.post(
					ajaxurl,
					data,
					function( response ) {
						AppendIssue( response.data );
						maybeRunNextAsyncTest();
					}
				);

				return false;
			} );
		}

		if ( doCalculation ) {
			RecalculateProgression();
		}
	}

	if ( 'undefined' !== typeof SiteHealth ) {
		if ( 0 === SiteHealth.site_status.direct.length && 0 === SiteHealth.site_status.async.length ) {
			RecalculateProgression();
		} else {
			SiteHealth.site_status.issues = {
				'good': 0,
				'recommended': 0,
				'critical': 0
			};
		}

		if ( 0 < SiteHealth.site_status.direct.length ) {
			$.each( SiteHealth.site_status.direct, function() {
				AppendIssue( this );
			} );
		}

		if ( 0 < SiteHealth.site_status.async.length ) {
			data = {
				'action': 'health-check-site-status',
				'feature': SiteHealth.site_status.async[0].test,
				'_wpnonce': SiteHealth.nonce.site_status
			};

			SiteHealth.site_status.async[0].completed = true;

			$.post(
				ajaxurl,
				data,
				function( response ) {
					AppendIssue( response.data );
					maybeRunNextAsyncTest();
				}
			);
		} else {
			RecalculateProgression();
		}
	}
});

/* global ajaxurl, SiteHealth */
jQuery( document ).ready(function( $ ) {
	$( '#health-check-file-integrity' ).submit( function( e ) {
		var data = {
			'action': 'health-check-files-integrity-check',
			'_wpnonce': SiteHealth.nonce.files_integrity_check
		};

		e.preventDefault();

		$( '#tools-file-integrity-response-holder' ).html( '<span class="spinner"></span>' );
		$( '#tools-file-integrity-response-holder .spinner' ).addClass( 'is-active' );

		$.post(
			ajaxurl,
			data,
			function( response ) {
				$( '#tools-file-integrity-response-holder .spinner' ).removeClass( 'is-active' );
				$( '#tools-file-integrity-response-holder' ).parent().css( 'height', 'auto' );
				$( '#tools-file-integrity-response-holder' ).html( response.data.message );
			}
		);
	});

	$( '#tools-file-integrity-response-holder' ).on( 'click', 'a[href="#health-check-diff"]', function( e ) {
		var file = $( this ).data( 'file' ),
			data;

		e.preventDefault();

		$( '#health-check-diff-modal' ).toggle();
		$( '#health-check-diff-modal #health-check-diff-modal-content .spinner' ).addClass( 'is-active' );

		data = {
			'action': 'health-check-view-file-diff',
			'file': file,
			'_wpnonce': SiteHealth.nonce.view_file_diff
		};

		$.post(
			ajaxurl,
			data,
			function( response ) {
				$( '#health-check-diff-modal #health-check-diff-modal-diff' ).html( response.data.message );
				$( '#health-check-diff-modal #health-check-diff-modal-content h3' ).html( file );
				$( '#health-check-diff-modal #health-check-diff-modal-content .spinner' ).removeClass( 'is-active' );
			}
		);
	});
});

jQuery( document ).ready(function( $ ) {
	$( '#health-check-diff-modal' ).on( 'click', 'a[href="#health-check-diff-modal-close"]', function( e ) {
		e.preventDefault();
		$( '#health-check-diff-modal' ).toggle();
		$( '#health-check-diff-modal #health-check-diff-modal-diff' ).html( '' );
		$( '#health-check-diff-modal #health-check-diff-modal-content h3' ).html( '' );
	});

	$( document ).keyup(function( e ) {
		if ( 27 === e.which ) {
			$( '#health-check-diff-modal' ).css( 'display', 'none' );
			$( '#health-check-diff-modal #health-check-diff-modal-diff' ).html( '' );
			$( '#health-check-diff-modal #health-check-diff-modal-content h3' ).html( '' );
		}
	});
});

/* global ajaxurl, SiteHealth */
jQuery( document ).ready(function( $ ) {
	$( '#health-check-mail-check' ).submit( function( e ) {
		var email = $( '#health-check-mail-check #email' ).val(),
			emailMessage = $( '#health-check-mail-check #email_message' ).val(),
			data;

		e.preventDefault();

		$( '#tools-mail-check-response-holder' ).html( '<span class="spinner"></span>' );
		$( '#tools-mail-check-response-holder .spinner' ).addClass( 'is-active' );

		data = {
			'action': 'health-check-mail-check',
			'email': email,
			'email_message': emailMessage,
			'_wpnonce': SiteHealth.nonce.mail_check
		};

		$.post(
			ajaxurl,
			data,
			function( response ) {
				$( '#tools-mail-check-response-holder .spinner' ).removeClass( 'is-active' );
				$( '#tools-mail-check-response-holder' ).parent().css( 'height', 'auto' );
				$( '#tools-mail-check-response-holder' ).html( response.data.message );
			}
		);
	});
});
