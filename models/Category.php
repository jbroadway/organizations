<?php

namespace organizations;

/**
 * Fields:
 *
 * - id
 * - name
 *
 * Usage:
 *
 *     // fetch all as associative array
 *     $categories = organizations\Category::query ()
 *         ->order ('name', 'asc')
 *         ->fetch_assoc ('id', 'name');
 *
 *     // get all organizations by category
 *     $category = new organizations\Category ($category_id);
 *     $organizations = $category->organizations ();
 */
class Category extends \Model {
	public $table = '#prefix#organizations_category';
	
	public $fields = array (
		'organizations' => array (
			'has_many' => 'organizations\Organization',
			'field_name' => 'category',
			'order_by' => array ('name', 'asc')
		)
	);

	public static $categories = null;

	public static function filter_name ($id) {
		if (self::$categories === null) {
			self::$categories = self::query ()
				->order ('name', 'asc')
				->fetch_assoc ('id', 'name');
		}
		
		return isset (self::$categories[$id]) ? self::$categories[$id] : false;
	}
}
