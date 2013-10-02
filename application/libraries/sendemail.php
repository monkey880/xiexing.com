<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 



class Sendemail {


	public function __construct($arr = array()){

	

	}

	

	public function send($to,$titel,$content)
{
	
$this->load->library('email');	
$this->email->from('kerry100124@sina.com', '携行 专业酒店预订网');
$this->email->to($to); 
$this->email->cc(''); 
$this->email->bcc(''); 

$this->email->subject($titel);
$this->email->message($content); 

$this->email->send();


	
}

}

