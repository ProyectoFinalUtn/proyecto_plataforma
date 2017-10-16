<?php

class Sessions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function login()
    {
        //$this->load->view('header');
        if(!isset($_SESSION['usuario'])) {
            $this->load->view('Login');
        } else {
            redirect('Panel');
        }
        
        //$this->load->view('footer');
    }

    public function authenticate()
    {
        //Aviso de Seguridad, a futuro modificar el algoritmo de 
        //hash por otro mas fuerte.        
        $this->load->model('Administrador_model');
        $password = $this->Administrador_model->get_password($this->input->post('nombreUsuario'));
        $activo = $this->Administrador_model->usuario_activo($this->input->post('nombreUsuario'));
        
        if (($password == md5($this->input->post('password'))) && ($activo == 't'))
        {
            $this->session->set_userdata('loggedin', true);
            session_start();
            $_SESSION['usuario'] = $this->input->post('nombreUsuario');
            $idUsuarioAdmin = $this->Administrador_model->obtener_id_admin($this->input->post('nombreUsuario'));
            $_SESSION['idUsuarioAdmin'] = $idUsuarioAdmin->id_usuario;
            redirect('Panel');
        }
        else
        {
            $data['falla'] = true;
            $this->load->view('Login', $data);
            //redirect('Sessions/login', $data);
        }
        
    }

    public function logout()
    {
        $this->session->unset_userdata('loggedin');
        session_destroy();
        redirect('Sessions/login');
    }
}
?>
