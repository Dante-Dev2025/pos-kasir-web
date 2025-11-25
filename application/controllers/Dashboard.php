<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load helper URL (Wajib ada agar link tidak error)
        $this->load->helper('url');
    }

    // --- HALAMAN UTAMA ---
    public function index()
    {
        // Konten kosong, nanti muncul pesan "Selamat Datang"
        $data['content'] = ''; 
        $this->load->view('dashboard_view', $data);
    }

    // --- HALAMAN TABEL (Dengan Data Dummy) ---
    public function table()
    {
        // INI DATA DUMMY (Pura-pura dari Database)
        // Kita tulis manual di sini agar tidak perlu konek database dulu
        $data['validasi'] = [
            (object)[
                'id_validasi' => 1,
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'website' => 'budi.com',
                'comment' => 'Website bagus!',
                'gender' => 'Laki-laki'
            ],
            (object)[
                'id_validasi' => 2,
                'name' => 'Siti Aminah',
                'email' => 'siti@yahoo.com',
                'website' => 'siti-art.com',
                'comment' => 'Mohon info harga.',
                'gender' => 'Perempuan'
            ],
            (object)[
                'id_validasi' => 3,
                'name' => 'Joko Anwar',
                'email' => 'joko@film.com',
                'website' => 'jokoanwar.com',
                'comment' => 'Fitur sudah oke.',
                'gender' => 'Laki-laki'
            ]
        ];

        // Kita panggil file view 'table_view' (Lihat kode di bawah)
        $data['content'] = 'table_view';

        $this->load->view('dashboard_view', $data);
    }

    // --- HALAMAN FORM TAMBAH DATA ---
    public function tambah_data()
    {
        // Kita panggil file view 'form_view' (Lihat kode di bawah)
        $data['content'] = 'form_view';
        
        $this->load->view('dashboard_view', $data);
    }

    // --- HALAMAN SELF SERVICE ---
    public function self_service()
    {
        $data['content'] = 'self_service_view';
        
        // Cek dulu filenya ada atau tidak biar tidak error merah
        if (!file_exists(APPPATH . 'views/self_service_view.php')) {
             $data['content'] = ''; 
        }

        $this->load->view('dashboard_view', $data);
    }
}