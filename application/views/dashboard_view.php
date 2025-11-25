<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$role = $this->session->userdata('role'); // Ambil role user dari session
$name = $this->session->userdata('name'); // Ambil nama user
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Restoran</title>
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen overflow-hidden">

        <!-- ============================================================== -->
        <!-- SIDEBAR (KIRI) -->
        <!-- ============================================================== -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex md:flex-col justify-between">
            
            <div>
                <!-- Logo Area -->
                <div class="h-16 flex items-center px-6 border-b border-gray-100">
                    <div class="flex items-center gap-2 font-bold text-xl text-gray-800">
                        <i class="fa-solid fa-burger text-indigo-600"></i>
                        <span>RESTO APP</span>
                    </div>
                </div>

                <!-- Menu Navigasi Berdasarkan Role -->
                <nav class="mt-6 px-4 space-y-2">
                    
                    <!-- =================================================== -->
                    <!-- 1. MENU KHUSUS ADMIN (Owner) -->
                    <!-- =================================================== -->
                    <?php if($role === 'admin'): ?>
                        <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Owner Menu</div>

                        <!-- Perhitungan Stok (Home diubah jadi Stok) -->
                        <a href="<?php echo site_url('dashboard/stok'); ?>" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg font-medium transition-colors">
                            <i class="fa-solid fa-boxes-stacked w-5 text-center"></i>
                            <span>Perhitungan Stok</span>
                        </a>

                        <!-- Self Service (Mode Edit) -->
                        <a href="<?php echo site_url('dashboard/self_service'); ?>" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg font-medium transition-colors">
                            <i class="fa-solid fa-utensils w-5 text-center"></i>
                            <span>Menu Makanan</span>
                        </a>

                        <!-- Pesanan (Table diubah jadi Pesanan) -->
                        <a href="<?php echo site_url('dashboard/pesanan'); ?>" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg font-medium transition-colors">
                            <i class="fa-solid fa-receipt w-5 text-center"></i>
                            <span>Detail Pesanan</span>
                        </a>

                        <!-- Kelola Users (Tambahan Admin) -->
                        <div class="pt-4 mt-4 border-t border-gray-100">
                            <a href="<?php echo site_url('dashboard/users'); ?>" 
                               class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium transition-colors">
                                <i class="fa-solid fa-users-gear w-5 text-center"></i>
                                <span>Kelola Users</span>
                            </a>
                        </div>
                    <?php endif; ?>


                    <!-- =================================================== -->
                    <!-- 2. MENU KHUSUS CASHIER (Kitchen) -->
                    <!-- =================================================== -->
                    <?php if($role === 'cashier'): ?>
                        <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Dapur</div>

                        <!-- Hanya Menampilkan Pesanan -->
                        <a href="<?php echo site_url('dashboard/pesanan'); ?>" 
                           class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-600 rounded-lg font-medium transition-colors border border-indigo-100">
                            <i class="fa-solid fa-bell-concierge w-5 text-center"></i>
                            <span>Pesanan Masuk</span>
                        </a>
                    <?php endif; ?>


                    <!-- =================================================== -->
                    <!-- 3. MENU KHUSUS GUEST (Pelanggan) -->
                    <!-- =================================================== -->
                    <?php if($role === 'guest'): ?>
                        <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Pelanggan</div>

                        <!-- Hanya Self Service (Pesan Makanan) -->
                        <a href="<?php echo site_url('dashboard/self_service'); ?>" 
                           class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-600 rounded-lg font-medium transition-colors border border-indigo-100">
                            <i class="fa-solid fa-basket-shopping w-5 text-center"></i>
                            <span>Pesan Makanan</span>
                        </a>
                    <?php endif; ?>

                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="px-4 py-6 border-t border-gray-100">
                <a href="<?php echo site_url('auth/logout'); ?>" class="flex items-center gap-3 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </aside>


        <!-- ============================================================== -->
        <!-- KONTEN AREA (KANAN) -->
        <!-- ============================================================== -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Navbar Atas -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10 shadow-sm">
                
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <!-- Menampilkan Judul Halaman Dinamis -->
                    <h1 class="text-lg font-semibold text-gray-700 hidden md:block">
                        <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?>
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1.5 rounded-lg transition">
                        <div class="text-right hidden md:block">
                            <!-- Menampilkan Nama User -->
                            <p class="text-sm font-bold text-gray-800">
                                <?php echo $name ? $name : 'User System'; ?>
                            </p>
                            <!-- Menampilkan Role User dengan Badge -->
                            <p class="text-xs text-indigo-600 font-semibold uppercase tracking-wide border border-indigo-200 bg-indigo-50 px-2 py-0.5 rounded-full inline-block mt-0.5">
                                <?php echo $role ? $role : 'Guest'; ?>
                            </p>
                        </div>
                        <!-- Avatar Inisial Nama -->
                        <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                            <?php echo $name ? substr($name, 0, 1) : 'U'; ?>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Dinamis -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <!-- Konten Dimuat di Sini -->
                <?php
                if (isset($content) && $content !== '') {
                    $this->load->view($content); 
                } else {
                    // Fallback jika konten kosong
                    echo '<div class="text-center text-gray-500 mt-10">Memuat halaman...</div>';
                }
                ?>
            </main>

        </div>
    </div>

</body>
</html>