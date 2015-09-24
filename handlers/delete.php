<?php

$this->require_acl ('admin', 'organizations', 'admin/delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$this->redirect ('/organizations/admin');
}

$organization = new organizations\Organization;
$organization->remove ($_POST['id']);

if ($organization->error) {
	error_log ('Error deleting organization: ' . DB::error ());
	$this->add_notification (__ ('Unable to delete organization.'));
	$this->redirect ('/organizations/admin');
}

organizations\Location::delete_org ($_POST['id']);
organizations\Member::delete_org ($_POST['id']);

$this->hook ('organizations/delete', $_POST);

$this->add_notification (__ ('Organization deleted.'));
$this->redirect ('/organizations/admin');

?>