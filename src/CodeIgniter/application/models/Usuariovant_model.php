<?php
    class Usuariovant_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }

        public function login_user($usuario, $pass)
        {
            $query = $this->db->get_where('usuario_vant', array('usuario =' => $usuario))->row();
            if (count($query) > 0) {
               if(md5($query->password) != $pass){
                   throw new Exception("Password invalido");
               }
               return $query;
            }else {
               throw new Exception("Usuario invalido");
            }
        }
        
        public function login_perfil($usuario, $pass)
        {
            /*$sql = 'usuario_vant.id_usuario idUsuarioVant, perf.nombre_de_perfil nombreDePerfil, '. 
                   'usuario_vant.usuario, usuario_vant.pass, pers.nombre, pers.apellido, '.
                   'pers.email, pers.edad, pers.sexo, pers.id_tipo_documento tipoDoc, pers.nro_documento nroDoc, '.
                   'pers.calle, pers.numero nro, pers.piso, pers.dpto, pers.provincia, pers.localidad, pers.telefono';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('usuario_vant.usuario = ', $usuario);
            $query = $this->db->get()->row();
            if (count($query) > 0) {
               if($query->pass != md5($pass)){
                   throw new Exception("Password invalido");
               }
               return $query;
            }else {
               throw new Exception("Usuario invalido");
            }*/
            return $this->login_perfil_encriptado($usuario, md5($pass));
        }
        
        public function login_perfil_encriptado($usuario, $pass)
        {
            $sql = 'usuario_vant.id_usuario idUsuarioVant, perf.nombre_de_perfil nombreDePerfil, '. 
                   'usuario_vant.usuario, usuario_vant.pass, pers.nombre, pers.apellido, '.
                   'pers.email, pers.edad, pers.sexo, pers.id_tipo_documento tipoDoc, pers.nro_documento nroDoc, '.
                   'pers.calle, pers.numero nro, pers.piso, pers.dpto, pers.provincia, pers.localidad, pers.telefono';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('usuario_vant.usuario = ', $usuario);
            $query = $this->db->get()->row();
            if (count($query) > 0) {
               if($query->pass != $pass){
                   throw new Exception("Password invalido");
               }
               return $query;
            }else {
               throw new Exception("Usuario invalido");
            }
        }
        
        public function crear_perfil($perfil)
        {        
            $this->db->trans_begin();  
            //$this->db->trans_start(TRUE);
            $this->load->model('Persona_model');
            $id_persona = $this->Persona_model->guardar_persona($perfil);
            //$error = $this->db->error(); 
            $id_perfil = $this->guardar_perfil($perfil);
            $perfil["idPersona"] = $id_persona;
            $perfil["idPerfil"] = $id_perfil;
            $id_usuario = $this->guardar_usuario_vant($perfil);
            //$this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al guardar los datos del perfil");
            }
            else
            {
                $this->db->trans_commit();
                return $id_usuario;
            }
        }
        
        public function obtener_perfiles()
        {        
            $sql = 'usuario_vant.id_usuario idUsuarioVant, perf.nombre_de_perfil nombreDePerfil, '. 
                   'usuario_vant.usuario, usuario_vant.pass, pers.nombre, pers.apellido, '.
                   'pers.email, pers.edad, pers.sexo, pers.nro_documento nroDoc, '.
                   'pers.calle, pers.numero nro, pers.piso, pers.dpto, pers.provincia, pers.localidad, pers.telefono, count(vant.id_usuario_vant) cantidadvant';
            $by = 'usuario_vant.id_usuario, perf.nombre_de_perfil, usuario_vant.usuario, '.
                'usuario_vant.pass, pers.nombre, pers.apellido, pers.email, pers.edad, pers.sexo, pers.nro_documento, '.
                'pers.calle, pers.numero, pers.piso, pers.dpto, pers.provincia, pers.localidad, pers.telefono';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->join('vant', 'vant.id_usuario_vant = usuario_vant.id_usuario', 'left outer ');
            $this->db->group_by($by);
            $this->db->order_by('usuario_vant.id_usuario', 'desc');
            $query = $this->db->get()->result_array();
            return $query;
        }
        
        public function obtener_usuarios_habilitados()
        {   $this->db->select('*');    
            $this->db->from('usuario_vant');     
            return $this->db->get()->result_array();
        }
        
        public function obtener_perfil_por_id($idUsuario)
        {        
            $sql = 'usuario_vant.id_usuario idUsuarioVant, perf.nombre_de_perfil, perf.nombre_de_perfil nombreDePerfil, '.
                   'usuario_vant.usuario, usuario_vant.pass, pers.nombre, pers.apellido, pers.id_persona, '.
                   'pers.email, pers.edad, pers.sexo, pers.id_tipo_documento tipoDoc, pers.nro_documento nroDoc, '.
                   'pers.calle, pers.numero nro, pers.piso, pers.dpto, pers.provincia, pers.localidad, pers.telefono';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('usuario_vant.id_usuario = ', $idUsuario);
            $query = $this->db->get()->row();
            return $query;
        }

        public function obtener_perfil_usuario($usuario, $pass)
        {
            $sql = 'usuario_vant.id_usuario id_usuario, perf.id_perfil, perf.nombre_de_perfil nombreDePerfil, '.
                    'usuario_vant.usuario, usuario_vant.pass, pers.id_persona, pers.nombre, pers.apellido, '.
                    'pers.email, pers.edad, pers.sexo, pers.id_tipo_documento tipoDoc, pers.nro_documento nroDoc, '.
                    'pers.calle, pers.numero nro, pers.piso, pers.dpto, pers.provincia, pers.localidad, pers.telefono';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('usuario_vant.usuario = ', $usuario);
            $query = $this->db->get()->row();
            if (count($query) > 0) {
                    if($query->pass != md5($pass)){
                            throw new Exception("Password invalido");
                    }
                    return $query;
            }else {
                    throw new Exception("Usuario invalido");
            }
        }
        
        public function cambiar_perfil($perfil)
        {        
            $this->db->trans_begin();  
            $this->load->model('Persona_model');
            $perfilModificacion = $this->obtener_perfil_usuario($perfil['usuario'], $perfil['pass']);            
            $perfil["idPersona"] = $perfilModificacion->id_persona;
            $perfil["idPerfil"] = $perfilModificacion->id_perfil;
            $perfil["idUsuarioVant"] = $perfilModificacion->id_usuario;
            $this->Persona_model->modifica_persona($perfil, $perfilModificacion);            
            $this->modificar_perfil($perfil);
            $this->modificar_usuario_vant($perfil);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al modificar los datos del perfil");
            }
            else
            {
                $this->db->trans_commit();
            }
        }
        
        private function guardar_perfil($perfil)
        {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $perfil['fecha_registro'] = date('Y-m-d', time());
            
            $result = $this->db->insert('perfil', [
                'foto' => $perfil["fotoPerfil"],
                'logueado_en_cad' => $perfil['logueadoEnCad'],     
                'nombre_de_perfil' => $perfil["nombreDePerfil"],
                'fecha_registro' => $perfil['fecha_registro']
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        private function modificar_perfil($perfil)
        {
            $this->db->where('id_perfil', $perfil["idPerfil"]);
            $result = $this->db->update('perfil', [
                'logueado_en_cad' => $perfil['logueadoEnCad'],     
                'nombre_de_perfil' => $perfil["nombreDePerfil"]
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            };  
        }

        private function guardar_usuario_vant($usuario)
        {        
            $result = $this->db->insert('usuario_vant', [
                'id_rol' => 1,
                'id_persona' => $usuario["idPersona"],     
                'id_perfil' => $usuario["idPerfil"],    
                'usuario' => $usuario["usuario"],
                'pass' =>  md5($usuario["pass"])
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        private function modificar_usuario_vant($usuario)
        {
            $this->db->where('id_usuario', $usuario["idUsuarioVant"]);
            $result = $this->db->update('usuario_vant', [
                'id_rol' => 1,
                'id_persona' => $usuario["idPersona"],     
                'id_perfil' => $usuario["idPerfil"],    
                'usuario' => $usuario["usuario"],
                'pass' =>  md5($usuario["pass"])
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return;  
        }
        
        public function valida_usuario($id_usuario, $nombreUsuario){
            $user = $this->obtener_perfil_por_id($id_usuario);
            if (count($user) <= 0) {
                throw new Exception("El usuario referenciado no existe en el sistema");               
            }
            
            if(str_replace("@", "", $user->usuario) != $nombreUsuario){
                throw new Exception("Solo puede obtener los datos del usuario enviado");  
            }
            
        }
        
        public function obtener_vants_por_edad($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            
            $sql = 'pers.edad, count(vant.id_usuario_vant) cantidadvant';
            $by = 'pers.edad';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->join('vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('pers.edad', 'asc');
            $query = $this->db->get()->result_array();
            return $query;
        }
        
        public function obtener_vuelos_por_edad($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "vuelo.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "vuelo.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and vuelo.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and vuelo.localidad = " . $localidad;
            }
            
            $sql = 'pers.edad, count(vuelo.id_vuelo) cantidadvant';
            $by = 'pers.edad';
            $this->db->select($sql);
            $this->db->from('vuelo');
            $this->db->join('usuario_vant', 'usuario_vant.id_usuario = vuelo.id_usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('pers.edad', 'asc');
            $query = $this->db->get()->result_array();
            return $query;
        }

        public function obtener_vants_por_sexo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            
            $sql = 'pers.sexo, count(vant.id_usuario_vant) cantidadvant';
            $by = 'pers.sexo';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->join('vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $query = $this->db->get()->result_array();
            return $query;
        }
        
        public function obtener_vuelos_por_sexo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "vuelo.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "vuelo.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and vuelo.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and vuelo.localidad = " . $localidad;
            }
            
            $sql = 'pers.sexo, count(vuelo.id_vuelo) cantidadvant';
            $by = 'pers.sexo';
            $this->db->select($sql);
            $this->db->from('vuelo');
            $this->db->join('usuario_vant', 'usuario_vant.id_usuario = vuelo.id_usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('pers.sexo', 'asc');
            $query = $this->db->get()->result_array();
            return $query;
        }
 
        public function obtener_vants_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            
            $sql = 'localidad.localidad, count(vant.id_usuario_vant) cantidadvant';
            $by = 'localidad.localidad';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->join('vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('localidad', 'localidad.id_localidad = pers.localidad');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $query = $this->db->get()->result_array();
            return $query;
        }
        
        public function obtener_vuelos_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "vuelo.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "vuelo.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and vuelo.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and vuelo.localidad = " . $localidad;
            }
            
            $sql = 'localidad.localidad, count(vuelo.id_vuelo) cantidadvant';
            $by = 'localidad.localidad';
            $this->db->select($sql);
            $this->db->from('vuelo');
            $this->db->join('localidad', 'localidad.id_localidad = vuelo.localidad');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $query = $this->db->get()->result_array();
            return $query;
        }
        
        public function obtener_vants_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            
            $sql = 'provincia.provincia, count(vant.id_usuario_vant) cantidadvant';
            $by = 'provincia.provincia';
            $this->db->select($sql);
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->join('vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('provincia', 'provincia.id_provincia = pers.provincia');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $query = $this->db->get()->result_array();
            return $query;
        }
        
        public function obtener_vuelos_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "vuelo.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "vuelo.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and vuelo.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and vuelo.localidad = " . $localidad;
            }
            
            $sql = 'provincia.provincia, count(vuelo.id_vuelo) cantidadvant';
            $by = 'provincia.provincia';
            $this->db->select($sql);
            $this->db->from('vuelo');
            $this->db->join('provincia', 'provincia.id_provincia = vuelo.provincia');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $query = $this->db->get()->result_array();
            return $query;
        }
        
        public function obtener_vuelos_por_zona($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "vuelo.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "vuelo.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and vuelo.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and vuelo.localidad = " . $localidad;
            }
            $filtro = $filtro . " and vuelo.zona_interes is not null";
            $sql = 'vuelo.zona_interes, count(vuelo.id_vuelo) cantidadvant';
            $by = 'vuelo.zona_interes';
            $this->db->select($sql);
            $this->db->from('vuelo');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $query = $this->db->get()->result_array();
            return $query;
        }
        
    }
?>
