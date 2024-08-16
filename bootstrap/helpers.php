<?php

function utf8ize($d) {
	if (is_array($d))
		foreach ($d as $k => $v)
			$d[$k] = utf8ize($v);
	else if (is_object($d))
		foreach ($d as $k => $v)
			$d->$k = utf8ize($v);
	else
		return utf8_encode($d);

	return $d;
}

/**
 * to_slug
 *
 * Converts name of a bar or something to a URL safe string
 *
 * @example to_slug( $venue->name )
 *
 */
function to_slug($string) {
	return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
}


/**
 * hash_password
 *
 * Converts a string to a properly hashed password for comparisons
 * and storage.
 *
 * @example hash_password("whatever")
 *
 */
function hash_password($string) {
	return sha1('cs114-' . $string);
}

/**
 * purge
 *
 * Sends a PURGE request to the Varnish server to force a refresh.
 * We attach a root to it, so we should send something like:
 *
 * @example purge("v1/users/1")
 *
 */
function purge($url) {
	$url = str_replace('//', '/', $url);
	$url = \Request::root() . '/' . $url;
	$url = str_replace('http://', 'https://', $url);

	ob_start();

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PURGE");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_VERBOSE, 0);
	curl_exec($curl);

	\Log::info("[helpers] Purging a URL: $url");

	ob_end_flush();
}

/**
 * @param int $length
 * @return string
 */
if (!function_exists('str_random')) {
	function str_random(int $length = 16) {
		return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / 62))), 1, $length);
	}
}


function convertSentenceToAddress($str) {
	$states = json_decode('{"AL": "Alabama","AK": "Alaska","AS": "American Samoa","AZ": "Arizona","AR": "Arkansas","CA": "California","CO": "Colorado","CT": "Connecticut","DE": "Delaware","DC": "District Of Columbia","FM": "Federated States Of Micronesia","FL": "Florida","GA": "Georgia","GU": "Guam","HI": "Hawaii","ID": "Idaho","IL": "Illinois","IN": "Indiana","IA": "Iowa","KS": "Kansas","KY": "Kentucky","LA": "Louisiana","ME": "Maine","MH": "Marshall Islands","MD": "Maryland","MA": "Massachusetts","MI": "Michigan","MN": "Minnesota","MS": "Mississippi","MO": "Missouri","MT": "Montana","NE": "Nebraska","NV": "Nevada","NH": "New Hampshire","NJ": "New Jersey","NM": "New Mexico","NY": "New York","NC": "North Carolina","ND": "North Dakota","MP": "Northern Mariana Islands","OH": "Ohio","OK": "Oklahoma","OR": "Oregon","PW": "Palau","PA": "Pennsylvania","PR": "Puerto Rico","RI": "Rhode Island","SC": "South Carolina","SD": "South Dakota","TN": "Tennessee","TX": "Texas","UT": "Utah","VT": "Vermont","VI": "Virgin Islands","VA": "Virginia","WA": "Washington","WV": "West Virginia","WI": "Wisconsin","WY": "Wyoming"}');

	$ret = new \stdClass;
	$confidence = 0;
	$statePosition = 0;
	$stateLength = 0;
	$zipPosition = 0;

	$str = preg_replace("/( in )/im", " ", $str);
	$str = preg_replace("/( as )/im", " ", $str);
	$str = preg_replace("/( hi(\!\.)? )/im", " ", $str);

	$hasZip = preg_match("/[0-9]{5}/im", $str, $zipMatches, PREG_OFFSET_CAPTURE);
	$hasState = preg_match("/,? [a-zA-Z]{2}( |\?|\.|$)/im", $str);
	$lookingFor = preg_match("/(looking for)/im", $str);
	$poolHall = preg_match("/(pool) (hall|table)s?/im", $str);
	$near = preg_match("/(near)/im", $str);

	// check for real state
	foreach ($states as $abbr => $state) {
		if (preg_match("/,? ({$abbr})( |\?|\.|$)/im", $str, $stateMatches, PREG_OFFSET_CAPTURE)) {
			$confidence += 0.2;

			if (count($stateMatches)) {
				$statePosition = $stateMatches[1][1];
				$stateLength = strlen($stateMatches[1][0]);
			}
		}

		if (strpos($str, $state) > 0) {
			$confidence += 0.3;
			$statePosition = strpos($str, $state);
			$stateLength = strlen($state);
		}
	}

	$hasZip && ($confidence += 0.3);
	$hasState && ($confidence += 0.2);
	$lookingFor && ($confidence += 0.15);
	$poolHall && ($confidence += 0.25);
	$near && ($confidence += 0.05);

	if (count($zipMatches)) {
		$zipPosition = $zipMatches[0][1];
	}

	$ret->confidence = $confidence;
	$ret->statePosition = $statePosition;
	$ret->stateLength = $stateLength;
	$ret->zipPosition = $zipPosition;

	// try to get some reasonable bounds around our state
	$end = $ret->zipPosition ?: ($ret->statePosition + $ret->stateLength);
	$start = $ret->statePosition ?: $ret->zipPosition;
	$start = max(0, $start - 15);

	$ret->start = $start;
	$ret->end = $end;
	$ret->address = substr($str, $start, $end - $start);

	return $ret;
}
