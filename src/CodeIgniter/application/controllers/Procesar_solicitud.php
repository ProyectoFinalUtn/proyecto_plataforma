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
            if(isset($_POST['Procesar'])){
                $estadoNuevo=$_POST['estadoNuevo'];
                $idSolicitudActualizada=$_POST['idSolicitud'];
                $usuarioAdmin=$_POST['usuarioAprobador'];
                $this->load->model('Administrador_model');
                $usuarioAprobador = $this->Administrador_model->obtener_id_admin($usuarioAdmin);
                $idUsuarioAprobador = $usuarioAprobador->id_usuario;
                $this->cambiar_estado_solicitud($idSolicitudActualizada,$estadoNuevo,$idUsuarioAprobador);
                $solicitud = $this->obtener_detalle_solicitud_por_id($_POST['idSolicitud']);
                $data['solicitud'] = $solicitud;
                $this->load->view('Procesar_solicitud', $data);
            }
            else {
                $solicitud = $this->obtener_detalle_solicitud_por_id($_GET['idSolicitud']);
                $data['solicitud'] = $solicitud;
                $this->load->view('Procesar_solicitud', $data);
            }
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
        
        private function cambiar_estado_solicitud($idSolicitud,$estadoNuevo,$idUsuarioAprobador)
        {
            try{                
                $this->load->model('Solicitud_model');
                $solicitudActualizada = $this->Solicitud_model->cambiar_estado_solicitud($idSolicitud,$estadoNuevo,$idUsuarioAprobador);
                return $solicitudActualizada;
            }
            catch(Exception $exception){
                
            }
        }
        
}
