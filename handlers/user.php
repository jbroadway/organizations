<?php

$this->require_acl ('admin', 'user', 'organizations');

if (! $this->internal) return;

$orgs = organizations\Organization::by_user ($this->data['user']);

echo $tpl->render ('organizations/user', array (
	'orgs' => $orgs
));
