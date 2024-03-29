<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Uyeler extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('URL');

		if(!$this->session->userdata("admin_session"))
			redirect(base_url().'admin/login');
	}


	public function index()
	{
		$query = $this->db->query("SELECT * FROM uyeler ORDER BY adsoyad");
		$data["veriler"]=$query->result();

		$this->load->view('admin/uyeler_liste',$data);
	}


	public function ekle()
	{
		$this->load->view('admin/uyeler_ekle');
	}


	public function ekle_kaydet()
	{
		//Form verilerini alacak
		$data=array(
			'adsoyad' => $this->input->post('adsoyad'),
			'email' => $this->input->post('email'),
			'sifre' => $this->input->post('sifre'),
			'adres' => $this->input->post('adres'),
			'sehir' => $this->input->post('sehir'),
			'tel' => $this->input->post('tel'),
			'durum' => $this->input->post('durum'),
			'yetki' => $this->input->post('yetki')
		);

		$this->db->insert("uyeler",$data);
		$this->session->set_flashdata("mesaj","Üye Eklendi");
        redirect(base_url().'admin/uyeler');
	}


	public function duzenle($id)
	{
		$query = $this->db->query("SELECT * FROM uyeler WHERE Id = $id");
		$data["veri"]=$query->result();

		$this->load->view('admin/uyeler_duzenle_formu',$data);
	}


	public function guncelle($id)
	{
		//Form verilerini alacak
		$data=array(
			'adsoyad' => $this->input->post('adsoyad'),
			'email' => $this->input->post('email'),
			'sifre' => $this->input->post('sifre'),
			'adres' => $this->input->post('adres'),
			'sehir' => $this->input->post('sehir'),
			'tel' => $this->input->post('tel'),
			'durum' => $this->input->post('durum'),
			'yetki' => $this->input->post('yetki')
		);

		$this->load->model('Database_Model');
		$this->Database_Model->update_data("uyeler", $data, $id);
		$this->session->set_flashdata("mesaj","Üye Bilgileri Güncellendi");
        redirect(base_url().'admin/uyeler');
	}


	public function sil($id)
	{
		$this->db->query("DELETE FROM uyeler WHERE Id = $id");
		redirect(base_url().'admin/uyeler');
	}


}
