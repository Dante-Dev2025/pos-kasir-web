<!-- 1. DATA PHP KE JAVASCRIPT -->
<script>
    // Mengambil data dari Database yang dikirim Controller ke variabel JS
    // Agar kalkulasi harga bisa berjalan realtime di browser
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
            <span class="text-xs bg-white/20 px-2 py-1 rounded text-white font-medium">Meja #05</span>
        </div>

        <!-- List Item (Area Scroll) -->
        <div id="cart-container" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 scrollbar-thin">
            <!-- Item akan disuntikkan di sini oleh Javascript saat tombol + ditekan -->
            <div id="empty-cart-msg" class="h-full flex flex-col items-center justify-center text-gray-400 opacity-60 mt-10">
                <i class="fa-solid fa-basket-shopping text-6xl mb-3"></i>
                <p class="text-sm font-medium">Keranjang kosong</p>
                <p class="text-xs">Pilih menu di samping untuk memesan</p>
            </div>
        </div>

        <!-- Footer: Catatan, Metode Bayar, Total (Fixed at Bottom) -->
        <div class="bg-white p-5 border-t border-gray-200 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] flex-shrink-0">
            
            <!-- Catatan Dapur -->
            <div class="mb-4">
                <label class="text-xs font-bold text-gray-500 uppercase mb-1 block tracking-wide">Catatan Dapur</label>
                <div class="relative">
                    <i class="fa-solid fa-pen absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                    <input type="text" id="kitchen-note" class="w-full text-sm pl-8 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="Contoh: Jangan pedas, saus dipisah...">
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-5">
                <label class="text-xs font-bold text-gray-500 uppercase mb-2 block tracking-wide">Metode Pembayaran</label>
                <div class="grid grid-cols-3 gap-2">
                    <button onclick="selectPayment(this, 'Tunai')" class="payment-btn active ring-2 ring-indigo-600 bg-indigo-50 text-indigo-700 py-2.5 rounded-lg text-xs font-bold border border-transparent transition flex flex-col items-center gap-1">
                        <i class="fa-solid fa-money-bill-wave"></i> Tunai
                    </button>
                    <button onclick="selectPayment(this, 'QRIS')" class="payment-btn bg-white text-gray-600 py-2.5 rounded-lg text-xs font-bold border border-gray-200 hover:bg-gray-50 transition flex flex-col items-center gap-1">
                        <i class="fa-solid fa-qrcode"></i> QRIS
                    </button>
                    <button onclick="selectPayment(this, 'Debit')" class="payment-btn bg-white text-gray-600 py-2.5 rounded-lg text-xs font-bold border border-gray-200 hover:bg-gray-50 transition flex flex-col items-center gap-1">
                        <i class="fa-regular fa-credit-card"></i> Debit
                    </button>
                </div>
            </div>

            <!-- Total & Tombol Checkout -->
            <div class="flex items-center justify-between mb-4 pt-3 border-t border-dashed border-gray-200">
                <span class="text-gray-500 font-medium">Total Bayar</span>
                <span class="text-2xl font-bold text-indigo-700" id="total-price">Rp 0</span>
            </div>

            <button onclick="checkout()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-200 transition transform active:scale-[0.98] flex justify-center items-center gap-2 group">
                <span>Selesaikan Pesanan</span>
                <i class="fa-solid fa-circle-check group-hover:scale-110 transition"></i>
            </button>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- BAGIAN KANAN: GRID MENU (DATA DARI DATABASE) -->
    <!-- ============================================================== -->
    <div class="flex-1 h-full overflow-y-auto pr-2 pb-20 scroll-smooth scrollbar-hide">
        
        <div class="mb-6 sticky top-0 bg-gray-50 pt-2 pb-4 z-10">
            <h1 class="text-2xl font-bold text-gray-800">Menu Restoran</h1>
            <p class="text-gray-500 text-sm">Silakan pilih menu favorit Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php foreach($menu_makanan as $menu): ?>
            
            <!-- KARTU MENU -->
            <div class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-100 transition duration-300 flex flex-col h-full group relative overflow-hidden">
                
                <!-- Gambar Menu -->
                <div class="h-40 w-full rounded-xl overflow-hidden mb-3 bg-gray-100 relative">
                    <!-- Mengambil URL Gambar dari Database -->
                    <img src="<?php echo $menu->image_url; ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    
                    <!-- Badge Harga -->
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-sm font-bold text-gray-800 shadow-sm">
                        Rp <?php echo number_format($menu->price, 0, ',', '.'); ?>
                    </div>
                </div>

                <!-- Info Menu -->
                <div class="flex-1 px-1">
                    <h3 class="font-bold text-gray-800 text-lg leading-tight mb-1"><?php echo $menu->name; ?></h3>
                    <p class="text-gray-400 text-xs line-clamp-2">Menu lezat yang siap memanjakan lidah Anda.</p>
                </div>

                <!-- Kontrol Jumlah (+ / -) -->
                <div class="mt-4 flex items-center justify-between bg-gray-50 p-1.5 rounded-xl border border-gray-200">
                    <!-- Tombol Kurang -->
                    <button onclick="updateQty(<?php echo $menu->id; ?>, -1)" 
                        class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-red-600 hover:shadow-sm transition active:scale-90">
                        <i class="fa-solid fa-minus text-xs"></i>
                    </button>
                    
                    <!-- Display Angka Jumlah -->
                    <span id="qty-display-<?php echo $menu->id; ?>" class="font-bold text-gray-800 text-lg w-8 text-center">0</span>
                    
                    <!-- Tombol Tambah -->
                    <button onclick="updateQty(<?php echo $menu->id; ?>, 1)" 
                        class="w-9 h-9 flex items-center justify-center bg-indigo-600 text-white rounded-lg shadow-md shadow-indigo-200 hover:bg-indigo-700 transition active:scale-90">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </button>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Spacer Mobile -->
        <div class="h-32 lg:hidden"></div>
    </div>

</div>

<!-- ============================================================== -->
<!-- JAVASCRIPT LOGIC (KERANJANG BELANJA) -->
<!-- ============================================================== -->
<script>
    let cart = {}; // Object untuk menyimpan ID Menu -> Jumlah
    let paymentMethod = 'Tunai'; // Default payment
    
    // Format Rupiah Indonesia
    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

    // 1. Fungsi Update Jumlah (Dipanggil saat klik + atau -)
    function updateQty(id, change) {
        if (!cart[id]) cart[id] = 0;
        
        cart[id] += change;

        // Mencegah minus
        if (cart[id] < 0) cart[id] = 0;

        // Update tampilan angka di kartu menu kanan
        const display = document.getElementById(`qty-display-${id}`);
        if(display) display.innerText = cart[id];

        // Render ulang keranjang kiri
        renderCart();
    }

    // 2. Fungsi Render Keranjang Kiri
    function renderCart() {
        const container = document.getElementById('cart-container');
        const emptyMsg = document.getElementById('empty-cart-msg');
        let total = 0;
        let hasItem = false;

        container.innerHTML = ''; // Reset isi container

        // Loop data menu dari database (variable menuData dari PHP)
        menuData.forEach(menu => {
            const qty = cart[menu.id] || 0;
            
            if (qty > 0) {
                hasItem = true;
                // Mengambil harga dari database (pastikan parsing int)
                const price = parseInt(menu.price);
                const subtotal = qty * price;
                total += subtotal;

                // Template HTML Item Keranjang
                const html = `
                <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col animate-fade-in relative group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-bold text-gray-800 text-sm leading-tight">${menu.name}</p>
                            <p class="text-xs text-gray-400 mt-0.5">@ ${formatter.format(price)}</p>
                        </div>
                        <p class="font-bold text-indigo-600 text-sm">${formatter.format(subtotal)}</p>
                    </div>
                    
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-1">
                        <button onclick="updateQty(${menu.id}, -1)" class="w-6 h-6 flex items-center justify-center bg-white border border-gray-200 rounded text-gray-500 hover:text-red-500 text-xs"><i class="fa-solid fa-minus"></i></button>
                        <span class="text-xs font-bold text-gray-700">${qty}x</span>
                        <button onclick="updateQty(${menu.id}, 1)" class="w-6 h-6 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded hover:bg-indigo-200 text-xs"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>`;
                
                container.innerHTML += html;
            }
        });

        // Tampilkan/Sembunyikan pesan kosong
        if (hasItem) {
            emptyMsg.style.display = 'none';
        } else {
            container.appendChild(emptyMsg);
            emptyMsg.style.display = 'flex';
        }

        // Update Total Harga di Bawah
        document.getElementById('total-price').innerText = formatter.format(total);
    }

    // 3. UI Pilihan Pembayaran
    function selectPayment(btn, method) {
        paymentMethod = method;
        // Reset semua tombol style default
        document.querySelectorAll('.payment-btn').forEach(b => {
            b.className = 'payment-btn bg-white text-gray-600 py-2.5 rounded-lg text-xs font-bold border border-gray-200 hover:bg-gray-50 transition flex flex-col items-center gap-1';
        });
        // Aktifkan tombol yg diklik (Style Active)
        btn.className = 'payment-btn active ring-2 ring-indigo-600 bg-indigo-50 text-indigo-700 py-2.5 rounded-lg text-xs font-bold border border-transparent transition flex flex-col items-center gap-1';
    }

    // 4. Tombol Selesaikan Pesanan
    function checkout() {
        const totalStr = document.getElementById('total-price').innerText;
        const note = document.getElementById('kitchen-note').value;

        if(totalStr === 'Rp 0') {
            alert('Keranjang masih kosong! Silakan pilih menu.');
            return;
        }

        // Simulasi Kirim Pesanan (Nanti diganti AJAX ke Database)
        alert(`Pesanan Berhasil!\n\nTotal: ${totalStr}\nMetode: ${paymentMethod}\nCatatan: ${note}\n\n(Pesanan diteruskan ke Kitchen Display)`);
        
        // Reset Cart setelah pesan (Opsional)
        cart = {};
        document.querySelectorAll('[id^="qty-display-"]').forEach(el => el.innerText = '0');
        document.getElementById('kitchen-note').value = '';
        renderCart();
    }
</script>

<!-- Style Tambahan untuk Animasi & Scrollbar -->
<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.2s ease-out; }
    
    /* Hide Scrollbar Chrome/Safari/Webkit */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    
    /* Hide Scrollbar Firefox */
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>