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
			new Shortcodes\SiteName()
		];
	}
}
