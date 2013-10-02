<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @ID model_index.php
 * 前台首页model
 * @date 2013-1-23 
 * @author zhaojianjun zjj008@gmail.com
 * @copyright zhuna Inc , all rights reserved
 * 
 */

class Model_index extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }    
}
?>
