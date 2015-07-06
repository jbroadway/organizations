<?php

$this->require_acl ('admin', 'organizations');

$page->layout = 'admin';
$page->title = __ ('Organizations');

// Calculate the offset
$limit = 20;
$num = isset ($this->params[0]) ? $this->params[0] : 1;
$offset = ($num - 1) * $limit;

$q = isset ($_GET['q']) ? $_GET['q'] : ''; // search query
$q_fields = array ('o.name', 'o.phone', 'o.address', 'o.city', 'o.about', 'l.name', 'l.phone', 'l.address', 'l.city');
$q_exact = array ();
$url = '/organizations/admin/%d?q=' . urlencode ($q);

// Fetch the items and total items
$items = organizations\Organization::query ('distinct o.*')
	->from ('#prefix#organizations o left join #prefix#organizations_location l on l.organization = o.id')
	->where_search ($q, $q_fields, $q_exact)
	->order ('o.name', 'asc')
	->fetch_orig ($limit, $offset);

$total = organizations\Organization::query ('distinct o.*')
	->from ('#prefix#organizations o left join #prefix#organizations_location l on l.organization = o.id')
	->where_search ($q, $q_fields, $q_exact)
	->count ();

// Check for error, e.g., if table hasn't been created yet
if ($items === false) {
	$items = array ();
	$total = 0;
	printf (
		'<p class="visible-notice"><strong>%s</strong>: %s</p>',
		__ ('Notice'),
		__ ('It looks like you need to import your database schema for this app.')
	);
}

// Pass our data to the view template
echo $tpl->render (
	'organizations/admin',
	array (
		'limit' => $limit,
		'total' => $total,
		'items' => $items,
		'count' => count ($items),
		'q' => $q,
		'url' => $url
	)
);

?>