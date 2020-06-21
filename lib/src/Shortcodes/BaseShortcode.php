<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

abstract class BaseShortcode {

	const CODE = '';

	public function __construct() {
	}

	public function init() {
		if ( !empty( static::CODE ) && !shortcode_exists( static::CODE ) ) {
			add_shortcode( strtoupper( static::CODE ), function ( $attrs, $innerContent ) {
				if ( is_array( $attrs ) && in_array( 'help', array_map( 'strtolower', $attrs ) ) ) {
					return sprintf( '<pre style="white-space:pre-line;">[%s] %s</pre>', static::CODE, $this->getHelp() );
				}
				else {
					try {
						return $this->execCode( $this->parseAttrs( $attrs ), $innerContent );
					}
					catch ( \Exception $oE ) {
						return sprintf( 'Shortcode "%s" has an error: %s', static::CODE, $oE->getMessage() );
					}
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

		// Make all attribute keys lower case.
		foreach ( $attrs as $attrKey => $attrValue ) {
			if ( is_string( $attrKey ) && preg_match( '/[A-Z]/', $attrKey ) ) {
				$attrs[ strtolower( $attrKey ) ] = $attrValue;
				unset( $attrs[ $attrKey ] );
			}
		}

		$attrs = array_merge( $this->getDefaultAttrs(), $attrs );

		$aMissingAttrs = array_diff_key( array_flip( $this->getRequiredAttrs() ), $attrs );
		if ( count( $aMissingAttrs ) > 0 ) {
			throw new \Exception( 'Missing attributes: '.implode( ', ', $aMissingAttrs ) );
		}

		return $attrs;
	}

	protected function getHelp() :string {
		return 'No help has been provided for this shortcode yet.';
	}

	protected function getDefaultAttrs() :array {
		return [];
	}

	protected function getRequiredAttrs() :array {
		return [];
	}
}