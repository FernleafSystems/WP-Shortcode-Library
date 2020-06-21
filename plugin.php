<?php
/* 
Plugin Name: WordPress Shortcode Library
Plugin URI: http://www.hostliketoast.com/wordpress-resource-centre/
Description: Collection of Shortcodes for WordPress
Version: 1.7
Author: One Dollar Plugin
Author URI: https://onedollarplugin.com
Requires PHP: 7.0
Recommended PHP: 7.3
*/

/**
 * Copyright (c) 2020 One Dollar Plugin <support@icontrolwp.com>
 * All rights reserved.
 *
 * "WordPress Shortcode Library" is distributed under the GNU General Public License, Version 2,
 * June 1991. Copyright (C) 1989, 1991 Free Software Foundation, Inc., 51 Franklin
 * St, Fifth Floor, Boston, MA 02110, USA
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

if ( @is_file( __DIR__.'/lib/vendor/autoload.php' ) ) {
	require_once( __DIR__.'/lib/vendor/autoload.php' );

	( new \FernleafSystems\Wordpress\Plugin\ShortcodeLibrary\Launch\ShortcodeLauncher() )->run();
}
return;
class HLT_WordPressShortcodeLibrary {

	protected $aShortcodes;

	public function __construct() {
		add_action( 'wp_loaded', [ $this, 'initializeShortcodes' ] );
	}

	public function initializeShortcodes() {

		$aCodesMapping = $this->getShortcodeArray();
		if ( function_exists( 'add_shortcode' ) ) {
			foreach ( $aCodesMapping as $shortcode => $function_to_call ) {
				add_shortcode( $shortcode, [ $this, $function_to_call ] );
			}
		}
	}

	/**
	 * @return callable[]
	 */
	protected function getShortcodeArray() {
		return [
			'MYFIRSTSHORTCODE' => 'myFirstShortCode',
			'DIVCLEAR'         => 'getDivClearHtml',
			'PRINTDIV'         => 'getDivHtml',
			'TWEET'            => 'getTweetButtonHtml',
			'SITENAME'         => 'getBrandedSiteName',
			'NOSC'             => 'doNotProcessShortcode'
		];
	}

	/**
	 * Here you can create your own Shortcode.
	 *
	 * The Shortcode will be called exactly the same name as the function, but in all-caps
	 *
	 * Currently the shortcode name is "MYFIRSTSHORTCODE" and if you use it as it stand, the
	 * follow line of text will be output on your WordPress site:
	 *
	 * 'Enter the HTML/Javascript that you want to appear'
	 *
	 * @param array  $inaAtts
	 * @param string $insContent
	 * @return string
	 */
	public function myFirstShortCode( $inaAtts = [], $insContent = '' ) {
		$sReturn = 'Enter the HTML/Javascript that you want to appear';

		return $sReturn;
	}

	/**
	 * Returns an HTML string which is a <div> containing CSS to clear:both.
	 *
	 * If you enclose any text (including other shortcodes) between the shortcode
	 * this will be printed within the DIV.
	 *
	 * This is an example of nested shortcodes.
	 *
	 * @param array  $inaAtts
	 * @param string $sContent
	 * @return string
	 */
	public function getDivClearHtml( $inaAtts = [], $sContent = '' ) {
		return $this->getDivHtml( [ 'style' => 'clear:both' ], $sContent );
	}

	/**
	 * A function that will output an HTML DIV element. To give the DIV classes or an ID
	 * simply use shortcode attributes when using the shortcode in your post.
	 *
	 * e.g. [HTMLDIV class="my-div-class" id="my-div-id"] div content [/HTMLDIV]
	 * gives: <div id="my-div-id" class="my-div-class"> div content </div>
	 *
	 * @param array  $inaAtts
	 * @param string $insContent
	 * @return string
	 */
	public function getDivHtml( $inaAtts = [], $insContent = '' ) {

		$this->def( $inaAtts, 'class' );
		$this->def( $inaAtts, 'id' );
		$this->def( $inaAtts, 'style' );

		//Items that don't need to be printed if empty
		$inaAtts[ 'style' ] = $this->noEmptyHtml( $inaAtts[ 'style' ], 'style' );
		$inaAtts[ 'id' ] = $this->noEmptyHtml( $inaAtts[ 'id' ], 'id' );
		$inaAtts[ 'class' ] = $this->noEmptyHtml( $inaAtts[ 'class' ], 'class' );

		$sReturn = '<div '.$inaAtts[ 'style' ]
				   .$inaAtts[ 'id' ]
				   .$inaAtts[ 'class' ]
				   .'>'.do_shortcode( $insContent ).'</div>';

		return $sReturn;
	}

	/**
	 * Will get the name of the Site Title and print it out wrapped in a span so you can
	 * style it consistently throughout the site.
	 *
	 * ID name defaults to 'brandedSiteName' but you can add your own.
	 *
	 * @param array  $inaAtts
	 * @param string $insContent
	 * @return string
	 */
	public function getBrandedSiteName( $inaAtts = [], $insContent = '' ) {

		$this->def( $inaAtts, 'class' );
		$this->def( $inaAtts, 'id', 'brandedSiteName' );
		$this->def( $inaAtts, 'style' );
		$inaAtts[ 'style' ] = $this->noEmptyHtml( $inaAtts[ 'style' ], 'style' );
		$inaAtts[ 'id' ] = $this->noEmptyHtml( $inaAtts[ 'id' ], 'id' );
		$inaAtts[ 'class' ] = $this->noEmptyHtml( $inaAtts[ 'class' ], 'class' );

		$sReturn = '<span '.$inaAtts[ 'style' ]
				   .$inaAtts[ 'id' ]
				   .$inaAtts[ 'class' ]
				   .'>'.get_bloginfo( 'name' ).'</span>';

		return $sReturn;
	}

	/**
	 * Prints a Twitter Share button for the current page.
	 *
	 * @param array  $inaAtts
	 * @param string $insContent
	 * @return string
	 */
	public function getTweetButtonHtml( $inaAtts = [], $insContent = '' ) {

		$this->def( $inaAtts, 'count', 'none' );
		$this->def( $inaAtts, 'via' );
		$this->def( $inaAtts, 'related' );

		//Items that don't need to be printed if empty
		$inaAtts[ 'via' ] = $this->noEmptyHtml( $inaAtts[ 'via' ], 'data-via' );
		$inaAtts[ 'related' ] = $this->noEmptyHtml( $inaAtts[ 'related' ], 'data-related' );

		$sReturn = '<a href="https://twitter.com/share" class="twitter-share-button" data-count="'.$inaAtts[ 'count' ].'"'
				   .$inaAtts[ 'via' ]
				   .$inaAtts[ 'related' ]
				   .'>'.'Tweet'.'</a>';
		$sReturn .= '<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>';

		return $sReturn;
	}

	/**
	 * Simply prevents processing of all nested shortcodes.
	 *
	 * @param array  $inaAtts
	 * @param string $insContent
	 * @return string
	 */
	public function doNotProcessShortcode( $inaAtts = [], $insContent = '' ) {

		$this->def( $inaAtts, 'style' );
		$this->def( $inaAtts, 'element', 'span' );

		//
		$this->noEmptyElement( $inaAtts, 'style' );

		$sElement = $inaAtts[ 'element' ];

		return '<'.$sElement.$inaAtts[ 'style' ].'>'.$insContent.'</'.$sElement.'>';
	}

	/**
	 * A helper function; not a WordPress Shortcode.
	 *
	 * @param        $aSrc
	 * @param        $insKey
	 * @param string $insValue
	 */
	protected function def( &$aSrc, $insKey, $insValue = '' ) {
		if ( !isset( $aSrc[ $insKey ] ) ) {
			$aSrc[ $insKey ] = $insValue;
		}
	}

	/**
	 * A helper function; not a WordPress Shortcode.
	 *
	 * @param string $sCont
	 * @param string $sTag
	 * @return string
	 */
	protected function noEmptyHtml( $sCont, $sTag = '' ) {
		return ( ( $sCont != '' ) ? ' '.$sTag.'="'.$sCont.'" ' : '' );
	}

	/**
	 * @param $inaArgs
	 * @param $insAttrKey
	 */
	protected function noEmptyElement( &$inaArgs, $insAttrKey ) {
		$sAttrValue = $inaArgs[ $insAttrKey ];
		$inaArgs[ $insAttrKey ] = ( empty( $sAttrValue ) ) ? '' : ' '.$insAttrKey.'="'.$sAttrValue.'"';
	}
}

$oHLT_WordPressShortcodeLibrary = new HLT_WordPressShortcodeLibrary( true );