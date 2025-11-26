<!-- 1. DATA PHP KE JAVASCRIPT -->
<script>
    const menuData = <?php echo json_encode($menu_makanan); ?>;
</script>

<div class="flex flex-col-reverse lg:flex-row h-[calc(100vh-130px)] gap-6 overflow-hidden">

    <!-- ============================================================== -->
    <!-- BAGIAN KIRI: KERANJANG & PEMBAYARAN (SIDEBAR) -->
    <!-- ============================================================== -->
    <div class="w-full lg:w-96 bg-white flex flex-col border border-gray-200 shadow-xl rounded-2xl overflow-hidden z-20 h-full">
        
        <!-- Header Keranjang -->
        <div class="p-4 bg-indigo-600 text-white shadow-md flex justify-between items-center flex-shrink-0">
            <h2 class="font-bold text-lg flex items-center gap-2">
                <i class="fa-solid fa-receipt"></i> Pesanan Anda
            </h2>
            <span class="text-xs bg-white/20 px-2 py-1 rounded text-white font-medium">Self Service</span>
        </div>

        <!-- List Item (Area Scroll) -->
        <div id="cart-container" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 scrollbar-thin">
            <div id="empty-cart-msg" class="h-full flex flex-col items-center justify-center text-gray-400 opacity-60 mt-10">
                <i class="fa-solid fa-basket-shopping text-6xl mb-3"></i>
                <p class="text-sm font-medium">Keranjang kosong</p>
                <p class="text-xs">Pilih menu di samping untuk memesan</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-white p-5 border-t border-gray-200 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] flex-shrink-0">
            <div class="mb-4">
                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block tracking-wide">Catatan Dapur</label>
                <div class="relative">
                    <i class="fa-solid fa-pen absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                    <input type="text" id="kitchen-note" class="w-full text-sm pl-8 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="Contoh: Jangan pedas, saus dipisah...">
                </div>
            </div>

            <div class="flex items-center justify-between mb-4 pt-3 border-t border-dashed border-gray-200">
                <span class="text-gray-500 font-medium">Total Bayar</span>
                <span class="text-2xl font-bold text-indigo-700" id="total-price">Rp 0</span>
            </div>

            <button onclick="openPaymentModal()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-200 transition transform active:scale-[0.98] flex justify-center items-center gap-2 group">
                <span>Selanjutnya</span>
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition"></i>
            </button>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- BAGIAN KANAN: GRID MENU (KATALOG DATABASE) -->
    <!-- ============================================================== -->
    <div class="flex-1 h-full overflow-y-auto pr-2 pb-20 scroll-smooth scrollbar-hide">
        
        <!-- PERBAIKAN DI SINI: z-index dinaikkan jadi z-30 agar di atas overlay kartu menu (z-10) -->
        <div class="mb-6 sticky top-0 bg-gray-50 pt-2 pb-4 z-30">
            <h1 class="text-2xl font-bold text-gray-800">Menu Restoran</h1>
            <p class="text-gray-500 text-sm">Silakan pilih menu favorit Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php foreach($menu_makanan as $menu): ?>
            
            <div class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-100 transition duration-300 flex flex-col h-full group relative overflow-hidden">
                
                <!-- Overlay Stok Habis (z-10) -->
                <!-- Karena Header z-30, maka overlay ini akan tertutup header saat scroll -->
                <?php if($menu->stock <= 0): ?>
                <div class="absolute inset-0 bg-white/80 z-10 flex flex-col items-center justify-center text-gray-500">
                    <i class="fa-solid fa-ban text-4xl mb-2"></i>
                    <span class="font-bold text-lg">Habis</span>
                </div>
                <?php endif; ?>

                <!-- Gambar -->
                <div class="h-40 w-full rounded-xl overflow-hidden mb-3 bg-gray-100 relative">
                    <img src="<?php echo $menu->image_url; ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-sm font-bold text-gray-800 shadow-sm">
                        Rp <?php echo number_format($menu->price, 0, ',', '.'); ?>
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1 px-1">
                    <h3 class="font-bold text-gray-800 text-lg leading-tight mb-1"><?php echo $menu->name; ?></h3>
                    <p class="text-gray-400 text-xs line-clamp-2">Menu lezat pilihan chef.</p>
                </div>

                <!-- Kontrol -->
                <div class="mt-4 flex items-center justify-between bg-gray-50 p-1.5 rounded-xl border border-gray-200">
                    <button onclick="updateQty(<?php echo $menu->id; ?>, -1)" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-red-600 hover:shadow-sm transition"><i class="fa-solid fa-minus text-xs"></i></button>
                    <span id="qty-display-<?php echo $menu->id; ?>" class="font-bold text-gray-800 text-lg w-8 text-center">0</span>
                    <button onclick="updateQty(<?php echo $menu->id; ?>, 1)" class="w-9 h-9 flex items-center justify-center bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition <?php echo $menu->stock <= 0 ? 'opacity-50 cursor-not-allowed' : ''; ?>" <?php echo $menu->stock <= 0 ? 'disabled' : ''; ?>><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="h-32 lg:hidden"></div>
    </div>

</div>

<!-- MODAL PEMBAYARAN -->
<div id="paymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closePaymentModal()"></div>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl transform transition-all max-w-md w-full overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center gap-2"><i class="fa-solid fa-credit-card"></i> Pembayaran</h3>
                <button onclick="closePaymentModal()" class="text-indigo-200 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-6">
                <div class="text-center mb-6">
                    <p class="text-gray-500 text-xs uppercase font-bold tracking-wide">Total Tagihan</p>
                    <h2 class="text-4xl font-bold text-indigo-600 mt-1" id="modal-total-display">Rp 0</h2>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Meja <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-chair absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" id="input-table-number" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none font-bold text-gray-800" placeholder="Contoh: Meja 10">
                    </div>
                </div>
                <div class="space-y-3 mb-6">
                    <p class="text-xs font-bold text-gray-500 uppercase">Pilih Metode</p>
                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition group" onclick="selectMethod('QRIS')">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="QRIS" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500" checked>
                            <div><span class="block text-sm font-bold text-gray-800">QRIS (Scan)</span><span class="text-xs text-gray-500">Gopay, OVO, Dana, ShopeePay</span></div>
                        </div>
                        <i class="fa-solid fa-qrcode text-2xl text-gray-400 group-hover:text-indigo-600 transition"></i>
                    </label>
                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition group" onclick="selectMethod('Transfer BCA')">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="Transfer BCA" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500">
                            <div><span class="block text-sm font-bold text-gray-800">Transfer Bank BCA</span><span class="text-xs text-gray-500">Virtual Account / Manual</span></div>
                        </div>
                        <i class="fa-solid fa-building-columns text-2xl text-gray-400 group-hover:text-indigo-600 transition"></i>
                    </label>
                </div>
                <button onclick="showPaymentDetail()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-200 transition transform active:scale-[0.98] flex justify-center items-center gap-2"><span>Bayar Sekarang</span><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PEMBAYARAN -->
<div id="paymentDetailModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity"></div>
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full p-6 relative">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            <div id="payment-content" class="flex flex-col items-center"></div>
            <div class="mt-6">
                <button onclick="finalProcessCheckout()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-md transition transform active:scale-[0.98]">Saya Sudah Bayar</button>
                <p class="text-center text-xs text-gray-400 mt-3">Pesanan akan diproses setelah pembayaran dikonfirmasi.</p>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = {}; 
    let selectedMethod = 'QRIS'; 
    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

    function updateQty(id, change) {
        const menu = menuData.find(m => m.id == id);
        if (!menu) return;
        if (!cart[id]) cart[id] = 0;
        if (change > 0 && cart[id] >= parseInt(menu.stock)) {
            alert(`Maaf, stok tersisa ${menu.stock} porsi.`);
            return; 
        }
        cart[id] += change;
        if (cart[id] < 0) cart[id] = 0;
        const display = document.getElementById(`qty-display-${id}`);
        if(display) display.innerText = cart[id];
        renderCart();
    }

function renderCart() {
        const container = document.getElementById('cart-container');
        let total = 0;
        let hasItem = false;
        
        // Kita tampung HTML string-nya dulu, jangan langsung inject ke innerHTML berulang kali
        let htmlContent = ''; 

        // Loop data menu
        menuData.forEach(menu => {
            const qty = cart[menu.id] || 0;
            
            if (qty > 0) {
                hasItem = true;
                // Pastikan harga jadi integer agar perhitungan benar
                const price = parseInt(menu.price); 
                const subtotal = qty * price;
                total += subtotal;

                // Tambahkan HTML item ke variabel string
                htmlContent += `
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-3 animate-fade-in relative">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm leading-tight">${menu.name}</h4>
                            <p class="text-xs text-gray-400 mt-1">@ ${formatter.format(price)}</p>
                        </div>
                        <span class="font-bold text-indigo-600 text-sm">${formatter.format(subtotal)}</span>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-1.5 border border-gray-100">
                        <button onclick="updateQty(${menu.id}, -1)" class="w-7 h-7 flex items-center justify-center bg-white border border-gray-200 rounded-md text-gray-500 hover:text-red-500 transition shadow-sm"><i class="fa-solid fa-minus text-xs"></i></button>
                        <span class="text-sm font-bold text-gray-800">${qty}x</span>
                        <button onclick="updateQty(${menu.id}, 1)" class="w-7 h-7 flex items-center justify-center bg-indigo-100 border border-indigo-200 rounded-md text-indigo-600 hover:bg-indigo-200 transition shadow-sm"><i class="fa-solid fa-plus text-xs"></i></button>
                    </div>
                </div>`;
            }
        });

        // LOGIKA KOSONG: Jika tidak ada item, isi htmlContent dengan tampilan kosong
        if (!hasItem) {
            htmlContent = `
            <div id="empty-cart-msg" class="h-full flex flex-col items-center justify-center text-gray-400 opacity-60 mt-10">
                <i class="fa-solid fa-basket-shopping text-6xl mb-3"></i>
                <p class="text-sm font-medium">Keranjang kosong</p>
                <p class="text-xs">Pilih menu di samping untuk memesan</p>
            </div>`;
        }

        // Update Tampilan Keranjang Sekaligus
        container.innerHTML = htmlContent;

        // Update Total Harga (Penting: baris ini sekarang aman dieksekusi)
        document.getElementById('total-price').innerText = formatter.format(total);
    }

    function openPaymentModal() {
        const totalStr = document.getElementById('total-price').innerText;
        if(totalStr === 'Rp 0' || totalStr === 'IDR 0') { alert('Keranjang masih kosong! Silakan pilih menu dulu.'); return; }
        document.getElementById('modal-total-display').innerText = totalStr;
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() { document.getElementById('paymentModal').classList.add('hidden'); }
    function selectMethod(method) { selectedMethod = method; const radios = document.getElementsByName('payment_method'); for(let i=0;i<radios.length;i++){if(radios[i].value===method)radios[i].checked=true;} }

    function showPaymentDetail() {
        const tableNo = document.getElementById('input-table-number').value;
        if (!tableNo.trim()) { alert('Mohon isi Nomor Meja terlebih dahulu!'); document.getElementById('input-table-number').focus(); return; }
        const contentDiv = document.getElementById('payment-content');
        const totalStr = document.getElementById('total-price').innerText;
        if (selectedMethod === 'QRIS') {
            contentDiv.innerHTML = `<h3 class="text-xl font-bold text-gray-800 mb-1">Scan QRIS</h3><p class="text-gray-500 text-sm mb-4">Silakan scan kode di bawah ini</p><div class="bg-white p-2 rounded-xl border border-gray-200 shadow-sm mb-4"><img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=BAYAR_${totalStr}" alt="QRIS Code" class="w-48 h-48"></div><p class="text-lg font-bold text-indigo-600">${totalStr}</p><p class="text-xs text-gray-400 mt-2">OVO / GoPay / Dana / ShopeePay</p>`;
        } else {
            contentDiv.innerHTML = `<div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4 text-3xl"><i class="fa-solid fa-building-columns"></i></div><h3 class="text-xl font-bold text-gray-800 mb-1">Transfer BCA</h3><p class="text-gray-500 text-sm mb-6">Silakan transfer ke rekening berikut</p><div class="bg-gray-50 p-4 rounded-xl border border-gray-200 w-full text-center mb-4"><p class="text-xs text-gray-500 uppercase font-bold">Nomor Rekening</p><p class="text-2xl font-mono font-bold text-gray-800 my-1 selection:bg-indigo-100">8830 1234 56</p><p class="text-sm text-gray-600">a.n Resto App Corporate</p></div><div class="flex justify-between w-full px-4 py-2 bg-indigo-50 rounded-lg text-indigo-700 text-sm font-bold"><span>Total Transfer</span><span>${totalStr}</span></div>`;
        }
        closePaymentModal();
        document.getElementById('paymentDetailModal').classList.remove('hidden');
    }

    function closeDetailModal() { document.getElementById('paymentDetailModal').classList.add('hidden'); }

    function finalProcessCheckout() {
        const note = document.getElementById('kitchen-note').value;
        const tableNo = document.getElementById('input-table-number').value;
        let itemsToSend = [];
        let totalPrice = 0;
        menuData.forEach(menu => {
            const qty = cart[menu.id] || 0;
            if (qty > 0) {
                itemsToSend.push({ id: menu.id, name: menu.name, price: parseInt(menu.price), qty: qty });
                totalPrice += (qty * parseInt(menu.price));
            }
        });
        const payload = { items: itemsToSend, total_price: totalPrice, payment_method: selectedMethod, note: note, table_number: tableNo };
        fetch('<?php echo site_url("dashboard/process_checkout"); ?>', {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload)
        }).then(response => response.json()).then(data => {
            if(data.status === 'success') { alert(`Terima Kasih!\nPesanan Berhasil Dibuat.\nNomor Order: ${data.order_number}`); location.reload(); } else { alert('Gagal: ' + data.message); }
        }).catch(error => { console.error('Error:', error); alert('Terjadi kesalahan koneksi.'); });
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.2s ease-out; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>