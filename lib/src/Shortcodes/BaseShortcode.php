<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

abstract class BaseShortcode {

	const CODE = '';

	public function __construct() {
	}

	public function init() {
		if ( !empty( static::CODE ) ) {
			add_shortcode( strtoupper( static::CODE ), function ( $attributes, $innerContent ) {
				try {
					return $this->execCode( $this->parseAttrs( $attributes ), $innerContent );
				}
				catch ( \Exception $oE ) {
					return 'Shortcode "%s" has an error: '.$oE->getMessage();
				}
			} );
		}
	}

	/**
	 * @param array $attrs
	 * @return string
	 * @throws \Exception
	 */
	abstract protected function execCode( array $attrs, string $innerContent ) :string;

	/**
	 * @param string|array $attrs
	 * @return array
	 * @throws \Exception
	 */
	protected function parseAttrs( $attrs ) :array {
		if ( !is_array( $attrs ) ) {
			$attrs = [];
		}

		$attrs = array_merge(
			$this->getDefaultAttrs(),
			$attrs
		);

		$aMissingAttrs = array_diff_key( array_flip( $this->getRequiredAttrs() ), $attrs );
		if ( count( $aMissingAttrs ) > 0 ) {
			throw new \Exception( 'Missing attributes: '.implode( ', ', $aMissingAttrs ) );
		}

		return $attrs;
	}

	protected function getDefaultAttrs() :array {
		return [];
	}

	protected function getRequiredAttrs() :array {
		return [];
	}
}
