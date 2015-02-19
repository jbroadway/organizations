<?php

namespace organizations;

class Organization extends \Model {
	public $table = '#prefix#organizations';
	public $key = 'id';
	
	public static function by_user ($user) {
		return self::query ('o.id, o.name')
			->from ('#prefix#organizations o, #prefix#organizations_member m')
			->where ('m.organization = o.id')
			->where ('m.user', $user)
			->order ('o.name', 'asc')
			->fetch_orig ();
	}
}

?>