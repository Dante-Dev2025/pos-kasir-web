<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load Helper, Library, dan Model yang dibutuhkan
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('User_model'); // Penting: Load Model User

        // Proteksi Halaman: Wajib Login
        // Jika user belum login (tidak ada session), tendang ke halaman auth
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // 1. HALAMAN UTAMA (HOME)
    public function index()
    {
        $data['content'] = ''; 
        $this->load->view('dashboard_view', $data);
    }

    // 2. HALAMAN SELF SERVICE
    public function self_service()
    {
        $data['content'] = 'self_service_view'; 
        
        // Cek file view agar tidak error
        if (!file_exists(APPPATH . 'views/self_service_view.php')) {
            $data['content'] = ''; 
        }

        $this->load->view('dashboard_view', $data);
    }

    // 3. HALAMAN TABEL DATA (Data Dummy)
    public function table()
    {
        // Data Dummy untuk demo tabel
        $data['validasi'] = [
            (object)['id_validasi'=>1, 'name'=>'Budi Santoso', 'email'=>'budi@example.com', 'website'=>'budisantoso.com', 'comment'=>'Clean code.', 'gender'=>'Laki-laki'],
            (object)['id_validasi'=>2, 'name'=>'Siti Aminah', 'email'=>'siti@test.com', 'website'=>'siti-art.id', 'comment'=>'Desain bagus.', 'gender'=>'Perempuan'],
            (object)['id_validasi'=>3, 'name'=>'Joko Anwar', 'email'=>'joko@film.com', 'website'=>'jokoanwar.com', 'comment'=>'Fitur lengkap.', 'gender'=>'Laki-laki'],
            (object)['id_validasi'=>4, 'name'=>'Rina Nose', 'email'=>'rina@tv.com', 'website'=>'rinacomedy.com', 'comment'=>'Warna oke.', 'gender'=>'Perempuan'],
        ];

        $data['content'] = 'table_view';
        $this->load->view('dashboard_view', $data);
    }

    // 4. HALAMAN FORM TAMBAH DATA
    public function tambah_data()
    {
        $data['content'] = 'form_view';
        $this->load->view('dashboard_view', $data);
    }

    // 5. FUNGSI EDIT & HAPUS (Placeholder)
    public function edit($id = null)
    {
        $data['content'] = 'form_view';
        $this->load->view('dashboard_view', $data);
    }

    public function hapus($id = null)
    {
        redirect('dashboard/table');
    }

    // =========================================================================
    // FITUR BARU: MANAJEMEN USER (KHUSUS ADMIN)
    // =========================================================================

    // 6. Halaman List User
    public function users()
    {
        // KEAMANAN: Cek apakah yang login adalah Admin?
        // Jika bukan admin (misal cashier/guest), kembalikan ke dashboard utama
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        // Ambil semua data user dari database menggunakan Model
        $data['all_users'] = $this->User_model->get_all_users();
        
        // Muat view 'users_view' di bagian konten tengah
        $data['content'] = 'users_view';
        $this->load->view('dashboard_view', $data);
    }

    // 7. Proses Ganti Role (Action Form)
    public function change_role()
    {
        // KEAMANAN: Cek Admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        // Ambil data dari form (users_view.php)
        $user_id = $this->input->post('user_id');
        $new_role = $this->input->post('role');

        // VALIDASI: Admin tidak boleh mengubah role dirinya sendiri
        // Ini untuk mencegah Admin tidak sengaja mengubah dirinya jadi Guest dan terkunci
        if ($user_id == $this->session->userdata('user_id')) {
            echo "<script>alert('Anda tidak bisa mengubah role akun sendiri!'); window.location.href='".site_url('dashboard/users')."';</script>";
            return;
        }

        // Panggil Model untuk update role di database
        $this->User_model->update_role($user_id, $new_role);
        
        // Redirect kembali ke halaman list user
        redirect('dashboard/users');
    }
}