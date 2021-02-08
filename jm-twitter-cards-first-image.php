<?php
/*
Plugin Name: JM Twitter Cards First image
Plugin URI: https://julien-maury.dev
Description: Meant to grab first image of post content as twitter card image. Requires JM Twitter Cards
Author: Julien Maury
Author URI: https://julien-maury.dev
Version: 1.0
License: GPL2++

JM Twitter Cards Plugin
Copyright (C) 2016, Julien Maury - contact@julien-maury.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Add some security, no direct load !
defined( 'ABSPATH' )
	or die( 'No direct load !' );

add_filter( 'jm_tc_image_source', 'jm_tc_grab_first_image' );
function jm_tc_grab_first_image( $image ) {

	if ( ! is_singular() ) {
		return $image;
	}
	
	global $post;

	if ( has_post_thumbnail( $post ) || get_post_meta( $post->ID, 'cardImage', true ) ) {
		return $image;
	}

	if ( preg_match_all( '`<img [^>]+>`',  $post->post_content, $matches ) ) {

		$_matches = reset( $matches );
		foreach ( $_matches as $image ) {
			if ( preg_match( '`src=(["\'])(.*?)\1`', $image, $_match ) ) {
				return $_match[2];
			}
		}
	}

	return $image;
}
