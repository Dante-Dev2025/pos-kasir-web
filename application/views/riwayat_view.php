<!-- BAGIAN ATAS: KARTU STATISTIK INCOME -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Income Hari Ini -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl">
            <i class="fa-solid fa-calendar-day"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Hari Ini</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp <?php echo number_format($income_today, 0, ',', '.'); ?></h3>
        </div>
    </div>

    <!-- Income Minggu Ini -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xl">
            <i class="fa-solid fa-calendar-week"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Minggu Ini</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp <?php echo number_format($income_weekly, 0, ',', '.'); ?></h3>
        </div>
    </div>

    <!-- Income Bulan Ini -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
        <div>
            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Bulan Ini</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp <?php echo number_format($income_monthly, 0, ',', '.'); ?></h3>
        </div>
    </div>
</div>

<!-- BAGIAN BAWAH: TABEL RIWAYAT TRANSAKSI -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Semua Riwayat Transaksi</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">ID Pesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Meja</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Metode</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php foreach($riwayat as $r): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-bold text-indigo-600"><?php echo $r->order_number; ?></td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo date('d M Y H:i', strtotime($r->created_at)); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-800 font-medium"><?php echo $r->table_number; ?></td>
                    <td class="px-6 py-4 text-sm font-bold text-green-600">Rp <?php echo number_format($r->total_price, 0, ',', '.'); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo $r->payment_method; ?></td>
                    <td class="px-6 py-4 text-center">
                        <?php if($r->status == 'served'): ?>
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Selesai</span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">Proses</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>