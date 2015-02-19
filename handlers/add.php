<?php

$this->require_acl ('admin', 'organizations', 'admin/add');

$page->layout = 'admin';
$page->title = __ ('Add Organization');

$form = new Form ('post', $this);

echo $form->handle (function ($form) {
	// Create and save a new organization 
	$organization = new organizations\Organization (array (
		'name' => $_POST['name'], 
		'phone' => $_POST['phone'], 
		'address' => $_POST['address'], 
		'address2' => $_POST['address2'], 
		'city' => $_POST['city'], 
		'state' => $_POST['state'], 
		'country' => $_POST['country'], 
		'zip' => $_POST['zip'], 
		'website' => $_POST['website'], 
		'about' => $_POST['about'] 
	));
	$organization->put ();

	if ($organization->error) {
		// Failed to save
		error_log ('Error adding organization: ' . DB::error ());
		$form->controller->add_notification (__ ('Unable to save organization.'));
		return false;
	}

	// Save a version of the organization 
	Versions::add ($organization);

	// Notify the user and redirect on success
	$form->controller->add_notification (__ ('Organization added.'));
	$form->controller->redirect ('/organizations/admin');
});

?>