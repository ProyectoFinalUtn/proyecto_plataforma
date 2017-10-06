<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mi_perfil extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{
            if(isset($_POST['Guardar'])){
                //id_usuario: ID, nombre: NOMBRE, apellido: APELLIDO, documento: DOCUMENTO, EDAD: edad, EMAIL: email, Guardar: 1 } );
                $id_usuario = $_POST['id_usuario'];
                $id_persona = $_POST['id_persona'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $documento = $_POST['documento'];
                $edad = $_POST['edad'];
                $email = $_POST['email'];
                $this->cambiar_datos_admin($id_usuario,$id_persona,$nombre,$apellido,$documento,$edad,$email);
            }
            else {
                $idUsuarioAdmin = $_SESSION['idUsuarioAdmin'];
                $perfil = $this->obtener_datos_admin($idUsuarioAdmin);
                $data['perfil'] = $perfil;
                $this->load->view('Mi_perfil', $data);
            }
	}
        
        private function obtener_datos_admin($idUsuarioAdmin)
        {
            try{                
                $this->load->model('Administrador_model');
                $perfil = $this->Administrador_model->obtener_datos_admin($idUsuarioAdmin);
                return $perfil;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function cambiar_datos_admin($id_usuario,$id_persona,$nombre,$apellido,$documento,$edad,$email)
        {
            try{                
                $this->load->model('Administrador_model');
                $perfil = $this->Administrador_model->cambiar_datos_admin($id_usuario,$id_persona,$nombre,$apellido,$documento,$edad,$email);
                return $perfil;
            }
            catch(Exception $exception){
                
            }
        }

        
}
