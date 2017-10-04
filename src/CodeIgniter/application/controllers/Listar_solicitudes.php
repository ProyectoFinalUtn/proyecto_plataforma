<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listar_solicitudes extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{	
            /*
             * Los que traen mas de uno devuelven un array como este:
             * array (size=1)
                0 => 
                  array (size=12)
                    'idSolicitud' => string '2' (length=1)
                    'idUsuarioVant' => string '61' (length=2)
                    'idTipoSolicitud' => string '1' (length=1)
                    'idUsuarioAprobador' => null
                    'idEstadoSolicitud' => string '1' (length=1)
                    'descripcionEstadoSolicitud' => string 'CREADA' (length=6)
                    'latitud' => string '-34.60389' (length=9)
                    'longitud' => string '-58.37056' (length=9)
                    'radioVuelo' => string '10' (length=2)
                    'fecha' => string '27/09/2017' (length=10)
                    'horaVueloDesde' => string '13:00:00' (length=8)
                    'horaVueloHasta' => string '15:00:00' (length=8)
             *
             * Los que traen uno solo los devuelve tipo objeto
             * $solicitud->idSolicitud
             * $solicitud->idUsuarioVant
             * $solicitud->...
             * La idea es tener un controller por vista, y un modelo por cada Tabla o grupos de tablas asociados a la misma funcion
             * Por ejemplo para solicitudes de excepcion todo lo que se le pegue a la base de datos iria en solicitud model
             */
            
            $solicitudes = $this->obtener_solicitudes();
            $data['solicitudes'] = $solicitudes;
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
            $this->load->view('Listar_solicitudes', $data);
            
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
        
        private function obtener_solicitud_por_id($id_solicitud)
        {
            try{                
                $this->load->model('Solicitud_model');
                $solicitud = $this->Solicitud_model->obtener_solicitud_por_id($id_solicitud);
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
