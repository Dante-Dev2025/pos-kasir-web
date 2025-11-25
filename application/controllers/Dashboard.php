<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load Helper & Library Wajib
        $this->load->helper('url');
        $this->load->library('session');
        
        // Load Model User (untuk cek role & manajemen user)
        $this->load->model('User_model'); 

        // Proteksi Halaman: Wajib Login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // 1. ROUTER HALAMAN UTAMA (INDEX)
    // Fungsi ini otomatis mengarahkan user ke "Home" mereka masing-masing
    public function index()
    {
        $role = $this->session->userdata('role');

        if ($role == 'admin') {
            $this->stok(); // Admin masuk ke Stok
        } elseif ($role == 'cashier') {
            $this->pesanan(); // Cashier masuk ke Pesanan
        } else {
            $this->self_service(); // Guest masuk ke Self Service
        }
    }

    // 2. HALAMAN PERHITUNGAN STOK (KHUSUS ADMIN)
    public function stok()
    {
        // Keamanan: Hanya Admin yang boleh akses
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        // Load Model Produk
        $this->load->model('Product_model');

        // Ambil semua data produk dari database 'products'
        // Pastikan tabel 'products' sudah memiliki kolom 'stock'
        $data['stok_barang'] = $this->Product_model->get_all_products();

        // Hitung Ringkasan Stok (Summary)
        $data['total_item'] = count($data['stok_barang']);
        $data['stok_kritis'] = 0;

        // Loop untuk menghitung berapa item yang stoknya kritis (<= 10)
        foreach ($data['stok_barang'] as $item) {
            if ($item->stock <= 10) {
                $data['stok_kritis']++;
            }
        }

        $data['page_title'] = 'Perhitungan Stok';
        $data['content'] = 'stok_view'; // Memanggil view stok_view.php
        $this->load->view('dashboard_view', $data);
    }

    // 3. HALAMAN PESANAN (ADMIN & CASHIER)
    public function pesanan()
    {
        // Keamanan: Guest tidak boleh lihat dapur
        if ($this->session->userdata('role') == 'guest') {
            redirect('dashboard');
        }

        // Data Dummy Pesanan Masuk (Simulasi Realtime)
        $data['pesanan'] = [
            (object)['id' => '#ORD-881', 'meja' => 'Meja 5', 'menu' => '2x Big Mac, 1x Coke', 'status' => 'Dimasak', 'waktu' => '10:30'],
            (object)['id' => '#ORD-882', 'meja' => 'Meja 2', 'menu' => '1x Chicken Wings', 'status' => 'Siap Saji', 'waktu' => '10:35'],
            (object)['id' => '#ORD-883', 'meja' => 'Takeaway', 'menu' => '3x Sundae Choco', 'status' => 'Pending', 'waktu' => '10:40'],
        ];

        $data['page_title'] = 'Daftar Pesanan Masuk';
        $data['content'] = 'pesanan_view'; // Memanggil view pesanan_view.php
        $this->load->view('dashboard_view', $data);
    }

    // 4. HALAMAN SELF SERVICE (ADMIN & GUEST)
    public function self_service()
    {
        // Keamanan: Cashier fokus di pesanan, tidak perlu pesan makan
        if ($this->session->userdata('role') == 'cashier') {
            redirect('dashboard');
        }

        // --- INTEGRASI DATABASE PRODUK ---
        $this->load->model('Product_model'); // Load model produk
        
        // Ambil semua data menu dari database 'products'
        $data['menu_makanan'] = $this->Product_model->get_all_products();

        $data['page_title'] = 'Menu Restoran';
        $data['content'] = 'self_service_view'; // Memanggil view self_service_view.php
        $this->load->view('dashboard_view', $data);
    }

    // 5. MANAJEMEN USER (KHUSUS ADMIN)
    public function users()
    {
        // Keamanan: Hanya Admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        // Ambil data semua user lewat User_model
        $data['all_users'] = $this->User_model->get_all_users();
        
        $data['page_title'] = 'Kelola Pengguna';
        $data['content'] = 'users_view'; // Memanggil view users_view.php
        $this->load->view('dashboard_view', $data);
    }

    // Helper: Proses Ganti Role User
    public function change_role() 
    {
        // Keamanan: Hanya Admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        $user_id = $this->input->post('user_id');
        $new_role = $this->input->post('role');

        // Validasi: Admin tidak boleh ubah role sendiri jadi guest (biar gak terkunci)
        if ($user_id == $this->session->userdata('user_id')) {
            echo "<script>alert('Anda tidak bisa mengubah role akun sendiri!'); window.location.href='".site_url('dashboard/users')."';</script>";
            return;
        }

        $this->User_model->update_role($user_id, $new_role);
        redirect('dashboard/users');
    }
}