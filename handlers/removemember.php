<?php

$this->require_acl ('admin', 'organizations', 'admin/delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$this->redirect ('/organizations/admin');
}

$m = new organizations\Member ($_POST['id']);
$user = $m->user;
$m->remove ($_POST['id']);

if ($m->error) {
	error_log ('Error deleting member: ' . DB::error ());
	$this->add_notification (__ ('Unable to remove member.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));
}

$this->hook ('organizations/removemember', array (
	'org' => $_POST['org'],
	'user' => $user
));

$this->add_notification (__ ('Member removed.'));
$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));

?>