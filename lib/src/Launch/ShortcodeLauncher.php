<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Launch;

use FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

class ShortcodeLauncher {

	public function run() {
		add_action( 'wp', function () {
			foreach ( $this->enumShortcodes() as $oSC ) {
				$oSC->init();
			}
		} );
	}

	/**
	 * @return Shortcodes\BaseShortcode[]
	 */
	protected function enumShortcodes() :array {
		return [
			new Shortcodes\CloudflareStream(),
			new Shortcodes\HtmlDiv(),
			new Shortcodes\HtmlElement(),
			new Shortcodes\NoShortcode(),
			new Shortcodes\SiteName(),
		];
	}
}
