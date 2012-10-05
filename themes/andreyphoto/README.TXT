### README.TXT ###
#
## AndreyPhoto theme for ZenPhoto
#
# Table of Contents:
# -----------------------------------
# 1. Terms of use
# 2. Theme description
# 3. INSTALLATION
# 4. Quirks, tips and tricks
# 5. Support
# 6. Contact information
# -----------------------------------

# 1. Terms of use
	This theme is available for free to everyone. You can use, modify and distribute
	this theme freely as long as the credit lines at the footer of each page remain
	unchanged. All the images are copyrighted by andreyphoto.com, and may only be used
	in the context of this theme. If you have and questions, see contact info below.

# 2. Theme description
	This theme has a few very neat aesthetic features:
		Index:
		 * First three album thumbnails are very large - a nice "Tada" effect
		 * Large random image thumbnail right below - something new every refresh
		 * Four next thumbnails are also quite big
		 * The rest of the albums are displayed in a neat list below
		 * Lovely sky background with a little cloud :)
		
		Album:
		 * Header fades to grey - focus is drawn towards the images instead
		 * Large thumbnails neatly organized
		 
		Image:
		 * Background goes to dark colors - the image is the focus
		 * Breadcrumb trail of where you are
		 
	The rest of the theme is pretty standard, wonderful ZenPhoto!
	
# 3. INSTALLATION
	1. Unzip into your themes folder
	2. Edit your zen/zp-config.php file, and make sure you have the following setup:
		
		$conf['thumb_size']        = 164;
		$conf['thumb_crop']        = true;
		$conf['thumb_crop_width']  = 164;
		$conf['thumb_crop_height'] = 164;
		
		$conf['albums_per_page'] = 50; // or as many galleries you are planning to have
		$conf['images_per_page'] = 16; // must be multiple of 4
		
		// optional
		$conf['image_size'] = 600;
		$conf['image_use_longest_side'] = false;
		$conf['image_allow_upscale'] = false;
		
		$conf['image_quality'] = 100;
		$conf['thumb_quality'] = 100;
	
	3. Go to ZenPhoto admin, options and choose AndreyPhoto as your theme
	
# 4. Quirks, tips and tricks.
	* This theme lists all of the albums on one page, there's no page navigation - 
	  if you do want page navigation, uncomment the line at the bottom of index.php:
	
		  <?php //printPageListWithNav("&laquo; prev", "next &raquo;"); ?>
		
	  This theme is not really made to support this, so do this at your own risk.
	
	* Since the thumbnails are no uniform size, the ideal number of albums are:
		3		you will only have the top three big thumbnails
		7		... and the bottom four
		9+ odd	... and the ones below that, which look good two at a time
	
	* If you get no image in your random image box, check for blank entries in the
	  `zp_images` table in your database. Erase these, ZenPhoto will regenerate new
	  ones if it's necessary. This happens if an operation was not completed.
	  
	* Errors? Random Images not displaying at all? See if your database tables have the
	  "zp_" prefix. If they don't, change the table names in the getRandomImage() function
	  in index.php to suit yours.
	  
	* Need emotional support? Send an email to support@microsoft.com.. j/k :)
	
# 5. Support
	It's really my pleasure to offer this theme to you for free, as I very much enjoy
	and appreciate the open-source community. We all spend long hours developing these, 
	and	surely appreciate a good word sent our way or a donation if you are in a position
	to make one. So please, if can afford to, support the arts:
		
		http://www.andreyphoto.com/support.php
	
	
# 6. Contact Information
	Email: 		andrey@andreyphoto.com
	Website:	http://www.andreyphoto.com
	Theme:		http://www.andreyphoto.com/zenphoto_theme.php
	
That's it! Enjoy!
                                                                - Andrey Samodeenko
