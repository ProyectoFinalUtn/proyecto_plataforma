<?php
    class Persona_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }

        public function guardar_persona($persona)
        {
            $this->valida_persona($persona);
            $result =$this->db
            ->insert('persona', [
                'nombre' => $persona["nombre"],
                'apellido' => $persona["apellido"] != NULL ? $persona["apellido"] : NULL,
                'id_tipo_documento' =>  array_key_exists("idTipoDocumento", $persona) ? $persona["idTipoDocumento"] > 0 ? $persona["idTipoDocumento"] : NULL : NULL,
                'nro_documento' => array_key_exists("nroDocumento", $persona) ? $persona["nroDocumento"] > 0 ? $persona["nroDocumento"] : NULL : NULL,
                'edad' => $persona["edad"],
                'email' => $persona["email"],
                'sexo' => array_key_exists("sexo", $persona) ? $persona["sexo"] : NULL,
                'calle' => array_key_exists("calle", $persona) ? $persona["calle"] : NULL,
                'numero' => array_key_exists("numero", $persona) ? $persona["numero"] : NULL,
                'piso' => array_key_exists("piso", $persona) ? $persona["piso"] : NULL,    
                'dpto' => array_key_exists("dpto", $persona) ? $persona["dpto"] : NULL,
                'provincia' => array_key_exists("provincia", $persona) ? $persona["provincia"] : NULL,
                'localidad' => array_key_exists("localidad", $persona) ? $persona["localidad"] : NULL,
                'telefono' => array_key_exists("telefono", $persona) ? $persona["telefono"] : NULL
            ]);
            
            /*$result = $this->db->query($sql);
            echo $sql;
            $result = $this->db->query($sql);*/
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        public function modifica_persona($persona, $personaModificacion)
        {
            $this->valida_persona_modificacion($persona, $personaModificacion);
            $this->db->where('id_persona', $personaModificacion->id_persona);
            $result = $this->db->update('persona', [
                'nombre' => $persona["nombre"],
                'apellido' => $persona["apellido"] != NULL ? $persona["apellido"] : NULL,
                'id_tipo_documento' =>  array_key_exists("idTipoDocumento", $persona) ? $persona["idTipoDocumento"] > 0 ? $persona["idTipoDocumento"] : NULL : NULL,
                'nro_documento' => array_key_exists("nroDocumento", $persona) ? $persona["nroDocumento"] > 0 ? $persona["nroDocumento"] : NULL : NULL,
                'edad' => array_key_exists("edad", $persona) ? $persona["edad"] : NULL,
                'email' => $persona["email"],
                'sexo' => array_key_exists("sexo", $persona) ? $persona["sexo"] : NULL,
                'calle' => array_key_exists("calle", $persona) ? $persona["calle"] : NULL,
                'numero' => array_key_exists("nro", $persona) ? $persona["nro"] : NULL,
                'piso' => array_key_exists("piso", $persona) ? $persona["piso"] : NULL,    
                'dpto' => array_key_exists("dpto", $persona) ? $persona["dpto"] : NULL,
                'provincia' => array_key_exists("provincia", $persona) ? $persona["provincia"] : NULL,
                'localidad' => array_key_exists("localidad", $persona) ? $persona["localidad"] : NULL,
                'telefono' => array_key_exists("telefono", $persona) ? $persona["telefono"] : NULL
            ]);
            
            /*$result = $this->db->query($sql);
            echo $sql;
            $result = $this->db->query($sql);*/
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return;  
        }
        
        public function valida_persona($persona){
            $this->db->select('email');
            $query = $this->db->get_where('persona', array('email =' => $persona["email"]))->row();
            if (count($query) > 0) {
               throw new Exception("El correo electronico ya se encuentra registrado");
            }
        }
        
        public function obtener_persona_por_id($idPersona){
            $query = $this->db->get_where('persona', array('id_persona =' => $idPersona))->row();
            if (count($query) > 0) {
               throw new Exception("El correo electronico ya se encuentra registrado");
            }
        }
        
        public function valida_persona_modificacion($persona, $personaGuardada){
            //$personaGuardada = $this->obtener_persona_por_id($persona['id_persona']);
            if($personaGuardada->email != $persona['email']){
                /*$this->db->select('id_persona');
                $this->db->where('id_persona !=', $personaGuardada->id_persona);
                $this->db->where('email', $persona["email"]);
                $query = $this->db->get()->row();*/
                $query = $this->db->get_where('persona', array('id_persona !=' => $personaGuardada->id_persona, 'email =' => $persona["email"]))->row();
                if (count($query) > 0) {
                    throw new Exception("El correo electronico ya se encuentra registrado");
                }
            }
        }
    }
?>
