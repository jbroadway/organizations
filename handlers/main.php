<?php

$this->require_acl ('admin', 'organizations', 'admin/edit');

if (! isset ($_GET['org'])) {
	$this->add_notification (__ ('Missing organization.'));
	$this->redirect ('/organizations/admin');
}

$organization = new organizations\Organization ($_GET['org']);
if ($organization->error) {
	$this->add_notification (__ ('Organization not found.'));
	$this->redirect ('/organization/admin');
}

if (! isset ($_GET['id'])) {
	$this->add_notification (__ ('Missing member.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_GET['org']));
}

$m = new organizations\Member ($_GET['id']);
if ($m->error) {
	$this->add_notification (__ ('Member not found.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_GET['org']));
}

DB::beginTransaction ();

if (! DB::execute ('update #prefix#organizations_member set main = 0 where organization = ?', $_GET['org'])) {
	DB::rollback ();
	$this->add_notification (__ ('Unable to change contact. Please try again later.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_GET['org']));
}

if (! DB::execute ('update #prefix#organizations_member set main = 1 where organization = ? and id = ?', $_GET['org'], $_GET['id'])) {
	DB::rollback ();
	$this->add_notification (__ ('Unable to change contact. Please try again later.'));
	$this->redirect ('/organizations/details?id=' . Template::sanitize ($_GET['org']));
}

DB::commit ();
$this->add_notification (__ ('Main contact updated.'));
$this->redirect ('/organizations/details?id=' . Template::sanitize ($_GET['org']));
