<?php

$this->require_acl ('admin', 'organizations', 'admin/edit');

if (! isset ($_GET['org'])) {
	$this->add_notification (__ ('Missing organization.'));
	$this->redirect ('/organizations/admin');
}

$organization = new organizations\Organization ($_GET['org']);
if ($organization->error) {
	$this->add_notification (__ ('Organization not found.'));
	$this->redirect ('/organization/admin');
}

if (! isset ($_GET['id'])) {
	$this->add_notification (__ ('Missing member.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_GET['org']));
}

$m = new organizations\Member ($_GET['id']);
if ($m->error) {
	$this->add_notification (__ ('Member not found.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_GET['org']));
}

$u = new User ($m->user);

$form = new Form ('post', $this);

$form->data = array (
	'org' => $organization->orig (),
	'member' => $m->orig (),
	'user' => $u->orig (),
	'orgs' => organizations\Organization::query ('id, name')
		->where ('id != ?', $_GET['org'])
		->order ('name', 'asc')
		->fetch_assoc ('id', 'name')
);

$page->layout = 'admin';
$page->title = __ ('Move User: %s', $u->name);

echo $form->handle (function ($form) use ($tpl, $page, $m, $u) {
	$moved = new organizations\Organization ($_POST['move']);
	if ($moved->error) {
		$form->controller->add_notification (__ ('Organization not found.'));
		return false;
	}

	$m->organization = $_POST['move'];
	if (! $m->put ()) {
		$form->controller->add_notification (__ ('User is already in the new organization.'));
		return false;
	}
	
	$this->hook ('organizations/removemember', array (
		'org' => $_GET['org'],
		'user' => $u->id
	));
	$this->hook ('organizations/addmember', array (
		'org' => $_POST['move'],
		'user' => $u->id
	));
	
	$data = (array) $form->data;
	$data['moved'] = $moved->orig ();
	$page->title = __ ('User Moved: %s', $u->name);
	echo $tpl->render ('organizations/moved', $data);
});
