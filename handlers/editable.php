<?php

$page->layout = false;

$this->require_acl ('admin', 'organizations', 'admin/edit');

$notice = false;

switch ($_POST['property']) {
	case 'name':
	case 'about':
		$org = new organizations\Organization ($_POST['id']);
		if ($org->error) {
			$notice = __ ('List not found.');
			break;
		}
		
		$org->{$_POST['property']} = $_POST['value'];
		if (! $org->put ()) {
			error_log ('Error updating organization ' . $_POST['property'] . ': ' . $org->error);
			$notice = __ ('An unknown error occurred.');
			break;
		}
		
		$notice = __ ('Changes saved.');
		break;
}

if ($notice) {
	$this->add_notification ($notice);
}

echo Template::sanitize ($_POST['value']);

?>