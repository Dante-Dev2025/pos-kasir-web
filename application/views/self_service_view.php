<div class="max-w-4xl mx-auto">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Self Service</h2>
        <p class="text-gray-500 text-sm">Kelola informasi profil dan pengaturan akun Anda di sini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- KARTU PROFIL KIRI -->
        <div class="col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-3xl font-bold mx-auto mb-4 border-4 border-white shadow-sm">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">User System</h3>
                <p class="text-gray-500 text-sm mb-4">Administrator</p>
                
                <div class="flex justify-center gap-2">
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Aktif</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">Verified</span>
                </div>
            </div>

            <!-- Menu Cepat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 overflow-hidden">
                <div class="p-4 border-b border-gray-100 font-semibold text-sm text-gray-700">Menu Akun</div>
                <div class="flex flex-col">
                    <a href="#" class="px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-indigo-600 flex items-center justify-between transition">
                        <span>Ganti Password</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                    <a href="#" class="px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-indigo-600 flex items-center justify-between transition">
                        <span>Log Aktivitas</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                    <a href="#" class="px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-indigo-600 flex items-center justify-between transition">
                        <span>Pengaturan Notifikasi</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- FORM DETAIL KANAN -->
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4">Edit Profil</h3>
                
                <form action="#" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                            <input type="text" value="User" class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                            <input type="text" value="System" class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="user@system.com" class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50" readonly>
                        <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah secara mandiri.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" value="081234567890" class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bio Singkat</label>
                        <textarea rows="3" class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">Saya adalah administrator sistem ini.</textarea>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="button" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>