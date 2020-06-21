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

		if ( !empty( $attrs[ 'style' ] ) ) {
			$attrs[ 'style' ] = sprintf( 'style="%s"', $attrs[ 'style' ] );
		}
		if ( !empty( $attrs[ 'id' ] ) ) {
			$attrs[ 'id' ] = sprintf( 'id="%s"', $attrs[ 'id' ] );
		}
		if ( !empty( $attrs[ 'class' ] ) ) {
			$attrs[ 'class' ] = sprintf( 'class="%s"', $attrs[ 'class' ] );
		}

		return sprintf( '<%s %s>%s</%s>',
			$sElement,
			implode( ' ', array_filter( $attrs ) ),
			$innerContent,
			$sElement
		);
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
