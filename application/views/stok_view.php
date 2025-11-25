<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <!-- Summary Cards -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <p class="text-gray-500 text-xs">Total Item</p>
        <p class="text-2xl font-bold text-gray-800">24</p>
    </div>
    <div class="bg-red-50 p-4 rounded-xl shadow-sm border border-red-100">
        <p class="text-red-500 text-xs">Stok Kritis</p>
        <p class="text-2xl font-bold text-red-600">2</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Laporan Stok Bahan Baku</h3>
        <button class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">+ Tambah Stok</button>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Bahan</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Jumlah Stok</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Satuan</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php foreach($stok_barang as $item): ?>
            <tr>
                <td class="px-6 py-4 font-medium text-gray-900"><?php echo $item->nama; ?></td>
                <td class="px-6 py-4 text-gray-600"><?php echo $item->stok; ?></td>
                <td class="px-6 py-4 text-gray-500"><?php echo $item->satuan; ?></td>
                <td class="px-6 py-4">
                    <?php if($item->status == 'Aman'): ?>
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Aman</span>
                    <?php elseif($item->status == 'Menipis'): ?>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menipis</span>
                    <?php else: ?>
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Kritis</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="#" class="text-indigo-600 hover:underline text-sm">Update</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>