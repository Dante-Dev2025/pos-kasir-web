<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // ... (Fungsi index, process_login, redirect_based_on_role, register, process_register BIARKAN SAMA) ...
    // Copy paste kode lama atau biarkan yang lama, lalu tambahkan fungsi di bawah ini:

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $this->redirect_based_on_role();
        } else {
            $this->load->view('login_view');
        }
    }

    public function process_login() {
        // ... (Isi sesuai kode sebelumnya) ...
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->User_model->cek_login($email);
        if ($user) {
            if (password_verify($password, $user->password)) {
                $session_data = [ 'user_id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role, 'logged_in' => TRUE ];
                $this->session->set_userdata($session_data);
                $this->redirect_based_on_role();
            } else {
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Email tidak terdaftar!');
            redirect('auth');
        }
    }

    private function redirect_based_on_role() {
        $role = $this->session->userdata('role');
        if ($role === 'admin' || $role === 'cashier' || $role === 'guest') {
            redirect('dashboard');
        } else {
            redirect('auth/logout');
        }
    }

    public function register() {
        $this->load->view('register_view');
    }

    public function process_register() {
        // ... (Isi sesuai kode sebelumnya) ...
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $encrypted_password = password_hash($password, PASSWORD_BCRYPT);
        $data = [ 'name' => $name, 'email' => $email, 'password' => $encrypted_password, 'role' => 'guest' ];
        if ($this->User_model->register($data)) {
            $this->session->set_flashdata('success', 'Akun berhasil dibuat! Silakan login.');
            redirect('auth');
        } else {
            $this->session->set_flashdata('error', 'Gagal mendaftar.');
            redirect('auth/register');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    // =========================================================
    // [BARU] FITUR LUPA PASSWORD
    // =========================================================

    // 1. Halaman Masukkan Email
    public function forgot_password()
    {
        $this->load->view('forgot_password_view');
    }

    // 2. Cek Email & Arahkan ke Form Reset
    public function verify_reset()
    {
        $email = $this->input->post('email');
        
        // Cek apakah email ada di database
        $user = $this->User_model->cek_login($email);

        if ($user) {
            // Jika ada, tampilkan halaman ganti password
            // Kita kirim email ke view agar bisa dipakai untuk update
            $data['email_found'] = $email;
            $this->load->view('reset_password_view', $data);
        } else {
            // Jika tidak ada, kembali ke halaman lupa password
            $this->session->set_flashdata('error', 'Email tidak ditemukan dalam sistem.');
            redirect('auth/forgot_password');
        }
    }

    // 3. Proses Simpan Password Baru
    public function process_reset_password()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Enkripsi password baru
        $new_hash = password_hash($password, PASSWORD_BCRYPT);

        // Update di database
        if ($this->User_model->update_password($email, $new_hash)) {
            $this->session->set_flashdata('success', 'Password berhasil diubah! Silakan login dengan password baru.');
            redirect('auth');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah password.');
            redirect('auth/forgot_password');
        }
    }
}