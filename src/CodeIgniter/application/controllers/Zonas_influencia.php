<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonas_influencia extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{	
            $this->load->view('Zonas_influencia'); 	 		 	 
	}
}
