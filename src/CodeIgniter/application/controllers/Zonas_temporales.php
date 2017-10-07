<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonas_temporales extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{	
		$this->load->model('Zonas_temporales_model');
		$this->load->view('Zonas_temporales'); 	 		 	 
	}

	public function guardar_zona_temporal($zona)
	{	
	  $this->Zonas_temporales_model->guardar_zona($zona);	
	}
}
