<?php
/**
 * Plugin Name:     oddEvan Gamecock Block
 * Description:     A block to show the latest UofSC post from SBNation.
 * Version:         1.0.0
 * Author:          oddEvan
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     gamecock-block
 *
 * @package         oddEvan\GamecockBlock
 */

namespace oddEvan\GamecockBlock;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Register the block with WordPress.
 *
 * @author oddEvan
 * @since 0.0.1
 */
function register_block() {

	// Define our assets.
	$editor_script   = 'build/index.js';
	$editor_style    = 'build/editor.css';
	$frontend_style  = 'build/style.css';
	$frontend_script = 'build/frontend.js';

	// Verify we have an editor script.
	if ( ! file_exists( plugin_dir_path( __FILE__ ) . $editor_script ) ) {
		wp_die( esc_html__( 'Whoops! You need to run `npm run build` for the oddEvan Gamecock Block first.', 'gamecock-block' ) );
	}

	// Autoload dependencies and version.
	$asset_file = require plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	// Register editor script.
	wp_register_script(
		'gamecock-block-editor-script',
		plugins_url( $editor_script, __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);

	// Register editor style.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $editor_style ) ) {
		wp_register_style(
			'gamecock-block-editor-style',
			plugins_url( $editor_style, __FILE__ ),
			[ 'wp-edit-blocks' ],
			filemtime( plugin_dir_path( __FILE__ ) . $editor_style )
		);
	}

	// Register frontend style.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $frontend_style ) ) {
		wp_register_style(
			'gamecock-block-style',
			plugins_url( $frontend_style, __FILE__ ),
			[],
			filemtime( plugin_dir_path( __FILE__ ) . $frontend_style )
		);
	}

	// Register block with WordPress.
	register_block_type( 'oddevan/gamecock-block', array(
		'editor_script'   => 'gamecock-block-editor-script',
		'editor_style'    => 'gamecock-block-editor-style',
		'style'           => 'gamecock-block-style',
		'render_callback' => __NAMESPACE__ . '\render_gamecock_block',
	) );

	// Register frontend script.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $frontend_script ) ) {
		wp_enqueue_script(
			'gamecock-block-frontend-script',
			plugins_url( $frontend_script, __FILE__ ),
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block' );

/**
 * Render the Gamecock Block
 *
 * @author Evan Hildreth <me@eph.me>
 * @since 1.0.0
 *
 * @return string rendered block HTML
 */
function render_gamecock_block() {
	if ( ! function_exists( 'simplexml_load_file' ) ) {
		return '<!-- ' . __( 'The Gamecock Block requires SimpleXML which is not enabled on your server.', 'gamecock-block' ) . ' -->';
	}

	$feed_from_blog = simplexml_load_file( 'https://www.garnetandblackattack.com/rss/current.xml' );

	if ( ! $feed_from_blog ) {
		return '<!-- ' . __( 'Could not load RSS feed.', 'gamecock-block' ) . ' -->';
	}

	$story     = $feed_from_blog->entry[0];
	$read_more = __( 'Read more...', 'gamecock-block' );
	$link_href = $story->link->attributes()['href'];

	return <<<EOF
<div class="wp-block-oddevan-gamecock-block">
	<h2><a href="$link_href">$story->title</a></h2>
	<p><a href="$link_href">$read_more</a>
</div>
EOF;
}
