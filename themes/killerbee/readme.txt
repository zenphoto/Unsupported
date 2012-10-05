**********************************
*                                *
*    Killer Bee Theme v1.0       *
*    ---------------------       *
*    aut: Jason Hsu              *
*    eml: jhsu@imagebaker.com    *
*    web: imagebaker.com         *
     dat: 11.08.05               *
*                                *
**********************************

SETUP:
Uncompress the files with their folder structure into your /themes directory.
In your admin page for Zenphoto select the theme 'Killer Bee'.
In your config.php file, set:

	$conf['image_size'] = 460;

	$conf['image_use_longest_side'] = false;

	$conf['thumb_crop_width']  = 85;
	$conf['thumb_crop_height'] = 85;
	$conf['thumb_size']        = 85;

Replace the link for the homepage to your own own page:

	index.php line 16

	album.php line 16

	image.php line 16



CHANGES:
I changed the whole structure of the div id's and classes. 
The general grouping for the css structure is as follows.

Added a disabled link for 'prev' and 'next' in the image.php file.



CSS STRUCTURE:
01 GLOBAL
02 INDEX.PHP & ALBUM.PHP
03 INDEX.PHP
04 ALBUM.PHP
05 IMAGE.PHP

Each files' respective selectors can be found in the .css file between the comment tags deliniating each section.



ISSUES:
In IE 6.0 cannot get the #main id to align flush with the top.
In IE 6.0 cannot get #imageDescEditable to accept different ID.
In Mozilla 1.04 cannot get the ajax fields to function.
Cannot get a positive validation for XHTML1.0 Strict.


Please email me if you have any comments or suggestions. 
(jhsu@imagebaker.com)
