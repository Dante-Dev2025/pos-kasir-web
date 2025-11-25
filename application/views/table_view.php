<div class="space-y-6">
    <!-- Judul & Tombol Tambah -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Data Validasi</h2>
        <a href="<?php echo site_url('dashboard/tambah_data'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            + Tambah Data
        </a>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php 
                $no = 1;
                // Cek apakah ada data dummy yang dikirim
                if(isset($validasi) && !empty($validasi)) {
                    foreach($validasi as $m) { ?>
                    <tr>
                        <td class="px-6 py-4"><?php echo $no++; ?></td>
                        <td class="px-6 py-4 font-medium text-gray-900"><?php echo $m->name; ?></td>
                        <td class="px-6 py-4 text-gray-500"><?php echo $m->email; ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs <?php echo ($m->gender == 'Laki-laki') ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'; ?>">
                                <?php echo $m->gender; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-indigo-600 cursor-pointer hover:underline">Edit | Hapus</td>
                    </tr>
                <?php } 
                } else { ?>
                    <tr><td colspan="5" class="text-center py-4">Tidak ada data.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>