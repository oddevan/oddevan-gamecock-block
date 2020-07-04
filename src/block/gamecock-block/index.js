/**
 * REGISTER: oddEvan Gamecock Block.
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

registerBlockType( 'oddevan/gamecock-block', {
	title: __( 'Gamecock Block', 'gamecock-block' ),
	icon: 'edit',
	category: 'common',
	keywords: [
		__( 'oddEvan', 'gamecock-block' ),
		__( 'gamecock-block', 'gamecock-block' ),
	],
	attributes: {
		content: {
			type: 'array',
			source: 'children',
			selector: 'p',
		},
	},
	edit() {
		return (<p>{__( 'Gamecock Block will render here', 'gamecock-block' )}</p>);
	},
	save() {
		return null;
	},
} );
