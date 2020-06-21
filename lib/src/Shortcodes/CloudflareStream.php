<?php

namespace FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Shortcodes;

class CloudflareStream extends BaseShortcode {

	const CODE = 'CF_STREAM';

	/**
	 * @param array  $attrs
	 * @param string $innerContent
	 * @return string
	 * @throws \Exception
	 */
	protected function execCode( array $attrs, string $innerContent ) :string {
		if ( empty( $attrs[ 'id' ] ) ) {
			throw new \Exception( 'No CloudFlare Stream Video ID provided' );
		}

		$player_options = implode( ' ', array_intersect( $this->getPlayerOptions(), $attrs ) );

		if ( !empty( $attrs[ 'caption' ] ) ) {
			$attrs[ 'caption' ] = sprintf( '<div style="text-align: center">%s</div>', $attrs[ 'caption' ] );
		}

		return str_replace( '{{ player_options }}', $player_options,
			str_replace( '{{ caption }}', $attrs[ 'caption' ],
				str_replace( '{{ id }}', $attrs[ 'id' ], $this->getStreamHtml() )
			)
		);
	}

	private function getStreamHtml() :string {
		return '<div class="cf_stream">
					<stream src="{{ id }}" {{ player_options }}></stream>
					<script data-cfasync="false" defer type="text/javascript"
						src="https://embed.videodelivery.net/embed/r4xu.fla9.latest.js?video={{ id }}"></script>
					{{ caption }}
				</div>';
	}

	protected function getDefaultAttrs() :array {
		return [
			'id'      => '',
			'caption' => ''
		];
	}

	private function getPlayerOptions() :array {
		return [
			'controls',
			'preload',
			'autoplay',
			'loop',
			'mute'
		];
	}

	protected function getHelp() :string {
		return sprintf( "Usage:\n<code>%s</code>",
			sprintf( "[CF_STREAM id=\"video ID provided from CloudFlare Stream\"\n%s\n%s /]",
				implode( ' ', $this->getPlayerOptions() ),
				'caption="A Caption of your choice, if you wish"'
			) );
	}
}
