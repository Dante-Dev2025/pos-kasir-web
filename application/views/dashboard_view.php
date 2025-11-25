<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard System</title>
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Kustomisasi scrollbar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- WRAPPER UTAMA -->
    <div class="flex h-screen overflow-hidden">

        <!-- ============================================================== -->
        <!-- SIDEBAR (KIRI) -->
        <!-- ============================================================== -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex md:flex-col justify-between">
            
            <!-- Bagian Atas Sidebar -->
            <div>
                <!-- Logo Area -->
                <div class="h-16 flex items-center px-6 border-b border-gray-100">
                    <div class="flex items-center gap-2 font-bold text-xl text-gray-800">
                        <i class="fa-solid fa-shapes text-indigo-600"></i>
                        <span>MY APP</span>
                    </div>
                </div>

                <!-- Menu Navigasi -->
                <nav class="mt-6 px-4 space-y-2">
                    
                    <!-- 1. Home Link -->
                    <a href="<?php echo site_url('dashboard'); ?>" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg font-medium transition-colors">
                        <i class="fa-solid fa-house w-5 text-center"></i>
                        <span>Home</span>
                    </a>

                    <!-- 2. Self Service Link -->
                    <a href="<?php echo site_url('dashboard/self_service'); ?>" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg font-medium transition-colors">
                        <i class="fa-solid fa-user-gear w-5 text-center"></i>
                        <span>Self Service</span>
                    </a>

                    <!-- 3. Table Link -->
                    <a href="<?php echo site_url('dashboard/table'); ?>" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg font-medium transition-colors">
                        <i class="fa-solid fa-table w-5 text-center"></i>
                        <span>Table</span>
                    </a>

                    <!-- 4. MENU KHUSUS ADMIN (USERS) -->
                    <!-- Hanya tampil jika role user adalah 'admin' -->
                    <?php if($this->session->userdata('role') === 'admin'): ?>
                        
                        <div class="pt-4 pb-2">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin Area</p>
                        </div>

                        <a href="<?php echo site_url('dashboard/users'); ?>" 
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium transition-colors">
                            <i class="fa-solid fa-users-gear w-5 text-center"></i>
                            <span>Kelola Users</span>
                        </a>

                    <?php endif; ?>

                </nav>
            </div>

            <!-- Footer Sidebar (Logout) -->
            <div class="px-4 py-6 border-t border-gray-100">
                <a href="<?php echo site_url('auth/logout'); ?>" class="flex items-center gap-3 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>


        <!-- KONTEN AREA (KANAN) -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- ============================================================== -->
            <!-- NAVBAR (ATAS) -->
            <!-- ============================================================== -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10 shadow-sm">
                
                <!-- Kiri: Info Halaman -->
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-700 hidden md:block">
                        Belajar Pemrograman Web
                    </h1>
                </div>

                <!-- Kanan: Profil User -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1.5 rounded-lg transition">
                        <div class="text-right hidden md:block">
                            <!-- Tampilkan Nama User dari Session -->
                            <p class="text-sm font-semibold text-gray-700">
                                <?php echo $this->session->userdata('name') ? $this->session->userdata('name') : 'User System'; ?>
                            </p>
                            <!-- Tampilkan Role User dari Session -->
                            <p class="text-xs text-gray-500 uppercase">
                                <?php echo $this->session->userdata('role') ? $this->session->userdata('role') : 'Guest'; ?>
                            </p>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                </div>
            </header>


            <!-- ============================================================== -->
            <!-- MAIN CONTENT (DINAMIS DARI CI3) -->
            <!-- ============================================================== -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                
                <!-- Container Putih untuk Konten -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 min-h-[80vh]">
                    
                    <?php
                    // Logika CodeIgniter untuk memuat View Dinamis
                    if (isset($content) && $content !== '') {
                        // Memuat view konten sesuai variabel $content yang dikirim dari Controller
                        $this->load->view($content); 
                    } else {
                        // Tampilan Default jika tidak ada konten yang dipilih
                        echo '
                        <div class="flex flex-col items-center justify-center h-full text-center py-20">
                            <i class="fa-solid fa-laptop-code text-6xl text-indigo-200 mb-4"></i>
                            <h2 class="text-2xl font-bold text-gray-700">Selamat Datang</h2>
                            <p class="text-gray-500 mt-2">Ini adalah area konten belajar pemrograman web.</p>
                            <p class="text-sm text-gray-400 mt-1">Silakan pilih menu di sidebar kiri.</p>
                        </div>
                        ';
                    }
                    ?>

                </div>

            </main>

        </div>
    </div>

</body>
</html>