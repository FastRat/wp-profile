<div class="wrap">
    <h2>Profile Extends - Settings</h2>
    <h3>Current picture</h3>
    <?php
        $id = get_current_user_id();
        global $wpdb;
        $prefix = $wpdb->prefix;
        
        $url = $wpdb->get_var('SELECT picture FROM ' . $prefix.'user_extends' . ' WHERE userid = ' . $id );
                
        if ( empty($url)){
            $data = json_decode(file_get_contents(__DIR__ . '/data.txt'), true);
            
            if ( isset( $data[$id]) ) {
                echo "<img src\"{$data[$id]}\" />"; 
            } else {
                echo get_avatar(get_the_author_meta('user_mail') );
            }
           
        }  else {      
    ?>
    <img src="<?php echo $url; ?>" />
        <?php } ?>
    <h3>Change picture</h3>
    <form action="<?php echo '?page='.$_REQUEST['page'].'&action=save_profile'; ?>" method="post" enctype="multipart/form-data">
    <table>
        <tr valign="top">
            <td scope="row">Profile Image</td>
            <td><input type="file" name="file" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
    </form>
</div>
