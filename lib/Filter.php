<?php

namespace organizations;

class Filter {
	public static function url ($website) {
		return preg_match ('/^https?:\/\//i', $website)
			? $website
			: 'http://' . $website;
	}

	public static function domain ($website) {
		$domain = parse_url ($website, PHP_URL_HOST);
		return ($domain === false || $domain === null)
			? $website
			: $domain;
	}
}
