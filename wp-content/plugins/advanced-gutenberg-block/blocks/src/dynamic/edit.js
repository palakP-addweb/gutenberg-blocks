import { __ } from '@wordpress/i18n';

import ServerSideRender from '@wordpress/server-side-render';

import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

import {
	Disabled,
	TextControl,
	ToggleControl,
	PanelBody,
	PanelRow,
	QueryControls,
} from '@wordpress/components';

import metadata from './block.json';
import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( {
		className: 'wz-dynamic-block',
	} );

	const { postsToShow, showHeading, heading, order, orderBy } = attributes;

	const onChangeHeading = ( newHeading ) => {
		setAttributes( { heading: newHeading } );
	};

	const toggleHeading = () => {
		setAttributes( { showHeading: ! showHeading } );
	};

	
	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'advanced-gutenberg-block' ) }
					initialOpen={ true }
				>
					<PanelRow>
						<fieldset>
							<ToggleControl
								label={ __(
									'Show a heading before',
									'advanced-gutenberg-block'
								) }
								help={
									showHeading
										? __(
												'Heading displayed',
												'advanced-gutenberg-block'
										  )
										: __(
												'No Heading displayed',
												'advanced-gutenberg-block'
										  )
								}
								checked={ showHeading }
								onChange={ toggleHeading }
							/>
						</fieldset>
					</PanelRow>
					{ showHeading && (
						<PanelRow>
							<fieldset>
								<TextControl
									label={ __( 'Heading', 'advanced-gutenberg-block' ) }
									value={ heading }
									onChange={ onChangeHeading }
									help={ __(
										'Text to display above the alert box',
										'advanced-gutenberg-block'
									) }
								/>
							</fieldset>
						</PanelRow>
					) }
					<QueryControls
						{ ...{ order, orderBy } }
						numberOfItems={ postsToShow }
						onOrderChange={ ( value ) =>
							setAttributes( { order: value } )
						}
						onOrderByChange={ ( value ) =>
							setAttributes( { orderBy: value } )
						}
						onNumberOfItemsChange={ ( value ) =>
							setAttributes( { postsToShow: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<Disabled>
					<ServerSideRender
						block={ metadata.name }
						skipBlockSupportAttributes
						attributes={ attributes }
					/>
				</Disabled>
			</div>
		</>
	);
}
