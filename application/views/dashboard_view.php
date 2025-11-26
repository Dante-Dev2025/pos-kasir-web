<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$role = $this->session->userdata('role');
$name = $this->session->userdata('name');
$email = $this->session->userdata('email'); 
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Restoran</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Wrapper Utama -->
    <div class="flex h-screen overflow-hidden relative">

        <!-- SIDEBAR (Z-Index 30) -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex md:flex-col justify-between flex-shrink-0 z-30 relative">
            <div>
                <div class="h-16 flex items-center px-6 border-b border-gray-100">
                    <div class="flex items-center gap-2 font-bold text-xl text-gray-800">
                        <i class="fa-solid fa-burger text-indigo-600"></i>
                        <span>RESTO APP</span>
                    </div>
                </div>

                <nav class="mt-6 px-4 space-y-2">
                    <?php if($role === 'admin'): ?>
                        <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Owner Menu</div>
                        <a href="<?php echo site_url('dashboard/stok'); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl font-medium transition-colors">
                            <i class="fa-solid fa-boxes-stacked w-5 text-center"></i> <span>Perhitungan Stok</span>
                        </a>
                        <a href="<?php echo site_url('dashboard/riwayat'); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl font-medium transition-colors">
                            <i class="fa-solid fa-chart-line w-5 text-center"></i> <span>Riwayat & Income</span>
                        </a>
                        <a href="<?php echo site_url('dashboard/self_service'); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl font-medium transition-colors">
                            <i class="fa-solid fa-utensils w-5 text-center"></i> <span>Menu Makanan</span>
                        </a>
                        <a href="<?php echo site_url('dashboard/pesanan'); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl font-medium transition-colors">
                            <i class="fa-solid fa-receipt w-5 text-center"></i> <span>Detail Pesanan</span>
                        </a>
                        <div class="pt-4 mt-4 border-t border-gray-100">
                            <a href="<?php echo site_url('dashboard/users'); ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl font-medium transition-colors">
                                <i class="fa-solid fa-users-gear w-5 text-center"></i> <span>Kelola Users</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if($role === 'cashier'): ?>
                        <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Dapur</div>
                        <a href="<?php echo site_url('dashboard/pesanan'); ?>" class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-600 rounded-xl font-medium transition-colors border border-indigo-100">
                            <i class="fa-solid fa-bell-concierge w-5 text-center"></i> <span>Pesanan Masuk</span>
                        </a>
                    <?php endif; ?>

                    <?php if($role === 'guest'): ?>
                        <div class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Pelanggan</div>
                        <a href="<?php echo site_url('dashboard/self_service'); ?>" class="flex items-center gap-3 px-4 py-3 bg-indigo-50 text-indigo-600 rounded-xl font-medium transition-colors border border-indigo-100">
                            <i class="fa-solid fa-basket-shopping w-5 text-center"></i> <span>Pesan Makanan</span>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
            
            <div class="px-4 py-6 border-t border-gray-100">
                <a href="<?php echo site_url('auth/logout'); ?>" class="flex items-center gap-3 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- KONTEN (Header ada di sini) -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <!-- HEADER: Z-INDEX HARUS LEBIH TINGGI DARI SIDEBAR & KONTEN BAWAH (z-50) -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-50 shadow-sm flex-shrink-0 relative">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-bold text-gray-800 hidden md:block tracking-tight">
                        <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?>
                    </h1>
                </div>

                <!-- BAGIAN PROFIL -->
                <div class="relative flex items-center gap-3">
                    
                    <!-- Info Nama & Role (Tampil di Luar) -->
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-bold text-gray-800 leading-tight">
                            <?php echo $name ? $name : 'User System'; ?>
                        </div>
                        <div class="mt-0.5">
                            <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide border
                                <?php 
                                    if($role == 'admin') echo 'bg-indigo-50 text-indigo-600 border-indigo-100';
                                    elseif($role == 'cashier') echo 'bg-blue-50 text-blue-600 border-blue-100';
                                    else echo 'bg-green-50 text-green-600 border-green-100';
                                ?>">
                                <?php echo $role ? $role : 'Guest'; ?>
                            </span>
                        </div>
                    </div>

                    <!-- Avatar Button (Trigger) -->
                    <button onclick="toggleProfilePopup()" id="profile-trigger" class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white font-bold text-lg shadow-md hover:shadow-lg hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500 transition focus:outline-none cursor-pointer relative z-50">
                        <?php echo $name ? substr($name, 0, 1) : 'U'; ?>
                    </button>

                    <!-- POPUP KARTU PROFIL (Absolute, Z-Index Tertinggi) -->
                    <div id="profile-popup" class="hidden absolute right-0 top-full mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 z-[100] transform origin-top-right transition-all duration-200 animate-scale-in">
                        
                        <!-- Segitiga Kecil di Atas -->
                        <div class="absolute -top-2 right-3 w-4 h-4 bg-white transform rotate-45 border-t border-l border-gray-100"></div>

                        <div class="p-6 flex flex-col items-center text-center relative z-10 bg-white rounded-2xl">
                            
                            <!-- Avatar Besar -->
                            <div class="w-20 h-20 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-3xl font-bold border-4 border-white shadow-lg mb-3">
                                <?php echo $name ? substr($name, 0, 1) : 'U'; ?>
                            </div>

                            <!-- Nama -->
                            <h3 class="text-lg font-bold text-gray-800 leading-tight mb-1 w-full truncate">
                                <?php echo $name ? $name : 'User System'; ?>
                            </h3>

                            <!-- Email -->
                            <p class="text-xs text-gray-500 font-medium mb-4 w-full truncate">
                                <?php echo $email ? $email : 'user@example.com'; ?>
                            </p>

                            <!-- Role Badge -->
                            <div class="mb-6">
                                <span class="px-6 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider border 
                                    <?php 
                                        if($role == 'admin') echo 'bg-red-50 text-red-600 border-red-100';
                                        elseif($role == 'cashier') echo 'bg-blue-50 text-blue-600 border-blue-100';
                                        else echo 'bg-green-50 text-green-600 border-green-100';
                                    ?>">
                                    <?php echo $role ? $role : 'Guest'; ?>
                                </span>
                            </div>

                            <!-- Tombol Keluar -->
                            <a href="<?php echo site_url('auth/logout'); ?>" class="text-sm font-bold text-gray-400 hover:text-red-600 transition flex items-center gap-2 py-2 px-4 rounded-lg hover:bg-red-50 w-full justify-center border border-transparent hover:border-red-100">
                                <span>Keluar Aplikasi</span>
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </a>

                        </div>
                    </div>

                </div>
            </header>

            <!-- Main Content -->
            <!-- z-0 Agar selalu di bawah header -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 z-0 relative">
                <?php
                if (isset($content) && $content !== '') {
                    $this->load->view($content); 
                } else {
                    echo '<div class="text-center text-gray-500 mt-10">Memuat halaman...</div>';
                }
                ?>
            </main>
        </div>
    </div>

    <script>
        function toggleProfilePopup() {
            const popup = document.getElementById('profile-popup');
            popup.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const btn = document.getElementById('profile-trigger');
            const popup = document.getElementById('profile-popup');
            
            // Cek jika klik bukan di tombol DAN bukan di dalam popup
            if (!btn.contains(e.target) && !popup.contains(e.target)) {
                popup.classList.add('hidden');
            }
        });
    </script>

    <style>
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95) translateY(-10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-scale-in {
            animation: scaleIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>

</body>
</html>