<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

class NoShortcode extends HtmlElement {

	const CODE = 'NOSC';

	protected function buildInnerContent( array $attrs, string $innerContent ) :string {
		return $innerContent;
	}
}
