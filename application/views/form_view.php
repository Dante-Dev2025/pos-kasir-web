<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Input Data Baru</h2>
        <a href="<?php echo site_url('dashboard/table'); ?>" class="text-gray-500 hover:text-gray-700">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form action="#" method="post" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <div class="mt-2 space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="Laki-laki" class="text-indigo-600">
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="Perempuan" class="text-pink-600">
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
            </div>
            <div class="pt-4">
                <button type="button" onclick="alert('Ini hanya demo, data tidak disimpan ke database.')" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>