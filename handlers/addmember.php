<?php

$this->require_acl ('admin', 'organizations', 'admin/edit');

if (! isset ($_POST['org'])) {
	$this->add_notification (__ ('Missing organization.'));
	$this->redirect ('/organizations/admin');
}

$organization = new organizations\Organization ($_POST['org']);
if ($organization->error) {
	$this->add_notification (__ ('Organization not found.'));
	$this->redirect ('/organization/admin');
}

if (! isset ($_POST['user'])) {
	$this->add_notification (__ ('Missing member.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));
}

$u = new User ($_POST['user']);
if ($u->error) {
	$this->add_notification (__ ('Member not found.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));
}

$m = new organizations\Member (array (
	'organization' => $_POST['org'],
	'user' => $_POST['user']
));
if (! $m->put ()) {
	$this->add_notification (__ ('Member already exists.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));
}

$this->add_notification (__ ('Member added.'));
$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));

?>