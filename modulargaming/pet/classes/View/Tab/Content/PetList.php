<?php defined('SYSPATH') OR die('No direct script access.');

class View_Tab_Content_PetList extends Abstract_View_Tab_Content {

	/**
	 * @var Array Pets
	 */
	public $pets;

	public function pets()
	{
		$pets = array();
		foreach ($this->pets as $pet)
		{
			$pets[] = array(
				'src' => URL::base().'assets/img/pets/'.$pet->specie->id.'/'.$pet->colour->image,
				'href' => Route::url('pet', array('name' => strtolower($pet->name))),
				'name' => $pet->name,
				'specie' => $pet->specie->name,
				'colour' => $pet->colour->name,
			);
		}
		return $pets;
	}

}