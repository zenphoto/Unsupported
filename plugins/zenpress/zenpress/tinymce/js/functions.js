/**
 * Copyright 2006/2007  Alessandro Morandi  (email : webmaster@simbul.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 * Class declaration
 */
function ZenpressPopup() {
};
 
 /**
  * Insert an image in the text editor
  * @param imageId	Id of the image (not used yet)
  * @param imageUrl	Filename of the image
  * @param imageName	Name (title) of the image
  */
ZenpressPopup.prototype.insertImage = function(imageId,imageUrl,imageName) {
	form = this.getEl('options');
	whatValue = this.getRadioValue(form.what);
	linkValue = this.getRadioValue(form.link);
	closeValue = this.getRadioValue(form.close);
	wrapValue = this.getRadioValue(form.wrap);
	sizeValue = this.getRadioValue(form.size);
	modRewrite = form.mod_rewrite.value;
	webPath = form.zp_web_path.value;
	albumUrl = form.album_url.value;
	albumName = form.album_name.value;
	customWidth = form.custom_width.value;
	customHeight = form.custom_height.value;
	
	imageHTML = "";
	
	if (linkValue!="none") {
		imageHTML += '<a href="';
		if (linkValue=="album") {
			if (modRewrite) {
				path = webPath+"/"+albumUrl;
			} else {
				path = webPath+"/index.php?album="+albumUrl;
			}
			imageHTML += path;
		} else if (linkValue=="custom" && form.link_custom_url.value!="") {
			imageHTML += form.link_custom_url.value;
		} else {	// "image" is the default
			if (modRewrite) {
				path = webPath+"/"+albumUrl+"/"+imageUrl
			} else {
				path = webPath+"/index.php?album="+albumUrl+"&amp;image="+imageUrl
			}
			imageHTML += path;
		}
		imageHTML += '">';
	}
	if (whatValue=="title") {
		imageHTML += imageName;
	} else if (whatValue=="custom" && form.what_custom_text.value!="") {
		imageHTML += form.what_custom_text.value;
	} else if (whatValue=="album") {
		imageHTML += albumName;
	} else {	// "thumb" is the default
		if (modRewrite && sizeValue!="custom") {
			// ZenPhoto's mod_rewrite does not support custom size!
			path = webPath+"/"+albumUrl+"/image/";
			if (sizeValue!="full") {
				path += "thumb/"
			}
			path += imageUrl
		} else {
			path = webPath+"/zen/i.php?a="+albumUrl+"&amp;i="+imageUrl;
			if (sizeValue!="full" && sizeValue!="custom") {
				path += "&amp;s=thumb";
			} else if (sizeValue=="custom") {
				path += "&amp;w="+customWidth+"&amp;h="+customHeight;
			}
		}
		imageStyle = '';
		imageClass = 'ZenPress_thumb ';
		
		if (wrapValue!="none") {
			imageStyle += 'float:'+wrapValue+'; ';
			imageClass += 'ZenPress_'+wrapValue+' ';
		}
		styleAttr = '';
		if (imageStyle!='') {
			styleAttr = 'style="'+imageStyle+'"';
		}
		imageHTML += '<img class="'+imageClass+'" alt="'+imageName+'" title="'+imageName+'" src="'+path+'" '+styleAttr+' />';
	}
	if (linkValue!="none") {
		imageHTML += '</a>';
	}

	if(window.tinyMCE) {
		window.opener.tinyMCE.execCommand("mceInsertContent",true,imageHTML);
	} else {
		this.insertAtCursor(window.opener.document.forms["post"].elements["content"],imageHTML);
	}
	
	if (closeValue!="false") {
		window.close();
	}
}

/**
 * Expand/Collapse a menu
 * @param obj	The toggle button for the menu
 */
ZenpressPopup.prototype.toggleMenu = function(obj) {
	name = obj.id.substr(7);
	div = zenpressPopup.getEl('fields_'+name);
	hidden = zenpressPopup.getEl(obj.id+'_status');
	
	if (obj.innerHTML=="[+]") {
		//div.style.display='block';
		div.className='zpOpen';
		hidden.value = 'open';
		obj.innerHTML="[-]";
	} else {
		//div.style.display='none';
		div.className='zpClosed';
		hidden.value = 'closed';
		obj.innerHTML="[+]";			
	}
}

/**
 * Show a menu or its alternate version
 * @param id	Id of the menu to show
 * @param visible	Which version to show (normal|alt)
 */
ZenpressPopup.prototype.setVisibility = function(id,visible) {
	elem = this.getEl(id);
	if (visible=="normal") {
		elem.className = elem.className.replace(/[ ]*alt/i," normal");
	} else if (visible=="alt") {
		elem.className = elem.className.replace(/[ ]*normal/i," alt");
	}
}

/**
 * Get value of a group of radio buttons
 * @param radio	Radio buttons
 */
ZenpressPopup.prototype.getRadioValue = function(radio) {
	for (i=0; i<radio.length; i++) {
		if (radio[i].checked) {
			return radio[i].value;
		}
	}
	return undefined;
}

ZenpressPopup.prototype.changeHandler = function(e) {
	form = zenpressPopup.getEl('options');
	what = zenpressPopup.getRadioValue(form.what);
	link = zenpressPopup.getRadioValue(form.link);
	if ((what=="album" && link!="image") || (what=="custom" && link!="image")) {
		zenpressPopup.setVisibility("fields_image","alt");
	} else {
		zenpressPopup.setVisibility("fields_image","normal");
	}
}

ZenpressPopup.prototype.gotoPage = function(page) {
	form = zenpressPopup.getEl('options');
	form.page.value = page;
	form.submit();
}

/**
 * Insert the image where the cursor is (if tinyMCE is disabled)
 * Taken verbatim from g2image plugin
 * @param myField	Where to insert the image
 * @param myValue	What to insert
 */
ZenpressPopup.prototype.insertAtCursor = function(myField, myValue) {
	//IE support
	if (document.selection && !window.opera) {
		myField.focus();
		sel = window.opener.document.selection.createRange();
		sel.text = myValue;
	}
	//MOZILLA/NETSCAPE/OPERA support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		myField.value = myField.value.substring(0, startPos)
		+ myValue
		+ myField.value.substring(endPos, myField.value.length);
	} else {
		myField.value += myValue;
	}
}

/**
 *	Get the specified object. Based on http://www.quirksmode.org/js/dhtmloptions.html
 *	Compatible with Mozilla, Explorer 5+, Opera 5+, Konqueror, Safari, iCab, Ice, OmniWeb 4.5,
 *	Explorer 4+, Opera 6+, iCab, Ice, Omniweb 4.2-
 *	@param	id	Id of the object to get
 *	@return The specified object, or null if not found
 */
ZenpressPopup.prototype.getEl = function(id) {
	if (document.getElementById) {
		return document.getElementById(id);
	} else if (document.all) {
		return document.all[id];
	}
	return null;
}

/**
 * Adds a new function to the onload page event
 * @param fx	The function to add
 */
ZenpressPopup.prototype.addLoadEvent = function(fx) {
	var onloadChain = window.onload;
	if (typeof window.onload != 'function') {
		// *** No other functions detected, just add.
		window.onload = fx;
	} else {
		// *** Other functions present, chain fx.
		window.onload = function() {
			onloadChain();
			fx();
		};
	}
}

// Instance the class
var zenpressPopup = new ZenpressPopup();
