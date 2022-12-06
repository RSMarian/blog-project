<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {


	public function index()
	{
        $query = $this->db->query("SELECT * FROM `articles` ORDER BY blogid DESC");
        $data['result'] = $query->result_array();
		$this->load->view('adminpanel/viewblog', $data);
	}

    public function addblog(){
        $this->load->view('adminpanel/addblog');
    }

    public function addblog_post(){
        // print_r($_POST);
        // print_r($_FILES);

        if ($_FILES) {
            //IMG IS PASSED TO UPLOAD
                $config['upload_path']          = './assets/upload/blogimg/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('file'))
                {
                    $error = array('error' => $this->upload->display_errors());

                    die("Error");
                    //$this->load->view('upload_form', $error);
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());

                    // echo "<pre>";
                    // print_r($data);
                    // echo $data['upload_data']['file_name'];

                    $fileurl = "assets/upload/blogimg/".$data['upload_data']['file_name'];
                    $blog_title = $_POST['blog_title'];
                    $desc = $_POST['desc'];

                    $query = $this->db->query("INSERT INTO `articles`(`blog_title`, `blog_desc`, `blog_img`) VALUES ('$blog_title','$desc','$fileurl')");

                    if ($query) {
                        $this->session->set_flashdata('inserted', 'yes');
                        redirect('admin/blog/addblog');
                    }else{
                        $this->session->set_flashdata('inserted', 'no');
                        redirect('admin/blog/addblog');
                    }


                        //$this->load->view('upload_success', $data);
                }
        }else{
            //IMG IS NOT PASSED
        }


    }

    function editblog($blog_id){
        //print_r($blog_id);
        $query = $this->db->query("SELECT `blog_title`, `blog_desc`, `blog_img`, `status` FROM `articles` WHERE `blogid`='$blog_id'");

        $data['result'] = $query->result_array();
        $data['blog_id'] = $blog_id;

        $this->load->view("adminpanel/editblog", $data);
    }

    function editblog_post(){
        // print_r($_POST); die();

        print_r($_FILES);
        if ($_FILES['file']['name']) {
            //die("Update File");

            //UPDATE IMAGE
            $config['upload_path']          = './assets/upload/blogimg/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file'))
            {
                $error = array('error' => $this->upload->display_errors());

                die("Error");
                //$this->load->view('upload_form', $error);
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());

                // echo "<pre>";
                // print_r($data['upload_data']['file_name']);

                $filename_location = "assets/upload/blogimg/". $data['upload_data']['file_name'];

                $blog_title = $_POST['blog_title'];
                $desc = $_POST['desc'];
                $blog_id = $_POST['blog_id'];
                $publish_unpublish = $_POST['publish_unpublish'];

                $query = $this->db->query("UPDATE `articles` SET `blog_title`='$blog_title',`blog_desc`='$desc',`blog_img`='$filename_location', `status`='$publish_unpublish' WHERE `blogid`='$blog_id'");

                if ($query) {
                    $this->session->set_flashdata('updated', 'yes');
                    redirect("admin/blog");
                }else{
                    $this->session->set_flashdata('updated', 'no');
                    redirect("admin/blog");
                }
            }

        }else{
            // die("Update without file");
            $blog_title = $_POST['blog_title'];
            $desc = $_POST['desc'];
            $blog_id = $_POST['blog_id'];
            $publish_unpublish = $_POST['publish_unpublish'];

            $query = $this->db->query("UPDATE `articles` SET `blog_title`='$blog_title',`blog_desc`='$desc', `status`='$publish_unpublish' WHERE `blogid`='$blog_id'");

            if ($query) {
                $this->session->set_flashdata('updated', 'yes');
                    redirect("admin/blog");
            }else{
                $this->session->set_flashdata('updated', 'no');
                redirect("admin/blog");
            }
        }
    }

    function deleteblog(){
        // print_r($_POST);

        $delete_id = $_POST['delete_id'];

        $qry = $this->db->query("DELETE FROM `articles` WHERE `blogid`='$delete_id'");

        if ($qry) {
            echo "deleted";
        }else{
            echo "notdeleted";
        }
    }

}
