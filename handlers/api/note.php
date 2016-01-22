<?php

$this->require_acl ('admin', 'organizations');

$this->restful (new organizations\API\Note);
