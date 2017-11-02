<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafico_usuarios extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();        
    }

	public function index()
	{
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    $fecha_desde = '';
                    $fecha_hasta = '';
                    $provincia = '0';
                    $localidad = '0';
                    $ejeY = 'cantidad';
                    $usuariosVant = $this->obtener_grafico_por_edad($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY);
                    $data = array();
                    foreach ($usuariosVant as $usuarioVant) {
                        $data[] = $usuarioVant;
                    }
                    print json_encode($data);
                    break;
                case 'POST':
                    if(isset($_POST['ejeX'])) {
                        $fecha_desde = $_POST['filtro_desde'];
                        $fecha_hasta = $_POST['filtro_hasta'];
                        $provincia = $_POST['filtro_provincia'];
                        $localidad = $_POST['filtro_localidad'];
                        $ejeY = $_POST['ejeY'];
                        switch ($_POST['ejeX']):
                            case 'sexo':
                                $usuariosVant = $this->obtener_grafico_por_sexo($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY);
                                break;
                            case 'localidad':
                                $usuariosVant = $this->obtener_grafico_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY);
                                break;
                            case 'provincia':
                                $usuariosVant = $this->obtener_grafico_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY);
                                break;
                            case 'edad':
                                $usuariosVant = $this->obtener_grafico_por_edad($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY);
                                break;
                            case 'zona_interes':
                                $usuariosVant = $this->obtener_grafico_por_zona($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY);
                                break;
                        endswitch;
                        $data = array();
                        foreach ($usuariosVant as $usuarioVant) {
                            $data[] = $usuarioVant;
                        }
                        print json_encode($data);                        
                    }
                    break;
            }
	}
      
        private function obtener_grafico_por_edad($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY)
        {
           switch ($ejeY) {
                case 'cantidad':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_edad($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
                case 'vuelos':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vuelos_por_edad($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
           }
        }

        private function obtener_grafico_por_sexo($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY)
        {
            switch ($ejeY) {
                case 'cantidad':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_sexo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
                case 'vuelos':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vuelos_por_sexo($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
            }
        }
        
        private function obtener_grafico_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY)
        {
            switch ($ejeY) {
                case 'cantidad':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
                case 'vuelos':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vuelos_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
            }
        }
        
        private function obtener_grafico_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY)
        {
            switch ($ejeY) {
                case 'cantidad':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vants_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
                case 'vuelos':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vuelos_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
            }
        }
        
        private function obtener_grafico_por_zona($fecha_desde, $fecha_hasta, $provincia, $localidad, $ejeY)
        {
            switch ($ejeY) {
                case 'vuelos':
                    try{                
                        $this->load->model('Usuariovant_model');
                        $listadoUsuariosVant = $this->Usuariovant_model->obtener_vuelos_por_zona($fecha_desde, $fecha_hasta, $provincia, $localidad);
                        return $listadoUsuariosVant;
                    }
                    catch(Exception $exception){

                    }
                    break;
            }
        }
}