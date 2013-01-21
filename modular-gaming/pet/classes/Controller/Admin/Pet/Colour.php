<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Pet_Colour extends Abstract_Controller_Admin {
	
	public function action_index()
	{

		if ( ! $this->user->can('Admin_Pet_Colour_Index') )
		{
			throw HTTP_Exception::factory('403', 'Permission denied to view admin pet colour index');
		}

		$colours = ORM::factory('Pet_Colour')
			->find_all();

		$this->view = new View_Admin_Pet_Colour_Index;
		$this->_nav('pet', 'colour');
		$this->view->colours = $colours->as_array();
	}

}