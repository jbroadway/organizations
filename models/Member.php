<?php

namespace organizations;

/**
 * List members.
 *
 * Fields:
 * - id
 * - organization
 * - user
 */
class Member extends \Model {
	public $table = '#prefix#organizations_member';
	public $key = 'id';
	
	public static function delete_org ($id) {
		return \DB::execute ('delete from #prefix#organizations_member where organization = ?', $id);
	}
}

?>