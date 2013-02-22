<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Item type admin controller
 *
 * Manage site item types
 *
 * @package    ModularGaming/Items
 * @category   Admin
 * @author     Maxim Kerstens
 * @copyright  (c) Modular gaming
 */
class Controller_Admin_Item_Types extends Abstract_Controller_Admin {

	public function action_index()
	{
		if ( ! $this->user->can('Admin_Item_Index') )
		{
			throw HTTP_Exception::factory('403', 'Permission denied to view admin item index');
		}

		$this->_load_assets(Kohana::$config->load('assets.data_tables'));
		$this->_load_assets(Kohana::$config->load('assets.admin_item.type'));

		$this->view = new View_Admin_Item_Type;
		$this->_nav('items', 'types');
	}

	public function action_paginate()
	{
		if (DataTables::is_request())
		{
			$orm = ORM::factory('Item_Type');

			$paginate = Paginate::factory($orm)
			->columns(array('id', 'name'));

			$datatables = DataTables::factory($paginate)->execute();

			foreach ($datatables->result() as $avatar)
			{
				$datatables->add_row(array (
						$avatar->name,
						$avatar->id
				)
				);
			}

			$datatables->render($this->response);
		}
		else
			throw new HTTP_Exception_500();
	}

	public function action_retrieve()
	{
		$this->view = null;

		$item_id = $this->request->query('id');

		$item = ORM::factory('Item_Type', $item_id);

		$list = array (
			'id' => $item->id,
			'name' => $item->name,
			'action' => $item->action,
			'default_command' => $item->default_command,
			'img_dir' => $item->img_dir,
		);

		$this->response->headers('Content-Type','application/json');
		$this->response->body(json_encode($list));
	}

	public function action_save()
	{
		$this->view = null;
		$values = $this->request->post();

		if($values['id'] == 0)
			$values['id'] = null;

		$id = $values['id'];

		$this->response->headers('Content-Type','application/json');

		try {
			$item = ORM::factory('Item_Type', $values['id']);
			$item->values($values, array('name', 'status', 'action', 'default_command', 'img_dir'));
			$item->save();

			$data = array (
				'action' => 'saved',
				'type' => ($id == null) ? 'new' : 'update',
				'row' => array (
					$item->name,
					$item->id
				)
			);
			$this->response->body(json_encode($data));
		}
		catch(ORM_Validation_Exception $e)
		{
			$errors = array();

			$list = $e->errors('models');

			foreach ($list as $field => $er) {
				if(!is_array($er))
					$er = array($er);

				$errors[] = array('field' => $field, 'msg' => $er);
			}

			$this->response->body(json_encode(array('action' => 'error', 'errors' => $errors)));
		}
	}

	public function action_delete()
	{
		$this->view = null;
		$values = $this->request->post();

		$item = ORM::factory('Item_Type', $values['id']);
		$item->delete();

		$this->response->headers('Content-Type','application/json');
		$this->response->body(json_encode(array('action' => 'deleted')));
	}
}
