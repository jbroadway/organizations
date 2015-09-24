<?php

$this->require_acl ('admin', 'organizations', 'admin/edit');

$page->layout = 'admin';
$page->title = __ ('Edit Organization');

$form = new Form ('post', $this);

$organization = new organizations\Organization ($_GET['id']);

$form->data = $organization->orig ();
$form->data->categories = organizations\Category::query ()
	->order ('name', 'asc')
	->fetch_assoc ('id', 'name');

echo $form->handle (function ($form) use ($organization) {
	// Update the organization
	$organization->name = $_POST['name'];
	$organization->phone = $_POST['phone'];
	$organization->fax = $_POST['fax'];
	$organization->address = $_POST['address'];
	$organization->address2 = $_POST['address2'];
	$organization->city = $_POST['city'];
	$organization->state = $_POST['state'];
	$organization->country = $_POST['country'];
	$organization->zip = $_POST['zip'];
	$organization->website = $_POST['website'];
	$organization->about = $_POST['about'];
	$organization->public = $_POST['public'];
	$organization->category = $_POST['category'];
	$organization->put ();

	if ($organization->error) {
		// Failed to save
		error_log ('Error updating organization: ' . DB::error ());
		$form->controller->add_notification (__ ('Unable to save organization.'));
		return false;
	}

	// Save a version of the organization 
	Versions::add ($organization);
	
	$form->controller->hook ('organizations/edit', array ('id' => $organization->id));

	// Notify the user and redirect on success
	$form->controller->add_notification (__ ('Organization saved.'));
	$form->controller->redirect ('/organizations/admin');
});

?>