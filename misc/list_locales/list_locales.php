<?php
function list_system_locales(){
	ob_start();
	system('locale -a');
	$str = ob_get_contents();
	ob_end_clean();

	return explode("\n", $str);
}
/**
 * This function will parse a given HTTP Accepted language instruction
 * (or retrieve it from $_SERVER if not provided) and will return a sorted
 * array. For example, it will parse fr;en-us;q=0.8
 *
 * Thanks to Fredbird.org for this code.
 *
 * @param string $str optional language string
 * @return array
 */
function parseHttpAcceptLanguage($str=NULL) {
	if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		return array();
	}
	// getting http instruction if not provided
	$str=$str?$str:$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	// exploding accepted languages
	$langs=explode(',',$str);
	// creating output list
	$accepted=array();
	foreach ($langs as $lang) {
		// parsing language preference instructions
		// 2_digit_code[-longer_code][;q=coefficient]
				if (preg_match('/([A-Za-z]{1,2})(-([A-Za-z0-9]+))?(;q=([0-9\.]+))?/', $lang, $found)) {
			// 2 digit lang code
			$code = $found[1];
			// lang code complement
			$morecode = array_key_exists(3, $found) ? $found[3] : false;
			// full lang code
			$fullcode = $morecode ? $code . '_' . $morecode : $code;
			// coefficient (preference value, will be used in sorting the list)
			$coef = sprintf('%3.1f', array_key_exists(5, $found) ? $found[5] : '1');
			// for sorting by coefficient
			$accepted[$coef . '-' . $code] = array('code' => $code, 'coef' => $coef, 'morecode' => $morecode, 'fullcode' => $fullcode);
		}
	}
	// sorting the list by coefficient desc
	krsort($accepted);
	return $accepted;
}

$locales = list_system_locales();
$httpaccept = parseHttpAcceptLanguage();
if (count($httpaccept) > 0) {
	$accept = $httpaccept;
	$accept = array_shift($accept);
	?>
<strong>Http Accept Languages:</strong>
<br />
<table>
	<tr>
	<th width = 100 align="left">Key</th>
	<?php
	foreach ($accept as $key=>$value){
		?>
		<th width = 100 align="left"><?php echo $key; ?></th>
		<?php
	}
	?>
	</tr>
	<?php
	foreach ($httpaccept as $key=>$accept) {
		?>
	<tr>
		<td width=100 align="left"><?php echo $key; ?></td>
		<?php

		foreach ($accept as $value) {
			?>
		<td width=100 align="left"><?php echo $value; ?></td>
		<?php
		}
		?>
	</tr>
	<?php
	}
	?>
</table>

	<?php
}
?>
<br />
<strong>Supported locales:</strong>

<?php
$last = '';
foreach ($locales as $locale) {
	if ($last != substr($locale, 0,3)) {
		echo "<br />";
		$last = substr($locale, 0, 3);
	}
	echo $locale.' ';
}
?>
