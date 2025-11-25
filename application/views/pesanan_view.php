<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach($pesanan as $p): ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
        <!-- Header Kartu: Warna beda berdasarkan status -->
        <div class="px-6 py-4 <?php echo ($p->status == 'Dimasak' ? 'bg-orange-50 border-b border-orange-100' : 'bg-green-50 border-b border-green-100'); ?> flex justify-between items-center">
            <span class="font-bold text-gray-700"><?php echo $p->meja; ?></span>
            <span class="text-xs font-semibold px-2 py-1 rounded bg-white border opacity-80"><?php echo $p->waktu; ?></span>
        </div>
        
        <div class="p-6">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">ID Pesanan: <?php echo $p->id; ?></p>
            <h4 class="text-lg font-bold text-gray-800 mb-4"><?php echo $p->menu; ?></h4>
            
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium px-3 py-1 rounded-full <?php echo ($p->status == 'Dimasak' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700'); ?>">
                    <?php echo $p->status; ?>
                </span>
                
                <!-- Tombol Aksi (Hanya muncul jika bukan Guest) -->
                <button class="bg-gray-800 text-white text-xs px-3 py-2 rounded hover:bg-black transition">
                    Lihat Detail
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>