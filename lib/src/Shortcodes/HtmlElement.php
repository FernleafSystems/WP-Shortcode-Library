<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

abstract class HtmlElement extends BaseShortcode {

	/**
	 * @param array  $attrs
	 * @param string $innerContent
	 * @return string
	 * @throws \Exception
	 */
	protected function execCode( array $attrs, string $innerContent ) :string {

		$sElement = $attrs[ 'element' ];
		unset( $attrs[ 'element' ] );

		$aPrintAttrs = [];
		if ( !empty( $attrs[ 'style' ] ) ) {
			$aPrintAttrs[ 'style' ] = sprintf( 'style="%s"', $attrs[ 'style' ] );
		}
		if ( !empty( $attrs[ 'id' ] ) ) {
			$aPrintAttrs[ 'id' ] = sprintf( 'id="%s"', $attrs[ 'id' ] );
		}
		if ( !empty( $attrs[ 'class' ] ) ) {
			$aPrintAttrs[ 'class' ] = sprintf( 'class="%s"', $attrs[ 'class' ] );
		}

		return sprintf( '<%s %s>%s</%s>',
			$sElement,
			implode( ' ', $aPrintAttrs ),
			$this->buildInnerContent( $attrs, $innerContent ),
			$sElement
		);
	}

	protected function buildInnerContent( array $attrs, string $innerContent ) :string {
		return '';
	}

	protected function getDefaultAttrs() :array {
		return [
			'element' => 'span',
			'id'      => '',
			'classes' => '',
			'style'   => '',
		];
	}
}
