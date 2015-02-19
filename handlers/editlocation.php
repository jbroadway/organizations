<?php

$this->require_acl ('admin', 'organizations', 'admin/edit');

$page->layout = 'admin';
$page->title = __ ('Edit Location');

$form = new Form ('post', $this);

$form->data = new organizations\Location ($_GET['id']);

echo $form->handle (function ($form) {
	// Update the organization 
	$loc = $form->data;
	$loc->name = $_POST['name'];
	$loc->phone = $_POST['phone'];
	$loc->address = $_POST['address'];
	$loc->address2 = $_POST['address2'];
	$loc->city = $_POST['city'];
	$loc->state = $_POST['state'];
	$loc->country = $_POST['country'];
	$loc->zip = $_POST['zip'];
	$loc->put ();

	if ($loc->error) {
		// Failed to save
		error_log ('Error updating location: ' . $loc->error);
		$form->controller->add_notification (__ ('Unable to save location.'));
		return false;
	}

	// Notify the user and redirect on success
	$form->controller->add_notification (__ ('Location saved.'));
	$form->controller->redirect ('/organizations/details?id=' . $loc->organization);
});

?>