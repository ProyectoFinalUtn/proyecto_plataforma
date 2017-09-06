<?php
class Persona_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->load->database();                
    }

    public function get_password($nombre)
    {
            $this->db->select('password');
            $query = $this->db->get_where('administrador', array('nombre =' => $nombre))->row();
            if (count($query) > 0) {
               return $query->password;
            }else {
                return NULL;
            }
    }
    
    public function guardar_persona($persona)
    {
        $this->db
        ->insert('persona', [
            'nombre' => $persona["nombre"],
            'apellido' => $persona["apellido"] != NULL ? $persona["apellido"] : NULL,
            //'idTipoDocumento' => $persona["idTipoDocumento"] != NULL ? $persona["idTipoDocumento"] : NULL,
            //'nroDocumento' => $persona["nroDocumento"] != NULL ? $persona["nroDocumento"] : NULL,            
            'edad' => $persona["edad"] != NULL ? $persona["edad"] : NULL,
            'email' => $persona["email"] != NULL ? $persona["email"] : NULL/*,
            'sexo' => $persona["sexo"] != NULL ? $persona["sexo"] : NULL,
            'calle' => $persona["calle"] != NULL ? $persona["calle"] : NULL,
            'numero' => $persona["numero"] != NULL ? $persona["numero"] : NULL,
            'piso' => $persona["piso"] != NULL ? $persona["piso"] : NULL,    
            'dpto' => $persona["dpto"] != NULL ? $persona["dpto"] : NULL,
            'provincia' => $persona["provincia"] != NULL ? $persona["provincia"] : NULL,
            'localidad' => $persona["localidad"] != NULL ? $persona["localidad"] : NULL,
            'telefono' => $persona["telefono"] != NULL ? $persona["telefono"] : NULL*/
        ]);
        return $this->db->insert_id();  
    }
}



?>