<?php
/*
Plugin Name: List Finder Tag
Plugin URI: 
Description: Add List Finder Tag
Version: 1.0.2
Author:Innovation Inc.
Author URI: https://www.innovation.co.jp
License: GPL2
*/
/*  Copyright 2016 Innovation Inc. (email : tech@innovation.co.jp)
 
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

add_action( 'admin_menu', 'lftag_add_plugin_admin_menu' );
add_action( 'wp_head', 'lftag_inserttag' );

function lftag_inserttag() {
  $id = get_site_option('lftag_id');
  if (empty($id)) { return; }
?>

<script type="text/javascript">
var _trackingid = '<?php echo $id; ?>';

(function() {
  var lft = document.createElement('script'); lft.type = 'text/javascript'; lft.async = true;
  lft.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//track.list-finder.jp/js/ja/track.js';
  var snode = document.getElementsByTagName('script')[0]; snode.parentNode.insertBefore(lft, snode);
})();
</script>


<?php
}
function lftag_add_plugin_admin_menu() {
    add_options_page('List Finder Tag Setting', // page_title
    'List Finder Tag', // menu_title
    'administrator', // capability
    'list-finder-tag', // menu_slug（options-general.php?page=list-finder-tag）
    'lftag_display_plugin_admin_page' // function
    );
    register_setting('list-finder-tag-group', // option_group
    'lftag_id', // option_name
    'lftag_id_validation'
    // sanitize_callback
    );
}
function lftag_id_validation($input) {
    if (strlen($input) < 13) {
        return $input;
    } else {
        add_settings_error('lftag_id', // option_name
        'lftag_id_validation', // sanitize_callback
        __('illegal data', 'list-finder-tag'), 'error');
    }
}
function lftag_display_plugin_admin_page() {
    $id = get_site_option('lftag_id');
?>

<div class="wrap">
 
<h2>List Finder Tag Plugin Setting</h2>
 
<form method="post" action="options.php">
 
<?php
    settings_fields('list-finder-tag-group');
    do_settings_sections('default');
?>
 
<table class="form-table">
     <tbody>
     <tr>
          <th scope="row"><label for="lftag_id">List Finder ID<br/>
( ex. LFT-10000-1 )</label></th>
          <td>
               <input type="text" id="lftag_id" name="lftag_id" size="30" value="<?php echo $id; ?>"/>
          </td>
     </tr>
     </tbody>
</table>
 
<?php submit_button();
     ?>
 
</form>
 
</div>
 
<?php
}

