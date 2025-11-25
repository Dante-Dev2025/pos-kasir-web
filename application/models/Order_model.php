<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    // Simpan Pesanan Baru (Header + Items)
    public function create_order($order_data, $items_data)
    {
        $this->db->trans_start(); // Mulai Transaksi Database

        // 1. Simpan ke tabel orders
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id(); // Ambil ID pesanan baru

        // 2. Simpan detail item ke tabel order_items
        foreach ($items_data as &$item) {
            $item['order_id'] = $order_id; // Masukkan ID pesanan
        }
        $this->db->insert_batch('order_items', $items_data);

        // 3. Kurangi Stok Produk (Opsional tapi penting)
        foreach ($items_data as $item) {
            $this->db->set('stock', 'stock - ' . $item['qty'], FALSE);
            $this->db->where('id', $item['product_id']);
            $this->db->update('products');
        }

        $this->db->trans_complete(); // Selesai Transaksi

        return $this->db->trans_status(); // Return TRUE jika sukses
    }

    // Ambil Semua Pesanan (Untuk halaman Chef/Admin)
    public function get_all_orders()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('orders');
        return $query->result();
    }

    // Ambil Detail Item per Pesanan (Untuk ditampilkan di kartu pesanan)
    // Menggabungkan nama menu jadi satu string (misal: "2x Burger, 1x Cola")
    public function get_order_items_summary($order_id)
    {
        $this->db->select('product_name, qty');
        $this->db->where('order_id', $order_id);
        $items = $this->db->get('order_items')->result();
        
        $summary = [];
        foreach ($items as $item) {
            $summary[] = $item->qty . 'x ' . $item->product_name;
        }
        return implode(', ', $summary);
    }
}