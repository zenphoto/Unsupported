<?php
/** 
 * GoogleCheckout -- Google ordering support [experimental]
 * 
 * Provides a Google Checkout ordering form for image print ordering.
 * 
 * Plugin option 'GoogleCheckout_merchantID' allows setting the GoogleCheckout user email.
 * Plugin option 'GoogleCheckout_pricelist' provides the default pricelist. 
 * Plugin option 'googleCheckout_currency'
 * Plugin option 'googleCheckout_ship_method'
 * Plugin option 'googleCheckout_ship_cost'
 * Plugin option 'googleCheckout_cart_location'
 *  
 * Price lists can also be passed as a parameter to the GoogleCheckout() function. See also 
 * GoogleCheckoutPricelistFromString() for parsing a string into the pricelist array. This could be used, 
 * for instance, by storing a pricelist string in the 'customdata' field of your images and then parsing and 
 * passing it in the GoogleCheckout() call. This would give you individual pricing by image.
 *  
 * @author Jeremy Coleman (mammlouk), Stephen Billard (sbillard)
 * @version 1.0.1
 * @package plugins 
 */

$plugin_description = gettext("GoogleCheckout Integration for Zenphoto.");
$plugin_author = 'Jeremy Coleman (mammlouk), Stephen Billard (sbillard)';
$plugin_version = '1.0.1';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---GoogleCheckout.php.html";
$option_interface = new GoogleCheckoutOptions();
addPluginScript('<link rel="stylesheet" href="'.FULLWEBPATH."/".ZENFOLDER.PLUGIN_FOLDER.'GoogleCheckout/GoogleCheckout.css" type="text/css" />');

$id = getOption('GoogleCheckout_merchantID');
$curr = getOption('googleCheckout_currency');
$cartloc = getOption('googleCheckout_cart_location');
if (empty($curr)) { $curr = 'USD'; }
addPluginScript('<script id="googlecart-script" type="text/javascript" src="http://checkout.google.com/seller/gsc/beta/cart-v1.js?mid='.$id.'&currency='.$curr.'"></script>');
addPluginScript('<link rel="stylesheet" href="'.FULLWEBPATH."/".ZENFOLDER.PLUGIN_FOLDER.'GoogleCheckout/GoogleCart'.$cartloc.'.css" type="text/css" />');

/**
 * Plugin option handling class
 *
 */
class GoogleCheckoutOptions {

	function GoogleCheckoutOptions() {

		$pricelist = array("4x6:".gettext("Matte") => '5.75', "4x6:".gettext("Glossy") => '10.00', "4x6:".gettext("Paper") => '8.45', 
								"8x10:".gettext("Matte") => '15.00', "8x10:".gettext("Glossy") => '20.00', "8x10:".gettext("Paper") => '8.60', 
								"11x14:".gettext("Matte") => '25.65', "11x14:".gettext("Glossy") => '26.75', "11x14:".gettext("Paper") => '15.35', );
		setOptionDefault('GoogleCheckout_merchantID', "");
		$pricelistoption = '';
		foreach ($pricelist as $item => $price) {
			$pricelistoption .= $item.'='.$price.' ';
		}
		setOptionDefault('GoogleCheckout_pricelist', $pricelistoption);
		setOptionDefault('googleCheckout_currency', 'USD');
		setOptionDefault('googleCheckout_ship_method', 'UPS');
		setOptionDefault('googleCheckout_ship_cost', 0);
		setOptionDefault('googleCheckout_cart_location', 'T');
	}
	
	
	function getOptionsSupported() {
		return array(	gettext('Google Merchant ID') => array('key' => 'GoogleCheckout_merchantID', 'type' => 0, 
										'desc' => gettext("Your Google Merchant ID.")),
									gettext('Currency') => array('key' => 'googleCheckout_currency', 'type' => 0, 
										'desc' => gettext("The currency for your transactions.")),
									gettext('Shipping method') => array('key' => 'googleCheckout_ship_method', 'type' => 0, 
										'desc' => gettext("How to ship.")),
									gettext('Shipping cost') => array('key' => 'googleCheckout_ship_cost', 'type' => 0, 
										'desc' => gettext("What you charge for shipping.")),
									gettext('Price list') => array('key' => 'GoogleCheckout_pricelist', 'type' => 3, 'multilingual' => 1,
										'desc' => gettext("Your pricelist by size and media. The format of this option is <em>price elements</em> separated by spaces.<br/>".
																			"A <em>price element</em> has the form: <em>size</em>:<em>media</em>=<em>price</em><br/>".
																			"example: <code>4x6:Matte=5.75 8x10:Glossy=20.00 11x14:Paper=15.35</code>.")),
									gettext('Cart Location') => array('key' => 'googleCheckout_cart_location', 'type' => 5, 
										'selections' => array(gettext("top left")=>'TopLeft', gettext("top right")=>'Default'),
										'desc' => gettext("The placement of the Google Cart on your pages."))
		);
	}
	function handleOption($option, $currentValue) {
	}
}

/**
 * Parses a price list element string and returns a pricelist array
 *
 * @param string $prices A text string of price list elements in the form <size>:<media>=<price> <size>:<media>=<price> ...
 * @return array
 */
function GoogleCheckoutPricelistFromString($prices) {
	$pricelist = array();
	$pricelistelements = explode(' ', $prices);
		foreach ($pricelistelements as $element) {
			if (!empty($element)) {
				$elementparts = explode('=', $element);
				$pricelist[$elementparts[0]] = $elementparts[1];
			}
		}
	return $pricelist;
}

/**
* Places Google Cart Widget inline on your page instead of attached to the browser
*
*/
function printGoogleCartWidget() {
	echo '<div id="googlecart-widget"></div><br />';
}

/**
* Sets Google Checkout to Post to the Google Checkout Sandbox for configuraiton testing
*
*/
function googleCheckoutTesting() {
	addPluginScript('<script type="text/javascript" src="'.FULLWEBPATH."/".ZENFOLDER.PLUGIN_FOLDER.'GoogleCheckout/GoogleCartPostToSandBox.js"></script>');
}

/**
 * Places Google Checkout Options on your page.
 * 
 * @param array $pricelist optional array of specific pricing for the image.
 */
function googleCheckout($pricelist=NULL) {
	if (!is_array($pricelist)) {
		$pricelist = GoogleCheckoutPricelistFromString(getOption('GoogleCheckout_pricelist'));
	}

?>

<div id="GoogleCheckout" class="product">
   <input type="hidden" class="product-image" value="<?php echo getImageThumb(); ?>" />
   <input type="hidden" class="product-title" value="Album: <?php echo getAlbumTitle();?> Photo: <?php echo getImageTitle(); ?>" />
   <input type="hidden" class="product-shipping" value="<?php echo getOption('googleCheckout_ship_cost'); ?>" />
   Size/Finish: <select class="product-attr-sizefinish">
	<option googlecart-set-product-price=""></option>
	<?php 
	foreach ($pricelist as $key=>$price) {
	?>
	<option googlecart-set-product-price="<?php echo $price; ?>"><?php echo $key; ?></option>
   <?php
	}
	?>
   </select><br />
   Price: <span class="product-price">Choose Size/Finish</span><br />
   How Many: <input type="text" class="googlecart-quantity" value="1" style="width:20px;" />&nbsp;&nbsp;
   <span class="googlecart-add-button"></span>
</div>
<?php 
}

?>
