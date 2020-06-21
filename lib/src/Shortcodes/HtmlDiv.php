<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

class HtmlDiv extends HtmlElement {

	const CODE = 'HTML_DIV';

	protected function getDefaultAttrs() :array {
		$aAttrs = parent::getDefaultAttrs();
		$aAttrs[ 'element' ] = 'div';
		return $aAttrs;
	}
}
