<?php
/**
 * Plugin Name:       Newspack Homepage Redirect Fix
 * Description:       Patches redirect corner-case homepage redirect loop.
 * Version:           0.0.1
 * Author:            Automattic
 * Author URI:        https://automattic.com
 * Text Domain:       newspack-hp-redirect-fix
 * Domain Path:       /languages
 *
 * @package Newspack
 */

defined( 'ABSPATH' ) || exit;

// Don't redirect if we're only URL encoding query params
add_filter(
	'redirect_canonical',
	function ( $redirect_url, $requested_url ) {
		$parsed_redirect = parse_url( $redirect_url );
		$parsed_requested = parse_url( $requested_url );
		// Scheme changed, do redirect
		if ( $parsed_requested['scheme'] !== $parsed_redirect['scheme'] ) {
			return $redirect_url;
		}
		// Host changed, do redirect
		if ( $parsed_requested['host'] !== $parsed_redirect['host'] ) {
			return $redirect_url;
		}
		// Path changed, do redirect
		if ( $parsed_requested['path'] !== $parsed_redirect['path'] ) {
			return $redirect_url;
		}
		// Parse query args
		parse_str( $parsed_redirect['query'], $query_redirect );
		parse_str( $parsed_requested['query'], $query_request );
		// Sort by keys, if the order changed
		ksort( $query_redirect );
		ksort( $query_request );
		// If parsed query args are the same, skip redirect
		if ( $query_redirect === $query_request ) {
			return false;
		}
		// Otherwise, do redirect
		return $redirect_url;
	},
	10,
	2
);
