<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        
        // Cek Login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // 1. ROUTER HALAMAN UTAMA
    // Fungsi ini mengecek role, lalu mengarahkan ke halaman "Home" masing-masing role
    public function index()
    {
        $role = $this->session->userdata('role');

        if ($role == 'admin') {
            $this->stok(); // Admin home-nya adalah Stok
        } elseif ($role == 'cashier') {
            $this->pesanan(); // Cashier home-nya adalah Pesanan
        } else {
            $this->self_service(); // Guest home-nya adalah Self Service
        }
    }

    // 2. HALAMAN PERHITUNGAN STOK (KHUSUS ADMIN)
    public function stok()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard'); // Tendang jika bukan admin
        }

        // Data Dummy Stok
        $data['stok_barang'] = [
            (object)['nama' => 'Daging Burger', 'stok' => 150, 'satuan' => 'Pcs', 'status' => 'Aman'],
            (object)['nama' => 'Roti Bun', 'stok' => 20, 'satuan' => 'Pack', 'status' => 'Menipis'],
            (object)['nama' => 'Keju Slice', 'stok' => 200, 'satuan' => 'Lembar', 'status' => 'Aman'],
            (object)['nama' => 'Saus Tomat', 'stok' => 5, 'satuan' => 'Botol', 'status' => 'Kritis'],
        ];

        $data['page_title'] = 'Perhitungan Stok';
        $data['content'] = 'stok_view'; // Kita buat view ini nanti
        $this->load->view('dashboard_view', $data);
    }

    // 3. HALAMAN PESANAN (ADMIN & CASHIER)
    public function pesanan()
    {
        // Guest tidak boleh masuk sini
        if ($this->session->userdata('role') == 'guest') {
            redirect('dashboard');
        }

        // Data Dummy Pesanan Masuk
        $data['pesanan'] = [
            (object)['id' => '#ORD-001', 'meja' => 'Meja 5', 'menu' => '2x Big Mac, 1x Coke', 'status' => 'Dimasak', 'waktu' => '10:30'],
            (object)['id' => '#ORD-002', 'meja' => 'Meja 2', 'menu' => '1x Chicken Wings', 'status' => 'Siap Saji', 'waktu' => '10:35'],
            (object)['id' => '#ORD-003', 'meja' => 'Takeaway', 'menu' => '3x Sundae Choco', 'status' => 'Pending', 'waktu' => '10:40'],
        ];

        $data['page_title'] = 'Daftar Pesanan Masuk';
        $data['content'] = 'pesanan_view'; // Kita buat view ini nanti
        $this->load->view('dashboard_view', $data);
    }

    // 4. HALAMAN SELF SERVICE (ADMIN & GUEST)
    public function self_service()
    {
        // Cashier tidak perlu masuk sini (karena dia fokus di dapur)
        if ($this->session->userdata('role') == 'cashier') {
            redirect('dashboard');
        }

        // Data Dummy Menu Makanan
        $data['menu_makanan'] = [
            (object)['id'=>1, 'nama'=>'Super Burger', 'harga'=>45000, 'img'=>'fa-burger'],
            (object)['id'=>2, 'nama'=>'French Fries', 'harga'=>25000, 'img'=>'fa-utensils'],
            (object)['id'=>3, 'nama'=>'Cola Dingin', 'harga'=>15000, 'img'=>'fa-glass-water'],
        ];

        $data['page_title'] = 'Self Service Menu';
        $data['content'] = 'self_service_view'; // Kita buat view ini nanti
        $this->load->view('dashboard_view', $data);
    }

    // 5. MANAJEMEN USER (ADMIN ONLY)
    public function users()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }
        $this->load->model('User_model');
        $data['all_users'] = $this->User_model->get_all_users();
        $data['page_title'] = 'Kelola Pengguna';
        $data['content'] = 'users_view';
        $this->load->view('dashboard_view', $data);
    }

    // Helper untuk form update role
    public function change_role() {
        if ($this->session->userdata('role') !== 'admin') redirect('dashboard');
        $this->load->model('User_model');
        $this->User_model->update_role($this->input->post('user_id'), $this->input->post('role'));
        redirect('dashboard/users');
    }
}