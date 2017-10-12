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
                $documento = (int)$_POST['documento'];
                $usuarioAdmin = [
                    "id_usuario" => $_POST['id_usuario'],
                    "id_persona" => $_POST['id_persona'],
                    "nombre" => $_POST['nombre'],
                    "apellido" => $_POST['apellido'],
                    "documento" => $documento,
                    "email" => $_POST['email']
                    ];

                $this->cambiar_datos_admin($usuarioAdmin);
                if (isset($_POST['password'])) {
                    $this->actualizar_password($_POST['id_usuario'], $_POST['password']);
                }
            }
            else {
                 if (isset($_POST['CheckMail'])) {
                    $existe = $this->existe_mail($_POST['email']);
                        print json_encode($existe);
                    } else {
                        $idUsuarioAdmin = $_SESSION['idUsuarioAdmin'];
                        $perfil = $this->obtener_datos_admin($idUsuarioAdmin);
                        $data['perfil'] = $perfil;
                        $this->load->view('Mi_perfil', $data);
                    }
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
        
        private function cambiar_datos_admin($usuarioAdmin)
        {
            try{                
                $this->load->model('Administrador_model');
                $perfil = $this->Administrador_model->cambiar_datos_admin($usuarioAdmin);
                return $perfil;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function existe_mail($mail)
        {
            $this->load->model('Administrador_model');
            $mailUsuario = $this->Administrador_model->existe_mail($mail);
            return !(is_null($mailUsuario));
        }
        
        public function actualizar_password($idUsuario, $password)
        {
            try{                
                $this->load->model('Administrador_model');
                $perfil = $this->Administrador_model->actualizar_password($idUsuario, $password);
                return $perfil;
            }
            catch(Exception $exception){
                
            }
        }

        
}
