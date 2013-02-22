<?php

class Item_Command_Move extends Item_Command {

	public $default = TRUE;
	public $delete_after_consume = FALSE;

	protected function _build($name)
	{
		return null;
	}

	public function validate($param)
	{
		return null;
	}

	public function perform($item, $amount, $data=null)
	{
		return null;
	}

	public function inventory()
	{
		return array('field' => array(
			'name' => 'amount',
			'type' => 'number',
			'classes' => 'input-mini',
			'button' => 'Move'
		));
	}
}
