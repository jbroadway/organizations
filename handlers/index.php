<?php

if (! $this->internal) {
	$page->title = __ ('Organizations');
}

$organizations = organizations\Organization::query ('o.name, o.website, c.id as category_id, c.name as category_name')
	->from ('#prefix#organizations o, #prefix#organizations_category c')
	->where ('o.category = c.id')
	->where ('o.public', 'yes')
	->order ('c.name', 'asc')
	->order ('o.name', 'asc')
	->fetch_orig ();

$categories = array ();
foreach ($organizations as $org) {
	if (! isset ($categories[$org->category_id])) {
		$categories[$org->category_id] = array (
			'name' => $org->category_name,
			'orgs' => array ()
		);
	}
	
	$categories[$org->category_id]['orgs'][] = $org;
}

echo $tpl->render (
	'organizations/index',
	array (
		'categories' => $categories
	)
);
