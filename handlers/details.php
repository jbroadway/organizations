<?php

$this->require_acl ('admin', 'organizations');

if (User::require_acl ('admin/edit')) {
	$this->run ('admin/util/editable', array ('url' => '/organizations/editable'));
}

$organization = new organizations\Organization ($_GET['id']);

$page->layout = 'admin';
$page->title = sprintf (
	'<div class="editable-text" data-property="name" id="%s">%s</div>',
	Template::sanitize ($_GET['id']),
	Template::sanitize ($organization->name)
);
$page->window_title = $organization->name;

$organization = $organization->orig ();

$organization->members = organizations\Member::query ('m.id, u.id as user_id, u.name, u.title')
	->from ('#prefix#organizations_member m, #prefix#user u')
	->where ('m.user = u.id')
	->where ('m.organization', $_GET['id'])
	->order ('u.name', 'asc')
	->fetch_orig ();
$organization->chosen = array ();
foreach ($organization->members as $member) {
	$organization->chosen[] = $member->user_id;
}

$organization->locations = organizations\Location::query ()
	->where ('organization', $_GET['id'])
	->order ('name', 'asc')
	->fetch_orig ();

echo $tpl->render ('organizations/details', $organization);

?>