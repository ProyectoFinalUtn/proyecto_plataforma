<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editar_normativa extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{
            if(isset($_POST['Guardar'])){
                $normativa = [
                    "id_normativa" => $_POST['id_normativa'],
                    "descripcion" => $_POST['descripcion'],
                    "fecha_desde" => $_POST['fecha_desde'],
                    "fecha_hasta" => $_POST['fecha_hasta'],
                    "contenido" => $_POST['contenido'],
                    "contenido_html" => $_POST['contenido_html']
                    ];

                $this->cambiar_datos_normativa($normativa);
            }
            else {
                $id_normativa = $_GET['idNormativa'];
                $normativa = $this->obtener_datos_normativa($id_normativa);
                $data['normativa'] = $normativa;
                $this->load->view('Editar_normativa', $data);
            }
	}
        
        private function obtener_datos_normativa($id_normativa)
        {
            try{                
                $this->load->model('Normativa_model');
                $normativa = $this->Normativa_model->obtener_datos_normativa($id_normativa);
                return $normativa;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function cambiar_datos_normativa($normativa)
        {
            try{                
                $this->load->model('Normativa_model');
                $id_normativa = $this->Normativa_model->cambiar_datos_normativa($normativa);
                return $id_normativa;
            }
            catch(Exception $exception){
                
            }
        }
        
}