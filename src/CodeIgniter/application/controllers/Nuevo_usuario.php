<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nuevo_usuario extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
            if(isset($_POST['Guardar'])){
                $documento = (int)$_POST['documento'];
                $usuarioAdmin = [
                    "usuario" => $_POST['usuario'],
                    "nombre" => $_POST['nombre'],
                    "apellido" => $_POST['apellido'],
                    "documento" => $documento,
                    "email" => $_POST['email'],
                    "password" => $_POST['password']
                    ];

                $this->guardar_datos_admin($usuarioAdmin);
            }
            else {
                if (isset($_POST['CheckUsuario'])) {
                    $existe = $this->existe_usuario($_POST['usuario']);
                    print json_encode($existe);
                } else {
                    if (isset($_POST['CheckMail'])) {
                    $existe = $this->existe_mail($_POST['email']);
                        print json_encode($existe);
                    } else {
                        $this->load->view('Nuevo_usuario');
                    }
                }
                
            }
	}
               
        private function guardar_datos_admin($usuarioAdmin)
        {
            try{                
                $this->load->model('Administrador_model');
                $perfil = $this->Administrador_model->guardar_datos_admin($usuarioAdmin);
                return $perfil;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function existe_usuario($codigoUsuario)
        {
            $this->load->model('Administrador_model');
            $idUsuario = $this->Administrador_model->obtener_id_admin($codigoUsuario);
            return !(is_null($idUsuario));
        }
        
        private function existe_mail($mail)
        {
            $this->load->model('Administrador_model');
            $mailUsuario = $this->Administrador_model->existe_mail($mail);
            return !(is_null($mailUsuario));
        }

        
}
