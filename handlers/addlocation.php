<?php

$this->require_acl ('admin', 'organizations', 'admin/add');

$org = new organizations\Organization ($_GET['id']);

$page->layout = 'admin';
$page->title = $org->name . ' - ' . __ ('Add Location');

$form = new Form ('post', $this);

$form->data = array (
	'id' => $_GET['id']
);

echo $form->handle (function ($form) {
	// Create and save a new organization 
	$loc = new organizations\Location (array (
		'organization' => $_GET['id'],
		'name' => $_POST['name'], 
		'phone' => $_POST['phone'], 
		'address' => $_POST['address'], 
		'address2' => $_POST['address2'], 
		'city' => $_POST['city'], 
		'state' => $_POST['state'], 
		'country' => $_POST['country'], 
		'zip' => $_POST['zip']
	));
	$loc->put ();

	if ($loc->error) {
		// Failed to save
		error_log ('Error adding location: ' . $loc->error);
		$form->controller->add_notification (__ ('Unable to save location.'));
		return false;
	}

	// Notify the user and redirect on success
	$form->controller->add_notification (__ ('Location added.'));
	$form->controller->redirect ('/organizations/details?id=' . $_GET['id']);
});

?>