<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My App</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center p-4">

    <!-- Card Container -->
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl overflow-hidden flex h-[600px]">
        
        <!-- BAGIAN KIRI: Form Login -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center relative">
            
            <div class="mb-8">
                <div class="flex items-center gap-2 font-bold text-2xl text-indigo-600 mb-2">
                    <i class="fa-solid fa-shapes"></i>
                    <span>MY APP</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Selamat Datang Kembali</h1>
                <p class="text-gray-500 mt-2">Silakan masukkan detail akun Anda.</p>
            </div>

            <!-- Form Login -->
            <!-- Action mengarah ke Dashboard agar Anda bisa langsung mencoba klik -->
            <form action="<?php echo site_url('dashboard'); ?>" method="get" class="space-y-5">
                
                <!-- Input Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="email" name="email" placeholder="contoh@email.com" 
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm" required>
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" 
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm" required>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Lupa Password?</a>
                </div>

                <!-- Button Login -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>

            </form>

            <div class="mt-8 text-center text-sm text-gray-500">
                Belum punya akun? 
                <a href="#" class="text-indigo-600 font-semibold hover:underline">Daftar di sini</a>
            </div>

            <div class="mt-auto pt-6 text-center text-xs text-gray-400">
                &copy; 2024 My App System. All rights reserved.
            </div>
        </div>

        <!-- BAGIAN KANAN: Gambar / Banner -->
        <div class="hidden md:block w-1/2 bg-indigo-600 relative overflow-hidden">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                 alt="Office Background" 
                 class="absolute inset-0 w-full h-full object-cover opacity-50 mix-blend-multiply">
            
            <!-- Overlay Content -->
            <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-12 text-center z-10">
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl mb-6 inline-block">
                    <i class="fa-solid fa-chart-pie text-4xl"></i>
                </div>
                <h2 class="text-3xl font-bold mb-4">Kelola Data Anda Lebih Mudah</h2>
                <p class="text-indigo-100 text-lg leading-relaxed">
                    Bergabunglah dengan kami dan nikmati kemudahan mengelola manajemen data dalam satu dashboard terintegrasi.
                </p>

                <!-- Dekorasi lingkaran -->
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            </div>
        </div>

    </div>

</body>
</html>