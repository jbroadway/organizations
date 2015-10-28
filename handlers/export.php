<?php

/**
 * Export users as CSV.
 */

$this->require_acl ('admin', 'organizations');

$page->layout = false;
header ('Cache-control: private');
header ('Content-Type: text/plain');
header ('Content-Disposition: attachment; filename=organizations-' . gmdate ('Y-m-d') . '.csv');

$res = DB::fetch (
	'select
		o.name as organization_name,
		o.phone as primary_phone,
		o.address as primary_address,
		o.address2 as primary_address2,
		o.city as primary_city,
		o.state as primary_state,
		o.country as primary_country,
		o.zip as primary_zip,
		o.website as primary_website,
		o.public as is_public,
		c.name as category,
		o.about as primary_about,
		l.name as location_name,
		l.phone as location_phone,
		l.address as location_address,
		l.address2 as location_address2,
		l.city as location_city,
		l.state as location_state,
		l.country as location_country,
		l.zip as location_zip
	 from
	 	#prefix#organizations o
	 	left join #prefix#organizations_location l on l.organization = o.id
	 	left join #prefix#organizations_category c on o.category = c.id
	 order by
	 	organization_name asc,
	 	location_name asc'
);

if (! is_array ($res)) {
	return;
}

if (count ($res) > 0) {
	$keys = array_keys ((array) $res[0]);
	$keys = array_map ('user\Filter::csv_header', $keys);
	echo join (',', $keys) . "\n";
}

foreach ($res as $row) {
	$sep = '';
	foreach ((array) $row as $k => $v) {
		$v = str_replace ('"', '""', $v);
		if (strpos ($v, ',') !== false) {
			$v = '"' . $v . '"';
		}
		$v = str_replace (array ("\n", "\r"), array ('\\n', '\\r'), $v);
		echo $sep . $v;
		$sep = ',';
	}
	echo "\n";
}
