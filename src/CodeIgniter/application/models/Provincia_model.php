<?php
    class Provincia_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }
              
        public function obtener_provincias()
        {        
            $sql = 'id_provincia, provincia';
            $this->db->select($sql);
            $this->db->from('provincia');
            $this->db->order_by('id_provincia', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_localidades($idProvincia)
        {        
            $sql = 'id_localidad, id_provincia, localidad';
            $this->db->select($sql);
            $this->db->from('localidad');
            $this->db->where('id_provincia = ', $idProvincia);
            $this->db->order_by('id_provincia', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_id_localidad($direccion)
        {
            if (isset($direccion['address']['state'])) {
                if ($direccion['address']['state'] == 'Ciudad Autónoma de Buenos Aires') {
                    $localidad = $direccion['address']['suburb'];

                    $sql = 'id_localidad, id_provincia, localidad';
                    $filtro = "%".$localidad."%";
                    $this->db->select($sql);
                    $this->db->from('localidad');
                    $this->db->where('localidad like ', $filtro);
                    $this->db->order_by('id_localidad', 'asc');
                    $query = $this->db->get()->row();
                    return $query;
                } else {
                    if (isset($direccion['address']['city'])) {
                        $localidad = $direccion['address']['city'];

                        $sql = 'id_localidad, id_provincia, localidad';
                        $filtro = $localidad;
                        $this->db->select($sql);
                        $this->db->from('localidad');
                        $this->db->where('localidad = ', $filtro);
                        $this->db->order_by('id_localidad', 'asc');
                        $query = $this->db->get()->row();
                        return $query;
                    } else {
                        if (isset($direccion['address']['state_district'])) {
                            if ($direccion['address']['state_district'] == 'Partido de La Costa') {
                                $localidad = $direccion['address']['state_district'];
                                $sql = 'id_localidad, id_provincia, localidad';
                                $filtro = $localidad;
                                $this->db->select($sql);
                                $this->db->from('localidad');
                                $this->db->where('localidad = ', $filtro);
                                $this->db->order_by('id_localidad', 'asc');
                                $query = $this->db->get()->row();
                                return $query;
                            } else {
                                $localidad = $direccion['address']['state_district'];
                                $localidad = str_replace('Partido de ' , '', $localidad);
                                $localidad = str_replace('Departamento ' , '', $localidad);

                                $sql = 'id_localidad, id_provincia, localidad';
                                $filtro = $localidad;
                                $this->db->select($sql);
                                $this->db->from('localidad');
                                $this->db->where('localidad = ', $filtro);
                                $this->db->order_by('id_localidad', 'asc');
                                $query = $this->db->get()->row();
                                return $query;
                            }
                        } else {
                            return null;
                        }
                    }
                }
            }
            else {
                return null;
            }
        }
        
        public function obtener_zona_de_interes($direccion)
        {
            if (isset($direccion['address']['memorial'])) {
                return $direccion['address']['memorial'];
            } else {
                if (isset($direccion['address']['attraction'])) {
                    return $direccion['address']['attraction'];
                } else {
                    return null;
                }
            }
        }
               
        public function obtener_id_provincia_y_loc($direccion)
        {
            try {
            $localidad = $this->obtener_id_localidad($direccion);
            $zonaInteres = $this->obtener_zona_de_interes($direccion);
            if ($localidad != null) {
                $idLocalidad = $localidad->id_localidad;
                $idProvincia = $localidad->id_provincia;
                return ['provincia' => $idProvincia, 'localidad' => $idLocalidad, 'zona_interes' => $zonaInteres];
            } else {
                if (isset($direccion['address']['state'])) {
                    $provincia = $direccion['address']['state'];
                    $sql = 'id_provincia, provincia';
                    $filtro = "%".$provincia."%";
                    $this->db->select($sql);
                    $this->db->from('provincia');
                    $this->db->where('provincia like ', $filtro);
                    $this->db->order_by('id_provincia', 'asc');
                    $query = $this->db->get()->row();
                    if ($query != null) {
                        $idProvincia = $query->id_provincia;
                        $idLocalidad = null;
                        return ['provincia' => $idProvincia, 'localidad' => $idLocalidad, 'zona_interes' => $zonaInteres];
                    } else {
                        return ['provincia' => null, 'localidad' => null, 'zona_interes' => null];
                    }
                    
                } else {
                    return ['provincia' => null, 'localidad' => null, 'zona_interes' => null];
                }
            }
            
            }
            catch(Exception $exception){
                return ['provincia' => null, 'localidad' => null, 'zona_interes' => null];
            }
        }
        

    }
?>
