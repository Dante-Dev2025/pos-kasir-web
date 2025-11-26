<!-- Grid Kartu Pesanan -->
<?php if(empty($pesanan)): ?>
    <div class="text-center py-20 text-gray-400">
        <i class="fa-solid fa-bell-slash text-6xl mb-4 opacity-20"></i>
        <p class="text-lg font-medium">Belum ada pesanan masuk saat ini.</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($pesanan as $p): ?>
        
        <!-- LOGIKA DETEKSI NOMOR MEJA -->
        <?php 
            $meja_display = $p->meja;
            if (ctype_digit((string)$p->meja)) {
                $meja_display = "Meja " . $p->meja;
            }
        ?>

        <!-- LOGIKA TAMPILAN TOMBOL & STATUS -->
        <?php 
            $status_lower = strtolower($p->status);
            
            // Default Style (Proses)
            $status_bg = 'bg-gray-100 text-gray-600';
            $btn_color = 'bg-indigo-600 hover:bg-indigo-700';
            $btn_text = 'Lihat Detail / Selesai';
            $btn_icon = 'fa-arrow-right';

            if($status_lower == 'pending') {
                $status_bg = 'bg-orange-100 text-orange-700';
            } elseif($status_lower == 'cooking' || $status_lower == 'dimasak') {
                $status_bg = 'bg-blue-100 text-blue-700';
            } elseif($status_lower == 'served' || $status_lower == 'selesai') {
                // Jika Selesai: Ubah Badge & Tombol jadi Hijau
                $status_bg = 'bg-green-100 text-green-700';
                $btn_color = 'bg-green-600 hover:bg-green-700';
                $btn_text = 'Pesanan Selesai';
                $btn_icon = 'fa-check';
            }
        ?>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col h-full">
            
            <!-- Header Kartu -->
            <div class="p-5 border-b border-gray-50 bg-white">
                <div class="flex justify-between items-start mb-1">
                    <!-- Nomor Meja Besar -->
                    <h3 class="text-2xl font-bold text-gray-900"><?php echo $meja_display; ?></h3>
                    
                    <!-- Badge Status -->
                    <span class="text-xs font-bold px-2 py-1 rounded uppercase tracking-wider <?php echo $status_bg; ?>">
                        <?php echo $p->status; ?>
                    </span>
                </div>
                
                <div class="flex justify-between items-center text-xs text-gray-400 font-medium mt-1">
                    <span><?php echo $p->order_number; ?></span>
                    <span class="flex items-center gap-1"><i class="fa-regular fa-clock"></i> <?php echo $p->waktu; ?></span>
                </div>
            </div>
            
            <!-- Konten Menu -->
            <div class="p-5 flex-1 bg-white">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Ringkasan Menu</p>
                
                <div class="text-gray-800 font-medium text-sm leading-relaxed">
                    <?php echo $p->menu; ?>
                </div>

                <!-- Catatan (Preview di Kartu Depan) -->
                <?php if(!empty($p->note)): ?>
                    <div class="mt-4 bg-red-50 p-3 rounded-lg border border-red-100 text-xs text-red-600 font-medium flex items-start gap-2">
                        <i class="fa-solid fa-note-sticky mt-0.5 text-red-400 flex-shrink-0"></i> 
                        <span class="line-clamp-1 break-all"><?php echo $p->note; ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer Tombol (Dinamis Sesuai Status) -->
            <div class="p-4 border-t border-gray-100">
                <button onclick="openDetailModal(<?php echo $p->id; ?>)" class="w-full <?php echo $btn_color; ?> text-white px-4 py-3 rounded-lg text-sm font-bold transition shadow-sm flex justify-center items-center gap-2">
                    <span><?php echo $btn_text; ?></span>
                    <i class="fa-solid <?php echo $btn_icon; ?>"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<!-- MODAL DETAIL PESANAN & SELESAIKAN -->
<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closeDetailModal()"></div>

    <div class="flex items-center justify-center min-h-screen px-4 py-4">
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl transform transition-all max-w-lg w-full my-8">
            
            <!-- Header Modal -->
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white" id="modal-order-id">Detail Pesanan</h3>
                <button onclick="closeDetailModal()" class="text-indigo-200 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Isi Modal -->
            <div class="p-6">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold">Meja</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="modal-table">Loading...</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-xs uppercase font-bold">Total Harga</p>
                        <p class="text-xl font-bold text-indigo-600 mt-1" id="modal-total">Rp 0</p>
                    </div>
                </div>

                <!-- Daftar Item -->
                <h4 class="text-xs font-bold text-gray-500 uppercase mb-3 tracking-wider">Daftar Item</h4>
                <div id="modal-items-list" class="space-y-3 mb-6 bg-gray-50 p-4 rounded-xl max-h-60 overflow-y-auto border border-gray-100">
                    <!-- Item akan diisi via JS -->
                </div>

                <!-- BAGIAN NOTES / CATATAN (UPDATED) -->
                <div id="modal-note-container" class="hidden mb-6">
                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-message"></i> Catatan Pelanggan
                    </h4>
                    <!-- break-words dan whitespace-pre-wrap agar text panjang turun ke bawah -->
                    <div class="bg-yellow-50 border border-yellow-100 p-4 rounded-xl text-sm text-yellow-800 italic font-medium flex items-start gap-3">
                        <i class="fa-solid fa-quote-left text-yellow-400 text-lg flex-shrink-0 mt-1"></i>
                        <span id="modal-note-text" class="break-words w-full whitespace-pre-wrap"></span>
                    </div>
                </div>

                <!-- Tombol Selesaikan -->
                <input type="hidden" id="hidden-order-id">
                <!-- Tombol ini akan disembunyikan lewat JS jika status sudah served -->
                <button id="btn-complete-order" onclick="completeOrder()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl text-lg shadow-lg shadow-green-100 transition transform active:scale-95 flex justify-center items-center gap-2">
                    <span>Pesanan Selesai / Disajikan</span>
                    <i class="fa-solid fa-check-circle"></i>
                </button>
                
                <!-- Status Text Jika Sudah Selesai -->
                <div id="status-served-msg" class="hidden text-center p-4 bg-green-50 rounded-xl border border-green-200">
                    <p class="text-green-700 font-bold flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check"></i> Pesanan Sudah Disajikan
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openDetailModal(id) {
        // Fetch data detail pesanan via AJAX
        fetch('<?php echo site_url("dashboard/get_order_detail/"); ?>' + id)
        .then(response => response.json())
        .then(data => {
            const order = data.order;
            const items = data.items;

            // 1. Isi data Dasar
            document.getElementById('hidden-order-id').value = order.id;
            document.getElementById('modal-order-id').innerText = 'Detail Pesanan ' + order.order_number;
            
            // Logika Meja
            let tableDisplay = order.table_number;
            if (/^\d+$/.test(tableDisplay)) {
                tableDisplay = "Meja " + tableDisplay;
            }
            document.getElementById('modal-table').innerText = tableDisplay;
            
            // Format Rupiah
            const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
            document.getElementById('modal-total').innerText = formatter.format(order.total_price);

            // 2. Render List Item
            const listContainer = document.getElementById('modal-items-list');
            listContainer.innerHTML = '';
            
            items.forEach(item => {
                const html = `
                <div class="flex justify-between items-center border-b border-gray-200 last:border-0 pb-2 last:pb-0">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-gray-700 bg-white border border-gray-200 w-8 h-8 flex items-center justify-center rounded-lg text-sm shadow-sm flex-shrink-0">${item.qty}x</span>
                        <span class="text-gray-800 font-medium text-sm break-words">${item.product_name}</span>
                    </div>
                    <span class="text-gray-600 text-sm font-semibold flex-shrink-0 ml-2">${formatter.format(item.subtotal)}</span>
                </div>`;
                listContainer.innerHTML += html;
            });

            // 3. Render Catatan (Notes)
            const noteContainer = document.getElementById('modal-note-container');
            const noteText = document.getElementById('modal-note-text');

            if (order.kitchen_note && order.kitchen_note.trim() !== "") {
                noteText.innerText = order.kitchen_note;
                noteContainer.classList.remove('hidden');
            } else {
                noteContainer.classList.add('hidden');
            }

            // 4. Cek Status untuk Tombol di Modal
            const btnComplete = document.getElementById('btn-complete-order');
            const msgServed = document.getElementById('status-served-msg');

            if (order.status.toLowerCase() === 'served' || order.status.toLowerCase() === 'selesai') {
                btnComplete.classList.add('hidden'); // Sembunyikan tombol aksi jika sudah selesai
                msgServed.classList.remove('hidden'); // Tampilkan pesan info
            } else {
                btnComplete.classList.remove('hidden');
                msgServed.classList.add('hidden');
            }

            // Tampilkan Modal
            document.getElementById('detailModal').classList.remove('hidden');
        });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    function completeOrder() {
        const id = document.getElementById('hidden-order-id').value;
        
        if(confirm('Apakah pesanan ini sudah selesai disajikan?')) {
            const formData = new FormData();
            formData.append('id', id);

            fetch('<?php echo site_url("dashboard/complete_order"); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload();
                } else {
                    alert('Gagal update status');
                }
            });
        }
    }
</script>