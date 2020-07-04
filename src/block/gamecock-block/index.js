/**
 * REGISTER: oddEvan Gamecock Block.
 */
import edit from './edit';
import save from './save';

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
	edit,
	save,
} );
