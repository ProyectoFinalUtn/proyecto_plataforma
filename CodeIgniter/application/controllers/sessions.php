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
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
    }

    public function authenticate()
    {
        //Aviso de Seguridad, a futuro modificar el algoritmo de 
        //hash por otro mas fuerte.        
        $this->load->model('administradorModelo');
        $password = $this->administradorModelo->get_password($this->input->post('nombreUsuario'));
        
        if ($password == md5($this->input->post('password')))
        {
            $this->session->set_userdata('loggedin', true);
            redirect('panel');
        }
        else
        {
            redirect('sessions/login');
        }
        
    }

    public function logout()
    {
        $this->session->unset_userdata('loggedin');
        redirect('/');
    }
}
?>