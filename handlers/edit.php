<?php

$this->require_acl ('admin', 'organizations', 'admin/edit');

$page->layout = 'admin';
$page->title = __ ('Edit Organization');

$form = new Form ('post', $this);

$form->data = new organizations\Organization ($_GET['id']);

echo $form->handle (function ($form) {
	// Update the organization 
	$organization = $form->data;
	$organization->name = $_POST['name'];
	$organization->phone = $_POST['phone'];
	$organization->address = $_POST['address'];
	$organization->address2 = $_POST['address2'];
	$organization->city = $_POST['city'];
	$organization->state = $_POST['state'];
	$organization->country = $_POST['country'];
	$organization->zip = $_POST['zip'];
	$organization->website = $_POST['website'];
	$organization->about = $_POST['about'];
	$organization->put ();

	if ($organization->error) {
		// Failed to save
		error_log ('Error updating organization: ' . DB::error ());
		$form->controller->add_notification (__ ('Unable to save organization.'));
		return false;
	}

	// Save a version of the organization 
	Versions::add ($organization);

	// Notify the user and redirect on success
	$form->controller->add_notification (__ ('Organization saved.'));
	$form->controller->redirect ('/organizations/admin');
});

?>