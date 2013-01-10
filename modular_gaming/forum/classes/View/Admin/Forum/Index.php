<?php defined('SYSPATH') OR die('No direct script access.');

class View_Admin_Forum_Index extends View_Admin_Base {

	public $title = 'Categories';

	public function categories()
	{
		$categories = array();

		foreach ($this->categories as $category)
		{
			$categories[] = array(
				'id'         => $category->id,
				'title'   => $category->title,
				'description'      => $category->description,
				'locked' => $category->locked,
				'created'    => Date::format($category->created),
			);
		}

		return $categories;
	}

}
