<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

class SiteName extends HtmlElement {

	const CODE = 'SITENAME';

	protected function buildInnerContent( string $innerContent ) :string {
		return get_bloginfo( 'name' );
	}
}
