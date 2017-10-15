<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eliminar_normativa extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'POST':
                    $id_normativa = $_POST['id_normativa'];
                    $this->dar_baja_normativa($id_normativa);
                    break;
            }
	}
      
        private function dar_baja_normativa($id_normativa)
        {
            try{                
                $this->load->model('Normativa_model');
                $normativa = $this->Normativa_model->dar_baja_normativa($id_normativa);
                return $normativa;
            }
            catch(Exception $exception){
                
            }
        }

}
