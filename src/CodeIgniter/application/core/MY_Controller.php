<?php

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        if (!$this->session->userdata('loggedin'))
        {
            redirect('/sessions/login');
        }
    }
}
?>