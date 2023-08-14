import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { InnerBlocks } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const blockProps = useBlockProps.save( {
		className: 'wzkb-alert',
	} );
	const {
		title,
		body,
		alignment,
		titleColor,
		backgroundImage,
		overlayColor,
		overlayOpacity
	} = attributes;
	const className = blockProps.className;

	return (
		<>
			<div className="cta-container" style={{
                backgroundImage: `url(${backgroundImage})`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat'
            }}>
                <div className="cta-overlay" style={{background: overlayColor, opacity: overlayOpacity}}></div>
                <h2 style={ { color: titleColor, textAlign: alignment } }>{ title }</h2>
                <RichText.Content tagName="p"
                                  value={ body }
                                  style={ { textAlign: alignment } }/>
                <InnerBlocks.Content />
            </div>
		</>
	);
}
