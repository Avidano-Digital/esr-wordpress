/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { InspectorControls } = wp.editor;
const { PanelBody, SelectControl, ToggleControl, TextControl } = wp.components;

/**
 * Internal dependencies
 */
import giveDonorWallOptions from '../data/options';

/**
 * Render Inspector Controls
*/

const Inspector = ( { attributes, setAttributes } ) => {
	const { donorsPerPage, formID, order, columns, showAvatar, showName, showTotal, showDate, showComments, onlyComments, commentLength, readMoreText, loadMoreText } = attributes;
	const saveSetting = ( name, value ) => {
		setAttributes( {
			[ name ]: value,
		} );
	};

	return (
		<InspectorControls key="inspector">
			<PanelBody title={ __( 'Donor Wall Settings' ) }>
				<TextControl
					name="donorsPerPage"
					label={ __( 'Donors Per Page' ) }
					value={ donorsPerPage }
					onChange={ ( value ) => saveSetting( 'donorsPerPage', value ) }/>
				<TextControl
					name="formID"
					label={ __( 'Form ID' ) }
					value={ formID }
					onChange={ ( value ) => saveSetting( 'formID', value ) }/>
				<SelectControl
					label={ __( 'Order' ) }
					name="order"
					value={ order }
					options={ giveDonorWallOptions.order }
					onChange={ ( value ) => saveSetting( 'order', value ) } />
				<SelectControl
					label={ __( 'Columns' ) }
					name="columns"
					value={ columns }
					options={ giveDonorWallOptions.columns }
					onChange={ ( value ) => saveSetting( 'columns', value ) } />
				<ToggleControl
					name="showAvatar"
					label={ __( 'Show Avatar' ) }
					checked={ !! showAvatar }
					onChange={ ( value ) => saveSetting( 'showAvatar', value ) } />
				<ToggleControl
					name="showName"
					label={ __( 'Show Name' ) }
					checked={ !! showName }
					onChange={ ( value ) => saveSetting( 'showName', value ) } />
				<ToggleControl
					name="showTotal"
					label={ __( 'Show Total' ) }
					checked={ !! showTotal }
					onChange={ ( value ) => saveSetting( 'showTotal', value ) } />
				<ToggleControl
					name="showDate"
					label={ __( 'Show Time' ) }
					checked={ !! showDate }
					onChange={ ( value ) => saveSetting( 'showDate', value ) } />
				<ToggleControl
					name="showComments"
					label={ __( 'Show Comments' ) }
					checked={ !! showComments }
					onChange={ ( value ) => saveSetting( 'showComments', value ) } />
				<ToggleControl
					name="onlyComments"
					label={ __( 'Donor With Comments' ) }
					checked={ !! onlyComments }
					onChange={ ( value ) => saveSetting( 'onlyComments', value ) } />
				<TextControl
					name="commentLength"
					label={ __( 'Comment Length' ) }
					value={ commentLength }
					onChange={ ( value ) => saveSetting( 'commentLength', value ) }/>
				<TextControl
					name="readMoreText"
					label={ __( 'Read More Text' ) }
					value={ readMoreText }
					onChange={ ( value ) => saveSetting( 'readMoreText', value ) }/>
				<TextControl
					name="loadMoreText"
					label={ __( 'Load More Text' ) }
					value={ loadMoreText }
					onChange={ ( value ) => saveSetting( 'loadMoreText', value ) }/>
			</PanelBody>
		</InspectorControls>
	);
};

export default Inspector;
