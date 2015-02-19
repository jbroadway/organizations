<?php

$this->require_acl ('admin', 'organizations', 'admin/delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$this->redirect ('/organizations/admin');
}

$m = new organizations\Location;
$m->remove ($_POST['id']);

if ($m->error) {
	error_log ('Error deleting location: ' . DB::error ());
	$this->add_notification (__ ('Unable to remove location.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));
}

$this->add_notification (__ ('Location removed.'));
$this->redirect ('/organizations/details?id=' . Template::sanitize ($_POST['org']));

?>