<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonas_temporales extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct(); 
        $this->load->model('Zonas_temporales_model');        	
    }

	public function index()
	{			
		$this->load->view('Zonas_temporales'); 	 		 	 
	}

	public function guardar_zona_temporal()
	{
	  $zona = json_decode($_POST['data'], true);
	  $this->Zonas_temporales_model->guardar_zona($zona);	  
	}

	public function eliminar_zona_temporal()
	{
	  $zona = json_decode($_POST['data'], true);
	  $this->Zonas_temporales_model->eliminar_zona($zona);	  
	}

}
