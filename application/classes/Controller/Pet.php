<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Pet extends Controller_Frontend {

	public function action_index()
	{
		$pets = $this->user->pets->order_by('active', 'desc')->find_all();
		if ($_POST)
		{
			$post = $this->request->post();
			if ($post['action'] == 'active')
			{
				try
				{
					foreach ($pets as $pet)
					{
						if ($pet->id == $post['pet_id'])
						{
							$pet->user->active = 1;
							Hint::success($pet->name.' is now your active pet.');
						}
						else
						{
							$pet->user->active = 0;
						}
						$pet->user->save();
					}
					$this->redirect('pet');
				}
				catch (ORM_Validation_Exception $e)
				{
					Hint::error($e->errors('models'));
				}
			}
			if ($post['action'] == 'abandon')
			{
				try
				{
					foreach ($pets as $pet)
					{
						if ($pet->id == $post['pet_id'])
						{
							if ($pet->user->active == 1)
							{
								$pet->user->active = 0;
								$active_pets = $this->user->pets->order_by('id', 'desc')->find_all();
								$new_active_pet = 0;
								foreach ($active_pets as $active_pet)
								{
									if ($active_pet->id != $pet->id AND $new_active_pet == 0)
									{
										$new_active_pet = 1;
										$active_pet->user->active = 1;
										$active_pet->user->save();
									}
								}
							}
							$pet->user->user_id = 0;
							$pet->user->save();
							Hint::success('You have abandoned '.$pet->name);
						}
					}
					$this->redirect('pet');
				}
				catch (ORM_Validation_Exception $e)
				{
					Hint::error($e->errors('models'));
				}
			}
		}
		$this->view = new View_Pet_Index;
		$this->view->pets = $pets;
	}
	
	public function action_adopt()
	{
		$pets = ORM::factory('User_Pet')
			->where('user_id', '=', 0)
			->find_all();
		if ($_POST)
		{
			$post = $this->request->post();
			try
			{
				foreach($pets as $pet)
				{
					if($pet->pet_id == $post['pet_id'])
					{
						foreach($this->user->pets->order_by('active', 'desc')->find_all() as $user_pet)
						{
							$user_pet->user->active = 0;
							$user_pet->user->save();
						}
						$pet->user_id = $this->user->id;
						$pet->active = 1;
						$pet->save();
						$adopted_pet = ORM::factory('Pet', $pet->pet_id);
						Hint::success('You have adopted '.$adopted_pet->name);
					}
				}
				$this->redirect('pet');
			}
			catch (ORM_Validation_Exception $e)
			{
				Hint::error($e->errors('models'));
			}
		}
		$this->view = new View_Pet_Adopt;
		$this->view->pets = $pets;
	}

	public function action_create()
	{
		if ($_POST)
		{
			try
			{
				$array = Arr::merge($this->request->post(), array(
				));

				$new_pet = ORM::Factory('Pet')
					->create_pet($array, array(
						'race_id',
						'colour_id',
						'gender',
						'name',
					));
				ORM::Factory('User_Pet')->values(array('user_id' => $this->user->id, 'pet_id' => $new_pet->id))->create();
				Hint::success('You have created a pet named '.$new_pet->name);
				$pets = $this->user->pets->find_all();
				foreach ($pets as $pet)
				{
					if ($pet->id != $new_pet->id)
					{
						$pet->user->active = 0;
						$pet->user->save();
					}
				}
				$this->redirect('pet');
			}
			catch (ORM_Validation_Exception $e)
			{
				Hint::error($e->errors('models'));
			}
		}
		$races = ORM::factory('Pet_Race')->find_all();
		$this->view = new View_Pet_Create;
		
		$colours = ORM::factory('Pet_Colour')->find_all();
		$this->view->colours = $colours;

		$this->view->races = $races;
		
	}
	
} // End Pet
