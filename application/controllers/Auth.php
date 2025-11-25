<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Memuat Model User, Library Session, dan Helper URL
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // 1. Halaman Login
    public function index()
    {
        // Jika user sudah login, langsung arahkan sesuai role-nya
        if ($this->session->userdata('logged_in')) {
            $this->redirect_based_on_role();
        } else {
            $this->load->view('login_view');
        }
    }

    // 2. Proses Login
    public function process_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Cek user di database lewat Model
        $user = $this->User_model->cek_login($email);

        if ($user) {
            // Verifikasi Password (Hash)
            if (password_verify($password, $user->password)) {
                
                // Jika password benar, simpan data user ke SESSION
                $session_data = [
                    'user_id'   => $user->id,
                    'name'      => $user->name,
                    'email'     => $user->email,
                    'role'      => $user->role, // Penting untuk pemisahan hak akses
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);
                
                // Arahkan ke halaman yang sesuai
                $this->redirect_based_on_role();

            } else {
                // Password salah
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('auth');
            }
        } else {
            // Email tidak ditemukan
            $this->session->set_flashdata('error', 'Email tidak terdaftar!');
            redirect('auth');
        }
    }

    // 3. Fungsi Pengarah Role (Traffic Controller)
    private function redirect_based_on_role()
    {
        $role = $this->session->userdata('role');

        if ($role === 'admin') {
            redirect('dashboard'); // Admin masuk ke Dashboard utama
        } 
        elseif ($role === 'cashier') {
            // Cashier/Kitchen sementara diarahkan ke dashboard juga (agar tidak 404)
            // Nanti Anda bisa ubah ke redirect('kitchen') jika controller Kitchen sudah dibuat
            redirect('dashboard'); 
        } 
        elseif ($role === 'guest') {
            // Guest sementara diarahkan ke dashboard juga (agar tidak 404)
            // Nanti Anda bisa ubah ke redirect('menu') jika controller Menu sudah dibuat
            redirect('dashboard'); 
        } 
        else {
            // Jika role tidak dikenali, logout paksa
            redirect('auth/logout');
        }
    }

    // 4. Halaman Register (Khusus Guest)
    public function register()
    {
        $this->load->view('register_view');
    }

    // 5. Proses Register
    public function process_register()
    {
        $name     = $this->input->post('name');
        $email    = $this->input->post('email');
        $password = $this->input->post('password');

        // Enkripsi Password (Hash)
        $encrypted_password = password_hash($password, PASSWORD_BCRYPT);

        // Siapkan data untuk disimpan
        $data = [
            'name'     => $name,
            'email'    => $email,
            'password' => $encrypted_password,
            'role'     => 'guest' // Default register selalu jadi Guest
        ];

        // Simpan ke database via Model
        if ($this->User_model->register($data)) {
            $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
            redirect('auth');
        } else {
            $this->session->set_flashdata('error', 'Gagal mendaftar. Silakan coba lagi.');
            redirect('auth/register');
        }
    }

    // 6. Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}