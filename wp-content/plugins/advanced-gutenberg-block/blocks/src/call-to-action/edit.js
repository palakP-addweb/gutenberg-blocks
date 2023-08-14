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
    AlignmentToolbar
} from '@wordpress/block-editor';

import { 
	PanelBody,
	IconButton,
	RangeControl,
} from '@wordpress/components';

const ALLOWED_BLOCKS = ['core/button'];

import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	
	const {
		title,
		body,
		alignment,
		titleColor,
		backgroundImage,
		overlayColor,
		overlayOpacity
	} = attributes;

	const onChangeTitle = ( newTitle ) => {
		setAttributes( { title: newTitle } );
	};

	const onChangeBody = ( newBody ) => {
		setAttributes( { body: newBody } );
	};

	const onTitleColorChange = ( newColor ) => {
		setAttributes( { titleColor: newColor } );
	};

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
                <PanelBody title={ 'Font Color Settings' }>
                    <p><strong>Select a Title color:</strong></p>
                    <ColorPalette value={ titleColor }
                                  onChange={ onTitleColorChange } />
                </PanelBody>
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

			<div className="cta-container" style={{
                backgroundImage: `url(${backgroundImage})`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat',
                height: '100vh'
            }}>
                <div className="cta-overlay" style={{background: overlayColor, opacity: overlayOpacity}}></div>
                {
                    <BlockControls>
                        <AlignmentToolbar value={ alignment }
                            onChange={ onChangeAlignment }/>
                    </BlockControls>
                }
                <RichText key="editable"
                          tagName="h2"
                          placeholder="Your CTA Title"
                          value={ title }
                          onChange={ onChangeTitle }
                          style={ { color: titleColor, textAlign: alignment } }/>
                <RichText key="editable"
                          tagName="p"
                          placeholder="Your CTA Description"
                          value={ body }
                          onChange={ onChangeBody }
                          style={ { textAlign: alignment } }/>
                <InnerBlocks allowedBlocks={ ALLOWED_BLOCKS }/>
            </div>			
		</>
	);
}
