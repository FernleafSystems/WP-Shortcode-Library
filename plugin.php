<?php
/* 
Plugin Name: WordPress Shortcode Library
Plugin URI: http://www.hostliketoast.com/wordpress-resource-centre/
Description: Collection of Shortcodes for WordPress
Version: 2.0.0
Author: One Dollar Plugin
Author URI: https://onedollarplugin.com
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