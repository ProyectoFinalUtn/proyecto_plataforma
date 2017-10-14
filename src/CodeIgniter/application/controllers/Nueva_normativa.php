<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nueva_normativa extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
            if(isset($_POST['Guardar'])){
                $normativaNueva = [
                    "descripcion" => $_POST['descripcion'],
                    "fecha_desde" => $_POST['fecha_desde'],
                    "fecha_hasta" => $_POST['fecha_hasta'],
                    "contenido" => $_POST['contenido']
                    ];

                $this->guardar_normativa($normativaNueva);
            }
            else {
                $this->load->view('Nueva_normativa');
            }
	}
               
        private function guardar_normativa($normativaNueva)
        {
            try{                
                $this->load->model('Normativa_model');
                $id_normativa = $this->Normativa_model->guardar_normativa($normativaNueva);
                return $id_normativa;
            }
            catch(Exception $exception){
                
            }
        }
        
}
