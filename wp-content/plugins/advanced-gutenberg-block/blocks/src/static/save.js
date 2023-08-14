import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const blockProps = useBlockProps.save( {
		className: 'wzkb-alert',
	} );
	const { content, align, showHeading, heading, iconName } = attributes;
	const className = blockProps.className;

	return (
		<>
			<div { ...blockProps } className={ className }>
				{ showHeading && (
					<div className="wz-alert-heading">
						{ iconName !== 'none' && (
							<span
								className={ classnames( 'dashicons', {
									[ `dashicons-${ iconName }` ]:
										iconName !== 'none',
								} ) }
							></span>
						) }
						<strong>{ heading }</strong>
					</div>
				) }

				<RichText.Content
					tagName="div"
					value={ content }
					style={ { textAlign: align } }
					className="wz-alert-text"
				/>
	
<section className="px-5 py-6 py-xxl-10 hcf-bp-center hcf-bs-cover hcf-overlay hcf-transform" style="background-image: url('./assets/img/heroes/hero-1/hero-main.jpg');">
  <div className="container">
    <div className="row justify-content-md-center">
      <div className="col-12 col-md-11 col-lg-9 col-xl-7 col-xxl-6 text-center text-white">
        <h1 className="display-3 fw-bold mb-3">Art of Design</h1>
        <p className="lead mb-5">Powerful, extensible, and feature-packed frontend toolkit. Build and customize with Sass, utilize prebuilt grid system and components, and bring projects to life with powerful JavaScript plugins.</p>
        <div className="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <button type="button" className="btn btn-light btn-lg px-4 gap-3">Free Consultation</button>
          <button type="button" className="btn btn-outline-light btn-lg px-4">Buy Credits</button>
        </div>
      </div>
    </div>
  </div>
</section>
			</div>
		</>
	);
}
