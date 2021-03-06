/**
 * EDIT: oddEvan Gamecock Block
 */
import { RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

const Edit = ( props ) => {
	const {
		attributes: {
			content,
		},
		className,
		setAttributes,
	} = props;

	// Update field content on change.
	const onChangeContent = ( newContent ) => {
		setAttributes( { content: newContent } );
	};

	return (
		<RichText
			tagName="p"
			className={ className }
			onChange={ onChangeContent }
			value={ content }
			placeholder={ __( 'oddEvan Gamecock Block Demo...', 'gamecock-block' ) }
		/>
	);
};

export default Edit;
