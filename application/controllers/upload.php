<?php

class Upload extends CI_Controller {
 
 function __construct()
 {
  parent::__construct();
  $this->load->helper(array('form', 'url'));
 }
 
 function index()
 { 
  $this->load->view('upload_form', array('error' => ' ' ));
 }

 function do_upload()
 {
  $config['upload_path'] = './public/uploadfiles/upload/';
  $config['allowed_types'] = 'gif|jpg|png';
  $config['max_size'] = '10000';
  $config['max_width']  = '0';
  $config['max_height']  = '0';
  $config['encrypt_name']  = true;
  
  $this->load->library('upload', $config);
 
  if ( ! $this->upload->do_upload('Filedata'))
  {
   $error = $this->upload->display_errors();
   
   //echo $error;
  } 
  else
  {
   $data =  $this->upload->data();
   echo $data['file_name'];
   
  }
 } 
}
?>