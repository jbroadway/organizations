<?php

namespace organizations;

/**
 * List members.
 *
 * Fields:
 * - id
 * - organization
 * - name
 * - phone
 * - address
 * - address2
 * - city
 * - state
 * - country
 * - zip
 */
class Location extends \Model {
	public $table = '#prefix#organizations_location';
	public $key = 'id';
	
	public static function delete_org ($id) {
		return \DB::execute ('delete from #prefix#organizations_location where organization = ?', $id);
	}
}

?>