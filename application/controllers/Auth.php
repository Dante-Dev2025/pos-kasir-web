<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('login_view');
    }

    public function logout()
    {
        // Nanti di sini logika hapus session
        // Redirect kembali ke halaman login
        redirect('auth');
    }
}