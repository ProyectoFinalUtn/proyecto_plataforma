<?php
    class Registrovuelo_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }
              
        public function guardar_vuelo($vuelo)
        {
            try {
                $this->load->model('Llamadasrest_model');
                $direccion = $this->Llamadasrest_model->obtener_direccion_lon_lat($vuelo['latitud'], $vuelo['longitud'], 'g.o.guide.project@gmail.com');
                $this->load->model('Provincia_model');
                $provincia = $this->Provincia_model->obtener_id_provincia_y_loc($direccion);
                $vuelo['provincia'] = $provincia['provincia'];
                $vuelo['localidad'] = $provincia['localidad'];
                $vuelo['zona_interes'] = $provincia['zona_interes'];
            }
            catch(Exception $exception){
                $vuelo['provincia'] = null;
                $vuelo['localidad'] = null;
                $vuelo['zona_interes'] = null;
            }
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $vuelo['fecha_vuelo'] = date('Y-m-d', time());
            
            $result = $this->db->insert('vuelo', [
                'id_usuario_vant' => $vuelo["idUsuarioVant"],  
                'latitud' => $vuelo['latitud'],
                'longitud' => $vuelo['longitud'],
                'provincia' => $vuelo['provincia'],
                'localidad' => $vuelo['localidad'],
                'zona_interes' => $vuelo['zona_interes'],
                'fecha_vuelo' => $vuelo['fecha_vuelo']
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
    }
?>
