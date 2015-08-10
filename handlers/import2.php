<?php

/**
 * Finishes importing a CSV file.
 */

$this->require_acl ('admin', 'user');

$page->layout = 'admin';
$page->title = __ ('CSV Importer');

$imported = 0;

$file = 'cache/organizations_csv_import.csv';

if (! file_exists ($file)) {
	echo '<p>' . __ ('Uploaded CSV file not found.') . '</p>';
	echo '<p><a href="/organizations/import">' . __ ('Back') . '</a></p>';
	return;
}

set_time_limit (0);
ini_set ('auto_detect_line_endings', true);

$res = array ();
if (($f = fopen ($file, 'r')) !== false) {
	while (($row = fgetcsv ($f, 0, ',')) !== false) {
		if (count ($row) === 1 && $row[0] === null) {
			// ignore blank lines, which come through as array(null)
			continue;
		}
		$res[] = $row;
	}
	fclose ($f);
} else {
	echo '<p>' . __ ('Unable to parse the uploaded file.') . '</p>';
	echo '<p><a href="/organizations/import">' . __ ('Back') . '</a></p>';
	return;
}

// Map fields
$name = false;
$website = false;
$about = false;
$phone = false;
$fax = false;
$address = false;
$address2 = false;
$city = false;
$state = false;
$country = false;
$zip = false;

foreach ($_POST as $k => $v) {
	if (strpos ($k, 'map-') === 0 && $v !== '') {
		$n = (int) str_replace ('map-', '', $k);
		${$v} = $n;
	}
}

// Remove first line
array_shift ($res);

foreach ($res as $k => $row) {
	$org = array (
		'name' => ($name !== false) ? $row[$name]: '',
		'website' => ($website !== false) ? $row[$website] : '',
		'about' => ($about !== false) ? $row[$about] : '',
		'phone' => ($phone !== false) ? $row[$phone] : '',
		'fax' => ($fax !== false) ? $row[$fax] : '',
		'address' => ($address !== false) ? $row[$address] : '',
		'address2' => ($address2 !== false) ? $row[$address2] : '',
		'city' => ($city !== false) ? $row[$city] : '',
		'state' => ($state !== false) ? $row[$state] : '',
		'country' => ($country !== false) ? $row[$country] : '',
		'zip' => ($zip !== false) ? $row[$zip] : ''
	);

	$o = new organizations\Organization ($org);

	if ($o->put ()) {
		Versions::add ($o);
		$imported++;
	}
}

echo '<p>' . __ ('Imported %d organizations.', $imported) . '</p>';
echo '<p><a href="/organizations/admin">' . __ ('Continue') . '</a></p>';
