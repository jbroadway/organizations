<?php

/**
 * List of organization categories.
 */

$page->layout = 'admin';

$this->require_acl ('admin', 'organizations');

$categories = organizations\Category::query ()->order ('name', 'asc')->fetch_orig ();

$page->title = __ ('Organization Categories');

echo $tpl->render (
	'organizations/categories',
	array (
		'categories' => $categories
	)
);
