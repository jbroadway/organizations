<?php

$page->layout = 'admin';

$this->require_acl ('admin', 'admin/delete', 'organizations');

$c = new organizations\Category ($_POST['id']);

if (! $c->remove ()) {
	$this->add_notification (__ ('Error deleting category.'));
	$this->redirect ('/organizations/categories');
}

$this->add_notification (__ ('Category deleted.'));
$this->redirect ('/organizations/categories');
