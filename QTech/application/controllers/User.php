<?php

class User extends CI_Controller
{

	/** 
	 * Landing page
	 * http://localhost/QTech/index.php/user/landing_page
	 * */
	public function landing_page()
	{
		log_message('debug', 'this is debug log');
		$this->load->view('landing-page');
	}

	/** 
	 * Loging page
	 * http://localhost/QTech/index.php/user/login_page
	 * */	
	public function login_page()
	{
		log_message('debug', 'this is debug log');
		$this->load->view('login-page');
	}

	/** 
	 * Signup page
	 * http://localhost/QTech/index.php/user/signup_page
	 * */	
	public function signup_page()
	{
		log_message('debug', 'this is debug log');
		$this->load->view('signup-page');
	}

	/** 
	 * Main Pages
	 * http://localhost/QTech/index.php/user/#login_page/home
	 * */
	public function index()
	{
		log_message('debug', 'this is debug log');
		$this->load->view('index');
	}
	
}
