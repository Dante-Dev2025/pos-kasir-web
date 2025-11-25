<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // ... (Kode cek_login dan register yang lama biarkan saja) ...
    public function cek_login($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('users')->row();
    }

    public function register($data)
    {
        return $this->db->insert('users', $data);
    }

    // --- TAMBAHAN BARU DI BAWAH INI ---

    // 1. Ambil semua data user (kecuali password biar aman)
    public function get_all_users()
    {
        $this->db->select('id, name, email, role, created_at');
        return $this->db->get('users')->result();
    }

    // 2. Update Role User
    public function update_role($user_id, $new_role)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['role' => $new_role]);
    }
}