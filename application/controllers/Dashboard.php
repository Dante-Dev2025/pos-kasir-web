<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Memuat Helper dan Library Wajib
        $this->load->helper('url');
        $this->load->library('session');
        
        // Memuat Model yang diperlukan
        $this->load->model('User_model'); 
        $this->load->model('Product_model');
        $this->load->model('Order_model');

        // Proteksi Halaman: Wajib Login
        // Jika session 'logged_in' tidak ada, arahkan ke halaman login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // 1. ROUTER HALAMAN UTAMA (INDEX)
    // Fungsi ini bertugas mengarahkan user ke halaman "Home" mereka masing-masing
    public function index()
    {
        $role = $this->session->userdata('role');

        if ($role == 'admin') {
            $this->stok(); // Admin default ke halaman Stok
        } elseif ($role == 'cashier') {
            $this->pesanan(); // Cashier default ke halaman Pesanan
        } else {
            $this->self_service(); // Guest default ke halaman Self Service
        }
    }

    // 2. HALAMAN PERHITUNGAN STOK (KHUSUS ADMIN)
    public function stok()
    {
        // Keamanan: Hanya Admin yang boleh akses
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        // Ambil semua data produk dari database
        $data['stok_barang'] = $this->Product_model->get_all_products();

        // Hitung Ringkasan Stok (Summary) untuk ditampilkan di kartu atas
        $data['total_item'] = count($data['stok_barang']);
        $data['stok_kritis'] = 0;

        // Loop untuk menghitung item dengan stok kritis (<= 10)
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
        // Keamanan: Guest tidak boleh melihat dapur
        if ($this->session->userdata('role') == 'guest') {
            redirect('dashboard');
        }

        // Mengambil semua data pesanan dari database 'orders'
        $orders = $this->Order_model->get_all_orders();
        
        // Format data agar sesuai dengan tampilan di view pesanan_view.php
        $data['pesanan'] = [];
        foreach ($orders as $o) {
            // Mengambil ringkasan item pesanan (misal: "2x Burger, 1x Cola")
            $menu_summary = $this->Order_model->get_order_items_summary($o->id);
            
            $data['pesanan'][] = (object)[
                'id' => $o->order_number,
                'meja' => $o->table_number,
                'menu' => $menu_summary, // String gabungan item
                'status' => ucfirst($o->status), // Status: Pending, Cooking, dll
                'waktu' => date('H:i', strtotime($o->created_at)),
                'note' => $o->kitchen_note
            ];
        }

        $data['page_title'] = 'Daftar Pesanan Masuk';
        $data['content'] = 'pesanan_view'; // Memanggil view pesanan_view.php
        $this->load->view('dashboard_view', $data);
    }

    // 4. HALAMAN SELF SERVICE (ADMIN & GUEST)
    public function self_service()
    {
        // Keamanan: Cashier fokus di pesanan, tidak perlu memesan
        if ($this->session->userdata('role') == 'cashier') {
            redirect('dashboard');
        }

        // Ambil semua data menu dari database 'products'
        $data['menu_makanan'] = $this->Product_model->get_all_products();

        $data['page_title'] = 'Menu Restoran';
        $data['content'] = 'self_service_view'; // Memanggil view self_service_view.php
        $this->load->view('dashboard_view', $data);
    }

    // 5. PROSES CHECKOUT (SIMPAN PESANAN) - via AJAX
    // Diakses dari self_service_view.php saat tombol checkout ditekan
    public function process_checkout()
    {
        // Menerima data JSON dari Javascript (fetch API)
        $json = file_get_contents('php://input');
        $req = json_decode($json, true);

        if (!$req) {
            echo json_encode(['status' => 'error', 'message' => 'Data kosong']);
            return;
        }

        // A. Siapkan Data Header Pesanan (Tabel orders)
        $order_data = [
            'order_number' => '#ORD-' . rand(1000, 9999), // Generate nomor order acak
            'table_number' => 'Meja 5', // Sementara hardcode, bisa dinamis nanti
            'total_price' => $req['total_price'],
            'payment_method' => $req['payment_method'],
            'kitchen_note' => $req['note'],
            'status' => 'pending'
        ];

        // B. Siapkan Data Detail Items (Tabel order_items)
        $items_data = [];
        foreach ($req['items'] as $item) {
            $items_data[] = [
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['qty'] * $item['price']
            ];
        }

        // C. Simpan ke Database via Model
        // Order_model akan otomatis menyimpan header, items, dan mengurangi stok produk
        if ($this->Order_model->create_order($order_data, $items_data)) {
            echo json_encode(['status' => 'success', 'order_number' => $order_data['order_number']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pesanan']);
        }
    }

    // 6. MANAJEMEN USER (KHUSUS ADMIN)
    public function users()
    {
        // Keamanan: Hanya Admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }

        // Ambil data semua user
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

        // Validasi: Admin tidak boleh mengubah role akun sendiri (mencegah terkunci)
        if ($user_id == $this->session->userdata('user_id')) {
            echo "<script>alert('Anda tidak bisa mengubah role akun sendiri!'); window.location.href='".site_url('dashboard/users')."';</script>";
            return;
        }

        $this->User_model->update_role($user_id, $new_role);
        redirect('dashboard/users');
    }

    // 7. PROSES SIMPAN PRODUK (TAMBAH / EDIT) - via AJAX
    public function save_product()
    {
        // Keamanan: Hanya Admin
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
            return;
        }

        $id = $this->input->post('id'); // Jika kosong = Tambah, Jika ada isi = Edit
        
        $data = [
            'name'      => $this->input->post('name'),
            'category'  => $this->input->post('category'),
            'price'     => $this->input->post('price'),
            'stock'     => $this->input->post('stock'),
            'image_url' => $this->input->post('image_url')
        ];

        // Validasi Sederhana
        if (empty($data['name']) || empty($data['price'])) {
            echo json_encode(['status' => 'error', 'message' => 'Nama dan Harga wajib diisi!']);
            return;
        }

        if (empty($id)) {
            // TAMBAH BARU
            if ($this->Product_model->insert($data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
            }
        } else {
            // EDIT DATA LAMA
            if ($this->Product_model->update($id, $data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data']);
            }
        }
    }

    // 8. HAPUS PRODUK (Via AJAX)
    public function delete_product()
    {
        // Keamanan: Hanya Admin
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
            return;
        }
        
        $id = $this->input->post('id');
        
        if ($id) {
            // Panggil fungsi delete di Model Product
            if ($this->Product_model->delete($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus database']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID Produk tidak valid']);
        }
    }
}