<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    // Simpan Pesanan Baru
    public function create_order($order_data, $items_data)
    {
        $this->db->trans_start();
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        foreach ($items_data as &$item) {
            $item['order_id'] = $order_id;
        }
        $this->db->insert_batch('order_items', $items_data);

        // Kurangi Stok
        foreach ($items_data as $item) {
            $this->db->set('stock', 'stock - ' . $item['qty'], FALSE);
            $this->db->where('id', $item['product_id']);
            $this->db->update('products');
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Ambil Semua Pesanan (Bisa difilter status)
    public function get_all_orders($status = null)
    {
        $this->db->order_by('created_at', 'DESC');
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->get('orders')->result();
    }

    // Ambil Satu Pesanan Detail (Header)
    public function get_order_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('orders')->row();
    }

    // Ambil Item Pesanan (Detail)
    public function get_order_items($order_id)
    {
        $this->db->where('order_id', $order_id);
        return $this->db->get('order_items')->result();
    }

    // Helper: Ringkasan Menu string
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

    // Update Status Pesanan (misal: pending -> served)
    public function update_status($order_id, $status)
    {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', ['status' => $status]);
    }

    // --- STATISTIK KEUANGAN ---

    // Hitung Income Hari Ini
    public function get_income_today()
    {
        $this->db->select_sum('total_price');
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $result = $this->db->get('orders')->row();
        return $result->total_price ?? 0;
    }

    // Hitung Income Minggu Ini
    public function get_income_weekly()
    {
        $this->db->select_sum('total_price');
        $this->db->where('YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)');
        $result = $this->db->get('orders')->row();
        return $result->total_price ?? 0;
    }

    // Hitung Income Bulan Ini
    public function get_income_monthly()
    {
        $this->db->select_sum('total_price');
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $result = $this->db->get('orders')->row();
        return $result->total_price ?? 0;
    }
}