<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_User_Login extends Controller_User {

	/**
	 * Display the login page and handle login attempts.
	 */

	public function action_index()
	{
		if ($this->auth->logged_in())
		{
			$this->redirect('user');
		}

		if ($this->request->method() == HTTP_Request::POST)
		{
			$post = $this->request->post();

			if ($this->auth->login($post['username'], $post['password'], isset($post['remember'])))
			{
				Hint::success(Kohana::message('user', 'login.success'));
				$this->redirect('');
			}
			else
			{
				Hint::error(Kohana::message('user', 'login.incorrect'));
			}
		}

		$this->view = new View_User_Login;
	}

}