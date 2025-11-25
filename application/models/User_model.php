<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // Ambil data user berdasarkan email
    public function cek_login($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('users')->row();
    }

    // Registrasi User Baru
    public function register($data)
    {
        return $this->db->insert('users', $data);
    }
}