/**
 * External dependencies
 */
import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import {
	RichText,
    InspectorControls,
    ColorPalette,
    MediaUpload,
    InnerBlocks,
    BlockControls,
    AlignmentToolbar,
    useBlockProps
} from '@wordpress/block-editor';

import { 
	PanelBody,
	IconButton,
	RangeControl,
} from '@wordpress/components';

const ALLOWED_BLOCKS = [
    ["core/heading", { placeholder: "Giveaway Title" }],
	["core/paragraph", { placeholder: "Giveaway description" }],
    ['core/button'] ];

import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	
	const {	
		backgroundImage,
		overlayColor,
		overlayOpacity
	} = attributes;

	const onSelectImage = ( newImage ) => {
		setAttributes( { backgroundImage: newImage.sizes.full.url } );
	};

	const onOverlayColorChange = ( newColor ) => {
		setAttributes( { overlayColor: newColor } );
	};

	const onOverlayOpacityChange = ( newOpacity ) => {
		setAttributes( { overlayOpacity: newOpacity } );
	};

	const onChangeAlignment = ( newAlignment ) => {
		setAttributes( {
			alignment: newAlignment === undefined ? 'none' : newAlignment
		} );
	};


	return (
		<>
			<InspectorControls style={ { marginBottom: '40px' } }>
                
                <PanelBody title={ 'Background Image Settings' }>
                    <p><strong>Select a Background Image:</strong></p>
                    <MediaUpload
                        onSelect={ onSelectImage }
                        type="image"
                        value={ backgroundImage }
                        render={ ( { open } ) => (
							<IconButton
								className="editor-media-placeholder__button is-button is-default is-large"
								icon="upload"
								onClick={ open }>
								 Background Image
							</IconButton>
                        )}/>
                    <div style={{ marginTop: '20px', marginBottom: '40px' }}>
                        <p><strong>Overlay Color:</strong></p>
                        <ColorPalette value={ overlayColor }
                                      onChange={ onOverlayColorChange } />
                    </div>
                    <RangeControl
                        label={ 'Overlay Opacity' }
                        value={ overlayOpacity }
                        onChange={ onOverlayOpacityChange }
                        min={ 0 }
                        max={ 1 }
                        step={ 0.01 }/>
                </PanelBody>
            </InspectorControls>

			<div {...useBlockProps} className="cta-container" style={{
                backgroundImage: `url(${backgroundImage})`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat'
            }}>
                <div className="cta-overlay" style={{background: overlayColor, opacity: overlayOpacity}}></div>
                
                <InnerBlocks template={ ALLOWED_BLOCKS }/>
            </div>			
		</>
	);
}
