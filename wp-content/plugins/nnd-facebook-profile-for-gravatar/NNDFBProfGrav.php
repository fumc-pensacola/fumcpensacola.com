<?php
/*
Plugin Name: NND Facebook Gravatar Grabber
Plugin URI: http://nnd.bostonsuperblog.com/2010/10/30/wordpress-plug-in-nerd-next-doors-facebook-gravatar-grabber/
Description: If a user or commenter's URL field contains link to their Facebook profile this plugin will grab their Profile Picture for use as their Gravatar across the site!
Version: 1.9
Author: Dan Jones
Author URI: http://nnd.BostonSuperBlog.com
License: GPL2
*/

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( !function_exists( 'get_avatar' ) ) :
/* function get_avatar( $id_or_email, $size = '96', $default = '', $alt = false ) { */
function get_avatar( $id_or_email, $size = '96',$default = '', $alt = false ) {
	if ( ! get_option('show_avatars') )
		return false;

	if ( false === $alt)
		$safe_alt = '';
	else
		$safe_alt = esc_attr( $alt );

	if ( !is_numeric($size) )
		$size = '96';

	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;

		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	if ( empty($default) ) {
		$avatar_default = get_option('avatar_default');
		if ( empty($avatar_default) )
			$default = 'mystery';
		else
			$default = $avatar_default;
	}
/* IF THER USER / COMMENTER HAS FACEBOOK IN THEIR URL GO GRAB THEIR PROFILE PICTURE */
// CHECK FOR A COMMENTER WHOSE URL IS FACEBOOK
if(preg_match("/facebook/i",$email)){
		$author_url =  $id_or_email->comment_author_url;
        $parse_author_url = (parse_url($author_url));
        $parse_author_url_q = $parse_author_url['query'];
            if(preg_match('/id[=]([0-9]*)/', $parse_author_url_q, $match)){
                $fb_id = "/".$match[1];}
            else{ $fb_id = $parse_author_url['path'];
            }
        $out = "http://graph.facebook.com".$fb_id."/picture";
		$avatar = "<img style='width:{$size}px; height:{$size}px;' alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
//CHECK FOR A USER OR COMMENTER WHOSE URL IS FACEBOOK [NOTE: I'm not sure if this does anything that the other 2 don't cover]
else if (preg_match("/facebook/i",$id_or_email->comment_author_url)) {
		$author_url =  $id_or_email->comment_author_url;
        $parse_author_url = (parse_url($author_url));
        $parse_author_url_q = $parse_author_url['query'];
            if(preg_match('/id[=]([0-9]*)/', $parse_author_url_q, $match)){
                $fb_id = "/".$match[1];}
            else{ $fb_id = $parse_author_url['path'];
            }
        $out = "http://graph.facebook.com".$fb_id."/picture";
		$avatar = "<img style='width:{$size}px; height:{$size}px;' alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
//CHECK THE USER'S URLs FOR FACEBOOK
else if ( preg_match("/facebook/i",$user->user_url) || preg_match("/facebook/i",$user->nndurl2) || preg_match("/facebook/i",$user->nndurl3) || preg_match("/facebook/i",$user->nndfbook)) {
		if (preg_match("/facebook/i",$user->nndfbook)) {
			$author_url = $user->nndfbook; }
		else if (preg_match("/facebook/i",$user->nndurl3)) {
			$author_url =  $user->nndurl3;}
		else if (preg_match("/facebook/i",$user->nndurl2)){
			$author_url =  $user->nndurl2;}
		else {
			$author_url =  $user->user_url;}
        $parse_author_url = (parse_url($author_url));
        $parse_author_url_q = $parse_author_url['query'];
            if(preg_match('/id[=]([0-9]*)/', $parse_author_url_q, $match)){
                $fb_id = "/".$match[1];}
            else{ $fb_id = $parse_author_url['path'];
            }
        $out = "http://graph.facebook.com".$fb_id."/picture";
		$avatar = "<img style='width:{$size}px; height:{$size}px;' alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
else{
	if ( !empty($email) )
		$email_hash = md5( strtolower( $email ) );

	if ( is_ssl() ) {
		$host = 'https://secure.gravatar.com';
	} else {
		if ( !empty($email) )
			$host = sprintf( "http://%d.gravatar.com", ( hexdec( $email_hash{0} ) % 2 ) );
		else
			$host = 'http://0.gravatar.com';
	}

	if ( 'mystery' == $default )
		$default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
	elseif ( 'blank' == $default )
		$default = includes_url('images/blank.gif');
	elseif ( !empty($email) && 'gravatar_default' == $default )
		$default = '';
	elseif ( 'gravatar_default' == $default )
		$default = "$host/avatar/s={$size}";
	elseif ( empty($email) )
		$default = "$host/avatar/?d=$default&amp;s={$size}";
	elseif ( strpos($default, 'http://') === 0 )
		$default = add_query_arg( 's', $size, $default );

	if ( !empty($email) ) {
		$out = "$host/avatar/";
		$out .= $email_hash;
		$out .= '?s='.$size;
		$out .= '&amp;d=' . urlencode( $default );

		$rating = get_option('avatar_rating');
		if ( !empty( $rating ) )
			$out .= "&amp;r={$rating}";

		$avatar = "<img style='width:{$size}px; height:{$size}px;' alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
	} else {
		$avatar = "<img style='width:{$size}px; height:{$size}px;' alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
	}
}
	return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt);
}
endif;

/*EVERYTHING BELOW ADDS ADDITIONAL USER META FIELDS WHICH ARE USEFULL BUT NOT REQUIRED FOR FUNCTIONALITY*/
class nnd_user_meta {

 function nnd_user_meta() {
 if ( is_admin() )
 {
 add_action('show_user_profile', array(&$this,'action_show_user_profile'));
 add_action('edit_user_profile', array(&$this,'action_show_user_profile'));
 add_action('personal_options_update', array(&$this,'action_process_option_update'));
 add_action('edit_user_profile_update', array(&$this,'action_process_option_update'));
 }

 }

 function action_show_user_profile($user)
 {
 ?>
 <h3><?php _e('Additional Contact Information') ?></h3>

<table class="form-table">
<tr>
	<th><label for="nndurl2"><?php _e('Website 2') ?></label></th>
	<td><input type="text" name="nndurl2" id="nndurl2" value="<?php echo esc_attr(get_the_author_meta('nndurl2', $user->ID) ); ?>" class="regular-text code" /></td>
</tr>
<tr>
	<th><label for="nndurl3"><?php _e('Website 3') ?></label></th>
	<td><input type="text" name="nndurl3" id="nndurl3" value="<?php echo esc_attr(get_the_author_meta('nndurl3', $user->ID) ); ?>" class="regular-text code" /></td>
</tr>
<tr>
	<th><label for="nndtwit"><?php _e('Twitter') ?></label></th>
	<td><input type="text" name="nndtwit" id="nndtwit" value="<?php echo esc_attr(get_the_author_meta('nndtwit', $user->ID) ); ?>" class="regular-text code" /></td>
</tr>
<tr>
	<th><label for="nndfbook"><?php _e('Facebook') ?></label></th>
	<td><input type="text" name="nndfbook" id="nndfbook" value="<?php echo esc_attr(get_the_author_meta('nndfbook', $user->ID) ); ?>" class="regular-text code" /></td>
</tr>
 </table>
 <?php /*
 <tr>
	<th><label for="something"><?php _e('Display Name') ?></label></th>
	<td><input type="text" name="something" id="something" value="<?php echo esc_attr(get_the_author_meta('something', $user->ID) ); ?>" class="regular-text code" /></td>
</tr>
 </table>
 */?>
 
 <?php
 }

 function action_process_option_update($user_id)
 {
 if ( !current_user_can( 'edit_user', $user_id ) )	
	return false;
 update_usermeta($user_id, 'nndurl2', ( isset($_POST['nndurl2']) ? $_POST['nndurl2'] : '' ) );
 update_usermeta($user_id, 'nndurl3', ( isset($_POST['nndurl3']) ? $_POST['nndurl3'] : '' ) );
 update_usermeta($user_id, 'nndtwit', ( isset($_POST['nndtwit']) ? $_POST['nndtwit'] : '' ) );
 update_usermeta($user_id, 'nndfbook', ( isset($_POST['nndfbook']) ? $_POST['nndfbook'] : '' ) );
 /*update_usermeta($user_id, 'something', ( isset($_POST['something']) ? $_POST['something'] : '' ) );*/
 }
}
/* Initialise ourselves */
add_action('plugins_loaded', create_function('','global $nnd_user_meta_instance; $nnd_user_meta_instance = new nnd_user_meta();'));

if ( !function_exists( 'add_NND_donate_link' ) ) :
 function add_NND_donate_link($links, $file) {
static $this_plugin;
if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

if ($file == $this_plugin){
$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZZJD8LKR2UAE8" target="_blank">Donate</a>';
 array_push($links, $donate_link);
}
return $links;
 }
endif;
 add_filter('plugin_row_meta', 'add_NND_donate_link', 10, 2 );
?>