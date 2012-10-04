<?php
/*
Plugin Name: ZenShow
Plugin URI: http://www.ruicruz.com/zenshow/
Description: Displays a thumbnail from ZenPhoto. Updated for ZenPhoto 1.1.2 by Thinkdreams, as well as bug fixes by Samuel Goldstein.
Version: 1.4.1
Author: Rui Cruz
Author URI: http://www.ruicruz.com
*/


/**
 * Wordpress plugin to handle insertion of Zenphoto Photos into wordpress blocks
 * 
 * @author Rui Cruz, http://www.ruicruz.com
 * @copyright Rui Cruz
 * @version 1.4.1
 */
class RMCZS {


	/**
	 * ZenPhoto Database name (to support diferent a database from WordPress
	 *
	 * @var string
	 */
    var $zen_db;
    
    /**
     * Database username
     *
     * @var string
     */
    var $zen_user;
	
    /**
     * Database Password
     *
     * @var string
     */
    var $zen_pw;
    
    /**
     * ZenPhoto Host
     *
     * @var string
     */
    var $host;

    /**
     * Database Tables prefix (if any)
     *
     * @var string
     */
    var $zen_prefix = '';
    
    /**
     * Height of the ZenPhoto thumbnail
     *
     * @var int
     */    
    var $zen_tb_height = 85;
    
    /**
     * Width of the ZenPhoto thumbnail
     *
     * @var int
     */
    var $zen_tb_width = 85;
    
    
    /**
     * ZenPhoto URL
     *
     * @var string
     */
    var $zen_url;

    
//////////////////////////////////////////
//
//		OBJECT METHODS
//
//////////////////////////////////////////

	/**
	 * Constructor, adds the admin page and retrieves the configuration options
	 *
	 * @return RMCZS
	 */
	function RMCZS() {

		add_action('admin_menu', array(&$this,'ShowAdmin'));         
		
		$this->get_zenconf();
		
	}
	
		
//////////////////////////////////////////
//
//		METHODS TO DISPLAY THE PICTURES
//
//////////////////////////////////////////

	/**
	 * Shows last photo (selected by bigger ID)
	 *
	 * @param string $date
	 */
	function showPhoto($date = null) {
				
		global $ZenDB, $RMCZS;

		if ( $RMCZS->connect() ) {
			
			if ( !is_null($date) && (ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $date)) ) {
				
				$SQL_date = ' AND album.date < ' . $date;
				
			} else {
				
				$SQL_date = null;
				
			}

		    $SQL_query = 'SELECT images.filename AS filename, images.`desc` AS file_desc, album.folder AS folder, images.title AS title FROM ' . $RMCZS->zen_prefix . 'images AS images INNER JOIN ' . $RMCZS->zen_prefix . 'albums AS album ON album.id = images.albumid WHERE images.show = 1 ' . $SQL_date . ' ORDER BY images.id DESC LIMIT 1';
	
			if ($Photo = $ZenDB->get_row($SQL_query)) 
			
				echo '<a href="' . $RMCZS->zen_url .'index.php?album='. $Photo->folder . '&amp;image=' . $Photo->filename . '" id="rpc_photo" title="' . $Photo->file_desc . '" />'
				. '<img height="' . $RMCZS->zen_tb_height . '" width="' . $RMCZS->zen_tb_width . '" src="' . $RMCZS->zen_url . 'zp-core/i.php?a='. $Photo->folder . '&i=' . $Photo->filename . '&s=thumb" alt="' . $Photo->title . '">'
				. '</a>';
					
			$RMCZS->disconnect();	
	    
	    } else {
	    	
	    	trigger_error('Unable to display Photo');
	    	
	    }
	}

	
	/**
	 * Shows X Random photos
	 *
	 * @param int $num_photos
	 * @param string $date
	 */
	function randomPhotos($num_photos = 4, $date = null) {
				
		global $ZenDB, $RMCZS;

		if ( $RMCZS->connect() ) {
			
			if ( !is_null($date) && (ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $date)) ) {
				
				$SQL_date = ' AND album.date < ' . $date;
				
			} else {
				
				$SQL_date = null;
				
			}			

		    $SQL_query = 'SELECT images.filename AS filename, images.`desc` AS file_desc, album.folder AS folder, images.title AS title FROM ' . $RMCZS->zen_prefix . 'images AS images INNER JOIN ' . $RMCZS->zen_prefix . 'albums AS album ON album.id = images.albumid WHERE images.show = 1 ' . $SQL_date . ' ORDER BY RAND() LIMIT ' . $num_photos;
	
			if ($Photos = $ZenDB->get_results($SQL_query)) 
			
				foreach ($Photos as $Photo) {
				
					echo '<a href="' . $RMCZS->zen_url .'index.php?album='.
					$Photo->folder . '&amp;image=' . $Photo->filename .
					'" title="' . $Photo->title . '" class="rpc_photo">'
					. '<img class="random" src="' . $RMCZS->zen_url .
					'zp-core/i.php?a='. $Photo->folder . '&i=' .
					$Photo->filename . '&s='.$RMCZS->zen_tb_width.'&cw='.
					$RMCZS->zen_tb_width.'&ch='.$RMCZS->zen_tb_height.
					'" alt="' . $Photo->title . '" />'
					. '</a>';
				
				}			
					
			$RMCZS->disconnect();	
	    
	    } else {
	    	
	    	trigger_error('Unable to display');
	    	
	    }
	}

	
	/**
	 * Shows X Random photos
	 *
	 * @param int $num_album
	 * @param int $num_photos
	 */
	function showAlbum($num_album, $num_photos = 4) {
				
		global $ZenDB, $RMCZS;

		if ( $RMCZS->connect() ) {		

		    $SQL_query = 'SELECT images.filename AS filename, images.`desc` AS file_desc, album.folder AS folder, images.title AS title, album.title AS ab_title, album.place AS ab_place, album.date AS ab_date FROM ' . $RMCZS->zen_prefix . 'images AS images INNER JOIN ' . $RMCZS->zen_prefix . 'albums AS album ON album.id = images.albumid WHERE images.show = 1 AND album.id = ' . $num_album . ' ORDER BY RAND() LIMIT ' . $num_photos;
	
			if ($Photos = $ZenDB->get_results($SQL_query)) {
				
				echo '<div class="rmc_album">';			
			
				foreach ($Photos as $Photo) {
				
					echo '<a href="' . $RMCZS->zen_url .'index.php?album='. $Photo->folder . '&amp;image=' . $Photo->filename . '" title="' . $Photo->title . '" class="rpc_photo">'
					. '<img height="' . $RMCZS->zen_tb_height . '" width="' . $RMCZS->zen_tb_width . '" src="' . $RMCZS->zen_url . 'zp-core/i.php?a='. $Photo->folder . '&i=' . $Photo->filename . '&s=thumb" alt="' . $Photo->title . '" />'
					. '</a>';
				
				}
				
				echo '<div class="title"><a href="' . $RMCZS->zen_url . 'index.php?album=' . $Photo->folder . '">' . $Photo->ab_title . '</a></div>'
				. '<div class="place">' . $Photo->ab_place . '</div>'
				. '<div class="date">' . $Photo->ab_date . '</div>';
				
				echo '</div>';
				
			}
					
			$RMCZS->disconnect();	
	    
	    } else {
	    	
	    	trigger_error('Unable to display');
	    	
	    }
	}
	
	
//////////////////////////////////////////
//
//		ADMINISTRATION METHODS
//
//////////////////////////////////////////


	function AdminOptions() {	
		
		if (isset($_POST['info_update'])) {
		
            update_option("RMCZS_db", $_POST['txt_zendb']);
			update_option("RMCZS_username", $_POST['txt_zenusername']);
			update_option("RMCZS_password", $_POST['txt_zenpassword']);
			update_option("RMCZS_host", $_POST['txt_zenhost']);
			
			update_option('RMCZS_tb_width', $_POST['txt_zen_tb_width']);
			update_option('RMCZS_tb_height', $_POST['txt_zen_tb_height']);
			
			
            update_option("RMCZS_prefix", $_POST['txt_zenprefix']);
            update_option("RMCZS_url", $_POST['txt_zenurl']);
            
			echo '<div class="updated"><p><strong>';
			_e('ZenShow options Updated.', 'Localization name');
			echo '</strong></p></div>';

		}
		
		$this->get_zenconf();

		?>
		<div class="wrap">
		  <form method="post">
			<h2>Zen Show</h2>
            
				<div align="right"><?php $this->get_ZenUrl(); ?></div>
				
			 	<fieldset name="database" title="Database configuration" class="options">
			 
			 		<legend>ZenPhoto Database Options</legend>
				
	               
					<table width="100%" border="0" align="center">
	                  <tr>
	                    <th width="200" align="right"><?php _e('Database', 'Localization name') ?></th>
	                    <td><input name="txt_zendb" type="text" value="<?php echo $this->zen_db; ?>" size="40" /></td>
	                  </tr>
	                  <tr>
	                    <th width="200" align="right"><?php _e('Username', 'Localization name') ?></th>
	                    <td><input name="txt_zenusername" type="text" value="<?php echo $this->zen_user; ?>" size="40" /></td>
	                  </tr>
	                  <tr>
	                    <th width="200" align="right"><?php _e('Password', 'Localization name') ?></th>
	                    <td><input name="txt_zenpassword" type="password" value="<?php echo $this->zen_pw; ?>" size="40" /></td>
	                  </tr>
	                  <tr>
	                    <th width="200" align="right"><?php _e('Host', 'Localization name') ?></th>
	                    <td><input name="txt_zenhost" type="text" value="<?php echo $this->zen_host; ?>" size="40" /></td>
	                  </tr>
	                  <tr>
	                    <th align="right"><?php _e('Tables Prefix', 'Localization name') ?></th>
	                    <td><input name="txt_zenprefix" type="text" value="<?php echo $this->zen_prefix; ?>" size="40" />
	                    Usually &quot;zp_&quot; </td>
	                  </tr>
	                </table>
	                
					
				</fieldset>
			 	<br />
			 
	 			<fieldset name="thumbnail" title="Thumbnail configuration" class="options">
				 
				 	<legend>ZenPhoto Thumbnail Options</legend>					
	               
					<table width="100%" border="0" align="center">
	                  <tr>
	                    <th width="200" align="right"><?php _e('Height', 'Localization name') ?></th>
	                    <td><input name="txt_zen_tb_height" type="text" value="<?php echo $this->zen_tb_height; ?>" size="4" maxlenght="4" /></td>
	                    <td rowspan="2">Check ZenPhoto config.php and insert the values accordingly </td>
	                  </tr>
	                  <tr>
	                    <th width="200" align="right"><?php _e('Width', 'Localization name') ?></th>
	                    <td><input name="txt_zen_tb_width" type="text" value="<?php echo $this->zen_tb_width; ?>" size="4" maxlength="4" /></td>
                      </tr>
	                </table>
	                
					
				</fieldset>
			 	<br />

			 		 
			 <fieldset name="folder" title="Database configuration" class="options">
			   
			   <legend>Url Options</legend>
				<table width="100%" border="0" align="center">
                  <tr>
                    <th width="200" align="right"><?php _e('Zen Photo URL', 'Localization name') ?></th>
                    <td><input name="txt_zenurl" type="text" value="<?php echo $this->zen_url; ?>" size="40" />
                    <strong>Always</strong> use ending trailing slash ex: zenphoto/</td>
                  </tr>
                </table>
				<br />
			 </fieldset>
			
			<div class="submit">
		  		<input type="submit" name="info_update" value="<?php _e('Update options', 'Localization name'); ?>" />
			</div>
		  </form>
          <p>There's (actually no longer) more information about configuring this plugin on <a href="http://www.ruicruz.com/zenshow/" target="_blank">http://www.ruicruz.com/zenshow/</a><br />
            <a href="http://zenphoto.org/changelog.html" target="_blank">ZenPhoto.org changelog</a><br />Hacked to SeL standards by SjG</p>
		</div>
		 <?php
	
	}


	/**
	 * Adds the option page to WordPress administration, 
	 * only users with level 9 can use
	 * 
	 * @return void
	 */
	function ShowAdmin() {
    	
		if (function_exists('add_options_page')) {
			
			add_options_page('RMCZENSHOW', 'RMC:Zen Show', 9, __FILE__, array(&$this,'AdminOptions'));
			
    	}
    	
 	}

	
//////////////////////////////////////////
//
//		MISC
//
//////////////////////////////////////////	
	

	
	/**
	 * Gets the configuration from Wordpress database
	 *
	 * @return void
	 */
	function get_zenconf() {
	
	    $tmp = get_option('RMCZS_db');
		$this->zen_db = ($tmp !== false?$tmp:'zenphoto_database');
		$tmp = get_option('RMCZS_username');
		$this->zen_user = ($tmp !== false?$tmp:'zenphoto_user');
		$tmp = get_option('RMCZS_password');
		$this->zen_pw = ($tmp !== false?$tmp:'zenphoto_password');;
		$tmp = get_option('RMCZS_prefix');
		$this->zen_prefix = ($tmp !== false?$tmp:'zp_');
		$tmp =get_option('RMCZS_host');
		$this->zen_host = ($tmp !== false?$tmp:'localhost');
		$tmp =get_option('RMCZS_url');
		$this->zen_url = ($tmp !== false?$tmp:'/zenphoto/');
		$tmp =get_option('RMCZS_tb_width');
		$this->zen_tb_width = ($tmp !== false?$tmp:'100');
		$tmp =get_option('RMCZS_tb_height');
		$this->zen_tb_height = ($tmp !== false?$tmp:'100');

	}

	/**
	 * Shows the link to ZenPhoto Administration
	 *
	 */
	function get_ZenUrl() {
		
		if (!empty($this->zen_url))

			echo '<a href="'.$this->zen_url.'zp-core/admin.php" target="_blank">ZenPhoto Admin</a>';
			
	}
	
	
	/**
	 * Connects to ZenPhoto database
	 *
	 * @return bool
	 */
	function connect() {

		global $ZenDB;
		
		$this->get_zenconf();
		
					
		//	OUTPUT
		// header('Content-Type: text/html; charset=ISO-8859-1');
		
		
        if (empty($this->zen_db)) {
            
            echo 'You don\'t have <a href="http://www.zenphoto.org" taget="_blank">ZenPhoto</a> configured/installed.';
            
            return false;
            
        } else {
        	
        	$ZenDB = new wpdb($this->zen_user, $this->zen_pw, $this->zen_db, $this->zen_host);
        	
        	return true;
        		
        }
        	
 		
	}
	
	/**
	 * Kills of some variables
	 *
	 * @return void
	 */
	function disconnect() {
		
		$ZenDB = NULL;
		
	}
	




}



$RMCZS = new RMCZS();


?>