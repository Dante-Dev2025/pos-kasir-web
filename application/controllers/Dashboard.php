<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load Helper & Library Wajib
        $this->load->helper('url');
        $this->load->library('session');
        
        // Load Semua Model
        $this->load->model('User_model'); 
        $this->load->model('Product_model');
        $this->load->model('Order_model');

        // Proteksi Halaman: Wajib Login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // 1. ROUTER HALAMAN UTAMA (INDEX)
    // Otomatis mengarahkan user ke halaman "Home" masing-masing role
    public function index()
    {
        $role = $this->session->userdata('role');

        if ($role == 'admin') {
            $this->stok(); // Admin -> Stok
        } elseif ($role == 'cashier') {
            $this->pesanan(); // Cashier -> Pesanan
        } else {
            $this->self_service(); // Guest -> Self Service
        }
    }

    // 2. HALAMAN PERHITUNGAN STOK (KHUSUS ADMIN)
    public function stok()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        // Ambil semua data produk
        $data['stok_barang'] = $this->Product_model->get_all_products();

        // Hitung Ringkasan Stok
        $data['total_item'] = count($data['stok_barang']);
        $data['stok_kritis'] = 0;

        foreach ($data['stok_barang'] as $item) {
            if ($item->stock <= 10) {
                $data['stok_kritis']++;
            }
        }

        $data['page_title'] = 'Perhitungan Stok';
        $data['content'] = 'stok_view'; 
        $this->load->view('dashboard_view', $data);
    }

    // 3. HALAMAN PESANAN (ADMIN & CASHIER)
    public function pesanan()
    {
        if ($this->session->userdata('role') == 'guest') {
            redirect('dashboard');
        }

        // Ambil semua order dari database
        $orders = $this->Order_model->get_all_orders();
        
        $data['pesanan'] = [];
        foreach ($orders as $o) {
            $menu_summary = $this->Order_model->get_order_items_summary($o->id);
            
            $data['pesanan'][] = (object)[
                'id' => $o->id,
                'order_number' => $o->order_number,
                'meja' => $o->table_number,
                'menu' => $menu_summary,
                'status' => ucfirst($o->status),
                'waktu' => date('H:i', strtotime($o->created_at)),
                'note' => $o->kitchen_note
            ];
        }

        $data['page_title'] = 'Daftar Pesanan Masuk';
        $data['content'] = 'pesanan_view'; 
        $this->load->view('dashboard_view', $data);
    }

    // 4. HALAMAN SELF SERVICE (ADMIN & GUEST)
    public function self_service()
    {
        if ($this->session->userdata('role') == 'cashier') {
            redirect('dashboard');
        }

        // Ambil menu makanan dari database
        $data['menu_makanan'] = $this->Product_model->get_all_products();

        $data['page_title'] = 'Menu Restoran';
        $data['content'] = 'self_service_view'; 
        $this->load->view('dashboard_view', $data);
    }

    // 5. PROSES CHECKOUT (SIMPAN PESANAN) - VIA AJAX
    public function process_checkout()
    {
        $json = file_get_contents('php://input');
        $req = json_decode($json, true);

        if (!$req) {
            echo json_encode(['status' => 'error', 'message' => 'Data kosong']);
            return;
        }

        // A. Siapkan Data Header Pesanan
        $order_data = [
            'order_number'   => '#ORD-' . rand(1000, 9999),
            'table_number'   => $req['table_number'], // Menerima input meja manual
            'total_price'    => $req['total_price'],
            'payment_method' => $req['payment_method'],
            'kitchen_note'   => $req['note'],
            'status'         => 'pending'
        ];

        // B. Siapkan Data Items
        $items_data = [];
        foreach ($req['items'] as $item) {
            $items_data[] = [
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'qty'          => $item['qty'],
                'price'        => $item['price'],
                'subtotal'     => $item['qty'] * $item['price']
            ];
        }

        // C. Simpan ke Database
        if ($this->Order_model->create_order($order_data, $items_data)) {
            echo json_encode(['status' => 'success', 'order_number' => $order_data['order_number']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesanan']);
        }
    }

    // 6. MANAJEMEN USER (KHUSUS ADMIN)
    public function users()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        $data['all_users'] = $this->User_model->get_all_users();
        $data['page_title'] = 'Kelola Pengguna';
        $data['content'] = 'users_view'; 
        $this->load->view('dashboard_view', $data);
    }

    // Helper: Proses Ganti Role
    public function change_role() 
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        $user_id = $this->input->post('user_id');
        $new_role = $this->input->post('role');

        if ($user_id == $this->session->userdata('user_id')) {
            echo "<script>alert('Anda tidak bisa mengubah role akun sendiri!'); window.location.href='".site_url('dashboard/users')."';</script>";
            return;
        }

        $this->User_model->update_role($user_id, $new_role);
        redirect('dashboard/users');
    }

    // 7. PROSES SIMPAN PRODUK (TAMBAH / EDIT) - VIA AJAX
    public function save_product()
    {
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
            return;
        }

        $id = $this->input->post('id');
        
        $data = [
            'name'      => $this->input->post('name'),
            'category'  => $this->input->post('category'),
            'price'     => $this->input->post('price'),
            'stock'     => $this->input->post('stock'),
            'image_url' => $this->input->post('image_url')
        ];

        if (empty($data['name']) || empty($data['price'])) {
            echo json_encode(['status' => 'error', 'message' => 'Nama dan Harga wajib diisi!']);
            return;
        }

        if (empty($id)) {
            if ($this->Product_model->insert($data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
            }
        } else {
            if ($this->Product_model->update($id, $data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data']);
            }
        }
    }

    // 8. HAPUS PRODUK (VIA AJAX)
    public function delete_product()
    {
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
            return;
        }
        
        $id = $this->input->post('id');
        
        if ($id) {
            if ($this->Product_model->delete($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus database']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID Produk tidak valid']);
        }
    }

    // [BARU] AJAX GET DETAIL PESANAN
    public function get_order_detail($id)
    {
        $order = $this->Order_model->get_order_by_id($id);
        $items = $this->Order_model->get_order_items($id);

        echo json_encode([
            'order' => $order,
            'items' => $items
        ]);
    }

    // [BARU] AJAX COMPLETE ORDER
    public function complete_order()
    {
        $id = $this->input->post('id');
        if ($this->Order_model->update_status($id, 'served')) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // [BARU] HALAMAN RIWAYAT & INCOME (ADMIN ONLY)
    public function riwayat()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        $data['income_today']   = $this->Order_model->get_income_today();
        $data['income_weekly']  = $this->Order_model->get_income_weekly();
        $data['income_monthly'] = $this->Order_model->get_income_monthly();
        $data['riwayat'] = $this->Order_model->get_all_orders();

        $data['page_title'] = 'Riwayat Transaksi';
        $data['content'] = 'riwayat_view'; 
        $this->load->view('dashboard_view', $data);
    }
}