<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Login extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->database();
	}

	public function index()
	{
		$this->load->view('admin/login_form');
		
	}

	public function login_ol()
	{
		$email = $this->input->post("email");
		$sifre = $this->input->post("sifre");

		//Zararlı kodlardan temizleme
		echo $email = $this->security->xss_clean($email);
		echo $sifre = $this->security->xss_clean($sifre);

		$this->load->model('Database_Model');

		$result= $this->Database_Model->login("admin",$email,$sifre);

		if ($result)
		{
			//Kullanıcı var ise bilgileri diziye aktarılıyor
			$sess_array = array(
				'id' => $result[0] ->Id,
				'yetki' => $result[0] ->yetki,
				'email' => $result[0] ->email,
				'adsoyad' => $result[0] ->adsoyad,
				'resim' => $result[0] ->resim
			);

			//Session değişkenine atama
			$this->session->set_userdata("admin_session",$sess_array);
			redirect(base_url().'admin');
		}
		else
		{
			$this->session->set_flashdata("mesaj","Hatalı kullanıcı adı ya da şifre!!");
			redirect(base_url().'admin/login');
		}


	}

	public function login_cik()
	{
		$this->session->unset_userdata("admin_session");
		redirect(base_url().'admin/login');
	}

}
