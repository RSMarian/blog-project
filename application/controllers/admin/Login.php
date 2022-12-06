<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index()
	{
		if(isset($_SESSION['user_id'])){
			redirect('admin/dashboard');
		}

		$data=[];
		if(isset($_SESSION['error'])){
			$data['error']=$_SESSION['error'];
		}else{
			$data['error']="NO_ERROR";
		}
		// 
		$this->load->view('adminpanel/loginview', $data);
	}

	function login_post(){
		print_r($_POST);
		if (isset($_POST)) {
			$email = $_POST['email'];
			$password = $_POST['password'];

			$query = $this->db->query("SELECT * FROM `backenduser` WHERE `username`='$email' AND password='$password'");

			if($query->num_rows()) {
				// VALID CREDENTIALS
				$result = $query->result_array();
				echo "<pre>";
				//print_r($result); die();

				$this->session->set_userdata('user_id', $result[0]['uid']);

				redirect('admin/dashboard');
				
			}else{
				//INVALID CREDENTIALS
				$this->session->set_flashdata('error', 'Invalid Credentials');
				redirect("admin/login");
			}

		}else{
			die("Invalid Input!");
		}
	}

	function logout(){
		session_destroy();

		redirect('admin/login');
	}
}
