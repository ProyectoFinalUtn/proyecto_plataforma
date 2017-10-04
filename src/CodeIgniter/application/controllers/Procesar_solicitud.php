<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procesar_solicitud extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{	
                       
            $solicitud = $this->obtener_detalle_solicitud_por_id('6');
            $data['solicitud'] = $solicitud;
            $this->load->model('Usuariovant_model');
            $usuariosVant = $this->Usuariovant_model->obtener_perfiles();
            /*
             * usuariosVant traera los perfiles de usuario para poder traer la info de cada usuario
             * array (size=1)
                0 => 
                  array (size=18)
                    'idUsuarioVant' => string '1' (length=1)
                    'nombreDePerfil' => string 'Usuario' (length=14)
                    'usuario' => string 'user' (length=7)
                    'pass' => string '64e6d9fd09qffff' (length=6)
                    'nombre' => string 'Nombre' (length=7)
                    'apellido' => string 'Apellido' (length=6)
                    'email' => string 'usuario@mail.com' (length=27)
                    'edad' => string '27' (length=2)
                    'sexo' => string 'M' (length=1)
                    'tipoDoc' => string '96' (length=2)
                    'nroDoc' => string '35111322' (length=8)
                    'calle' => string 'Medrano' (length=7)
                    'nro' => string '957' (length=3)
                    'piso' => string '5' (length=1)
                    'dpto' => string '510' (length=3)
                    'provincia' => string '' (length=0)
                    'localidad' => string 'CABA' (length=4)
                    'telefono' => string '12345678' (length=8)
             * 
             * usuariosAdmin traera los nombres de los usuarios admin para mostrar el nombre de usuarioAprobador
             */
            $this->load->model('Administrador_model');
            $usuariosAdmin = $this->Administrador_model->obtener_datos_usuarios_admin();
            $data['usuariosVant'] = $usuariosVant;
            $data['usuariosAdmin'] = $usuariosAdmin;
            $this->load->view('Procesar_solicitud', $data);
            
	}
        
        private function obtener_solicitudes_por_usuario($id_usuario)
        {   
            try{
                $this->load->model('Solicitud_model');
                $solicitudes = $this->Solicitud_model->obtener_solicitud_por_usuario($id_usuario);
                return $solicitudes ;
            }
            catch(Exception $exception){
                //$exception->getMessage()
            }
        }
        
        private function obtener_solicitud_por_estado($idEstadoSolicitud)
        {
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitud_por_id($idEstadoSolicitud);
                return $solicitud;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_detalle_solicitud_por_id($id_solicitud)
        {
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_detalle_solicitud_por_id($id_solicitud);
                return $solicitud;
            }
            catch(Exception $exception){
                
            }
        }
        
        private function obtener_solicitudes()
        {
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitudes();
                return $solicitud;
            }
            catch(Exception $exception){
                
            }
        }
        
}
