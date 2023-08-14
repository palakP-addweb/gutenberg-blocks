import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { InnerBlocks } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const blockProps = useBlockProps.save( {
		className: 'wzkb-alert',
	} );
	const {		
		backgroundImage,
		overlayColor,
		overlayOpacity
	} = attributes;
	const className = blockProps.className;

	return (
		<>
			<div {...useBlockProps} className="cta-container" style={{
                backgroundImage: `url(${backgroundImage})`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat'
            }}>
                <div className="cta-overlay" style={{background: overlayColor, opacity: overlayOpacity}}></div>
                
                <InnerBlocks.Content />
            </div>
		</>
	);
}
