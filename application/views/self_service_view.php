<!-- Layout Utama: Flex Row (Kiri Sidebar, Kanan Grid) -->
<div class="flex flex-col lg:flex-row gap-8 h-full">

    <!-- ============================================================== -->
    <!-- 1. SIDEBAR FILTER (KIRI) -->
    <!-- ============================================================== -->
    <div class="w-full lg:w-72 flex-shrink-0 space-y-8 pb-10">
        
        <!-- Header Filter -->
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-lg">Filter Menu</h3>
            <button class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Reset all</button>
        </div>

        <!-- Kategori (Rental Type Style) -->
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 block">Kategori</label>
            <div class="flex flex-wrap gap-2">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold shadow-md shadow-indigo-200">Semua</button>
                <button class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-lg text-xs font-semibold">Makanan</button>
                <button class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-lg text-xs font-semibold">Minuman</button>
            </div>
        </div>

        <!-- Rentang Harga dengan Grafik (Price Range Style) -->
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 block">Rentang Harga</label>
            
            <!-- Visualisasi Histogram Harga (CSS Only) -->
            <div class="h-16 flex items-end gap-1 mb-2 px-1">
                <div class="w-1/12 bg-indigo-100 rounded-t h-[30%]"></div>
                <div class="w-1/12 bg-indigo-100 rounded-t h-[50%]"></div>
                <div class="w-1/12 bg-indigo-100 rounded-t h-[40%]"></div>
                <div class="w-1/12 bg-indigo-100 rounded-t h-[70%]"></div>
                <div class="w-1/12 bg-indigo-200 rounded-t h-[60%]"></div>
                <div class="w-1/12 bg-indigo-500 rounded-t h-[100%]"></div> <!-- Active Range -->
                <div class="w-1/12 bg-indigo-500 rounded-t h-[80%]"></div>  <!-- Active Range -->
                <div class="w-1/12 bg-indigo-500 rounded-t h-[50%]"></div>  <!-- Active Range -->
                <div class="w-1/12 bg-indigo-200 rounded-t h-[30%]"></div>
                <div class="w-1/12 bg-indigo-100 rounded-t h-[20%]"></div>
                <div class="w-1/12 bg-indigo-100 rounded-t h-[40%]"></div>
                <div class="w-1/12 bg-indigo-100 rounded-t h-[10%]"></div>
            </div>

            <!-- Input Range -->
            <div class="flex items-center gap-3">
                <div class="relative w-full">
                    <span class="absolute left-3 top-2 text-xs text-gray-400">Rp</span>
                    <input type="number" value="15000" class="w-full pl-8 pr-2 py-1.5 text-sm border border-gray-200 rounded-md font-semibold text-gray-700">
                </div>
                <span class="text-gray-400 text-xs">TO</span>
                <div class="relative w-full">
                    <span class="absolute left-3 top-2 text-xs text-gray-400">Rp</span>
                    <input type="number" value="100000" class="w-full pl-8 pr-2 py-1.5 text-sm border border-gray-200 rounded-md font-semibold text-gray-700">
                </div>
            </div>
        </div>

        <!-- Filter Checkbox (Body Type Style) -->
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 block">Preferensi</label>
            <div class="grid grid-cols-2 gap-y-3">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <div class="w-5 h-5 rounded border border-gray-300 flex items-center justify-center group-hover:border-indigo-500 transition">
                        <input type="checkbox" class="hidden" checked>
                        <i class="fa-solid fa-check text-xs text-indigo-600"></i>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-gray-800">Pedas</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer group">
                    <div class="w-5 h-5 rounded border border-gray-300 flex items-center justify-center group-hover:border-indigo-500 transition">
                        <input type="checkbox" class="hidden">
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-gray-800">Manis</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer group">
                    <div class="w-5 h-5 rounded border border-gray-300 flex items-center justify-center group-hover:border-indigo-500 transition">
                        <input type="checkbox" class="hidden">
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-gray-800">Goreng</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer group">
                    <div class="w-5 h-5 rounded border border-gray-300 flex items-center justify-center group-hover:border-indigo-500 transition">
                        <input type="checkbox" class="hidden" checked>
                        <i class="fa-solid fa-check text-xs text-indigo-600"></i>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-gray-800">Kuah</span>
                </label>
            </div>
        </div>

        <!-- Promo Banner (Available Now Style) -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl p-5 text-white shadow-lg relative overflow-hidden">
            <i class="fa-solid fa-gift absolute -right-4 -bottom-4 text-8xl text-white opacity-10"></i>
            <h4 class="font-bold text-lg mb-1">Promo Hari Ini</h4>
            <p class="text-indigo-100 text-xs mb-4">Diskon 20% untuk pembelian paket combo.</p>
            <button class="w-full bg-white text-indigo-700 text-xs font-bold py-2 rounded shadow hover:bg-gray-50">Cek Promo</button>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- 2. GRID CONTENT (KANAN) -->
    <!-- ============================================================== -->
    <div class="flex-1">
        
        <!-- Top Bar (Search & Sort) -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                <?php echo count($menu_makanan); ?> Menu Tersedia
            </h2>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Cari menu..." class="pl-9 pr-4 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none w-48">
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-medium cursor-pointer hover:text-indigo-600">
                    <span>Terpopuler</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            
            <?php 
            // URL Gambar Dummy untuk variasi visual
            $images = [
                'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=500&q=80', // Burger
                'https://images.unsplash.com/photo-1576107232684-1279f390859f?auto=format&fit=crop&w=500&q=80', // Fries
                'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?auto=format&fit=crop&w=500&q=80', // Cola
            ];
            
            $i = 0;
            foreach($menu_makanan as $menu): 
                $imgUrl = isset($images[$i]) ? $images[$i] : $images[0];
                $i++;
            ?>
            
            <!-- CARD MENU (Style mirip referensi) -->
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition duration-300 group flex flex-col h-full relative">
                
                <!-- Heart Icon (Top Right) -->
                <button class="absolute top-4 right-4 z-10 text-gray-300 hover:text-red-500 transition bg-white/80 rounded-full p-1.5 backdrop-blur-sm">
                    <i class="fa-solid fa-heart"></i>
                </button>

                <!-- Header Info (Jarak & Rating) -->
                <div class="flex items-center gap-3 text-xs font-medium text-gray-500 mb-3">
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-clock text-indigo-500"></i>
                        <span>15 min</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-star text-yellow-400"></i>
                        <span class="text-gray-800">4.8</span>
                        <span class="text-gray-400">(120)</span>
                    </div>
                </div>

                <!-- Image -->
                <div class="h-40 rounded-xl overflow-hidden mb-4 relative bg-gray-50">
                    <img src="<?php echo $imgUrl; ?>" alt="<?php echo $menu->nama; ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><?php echo $menu->nama; ?></h3>
                    <p class="text-xs text-gray-400 mb-4 line-clamp-2">Menu favorit dengan bahan pilihan berkualitas tinggi. Cocok untuk makan siang.</p>
                </div>

                <!-- Footer (Price & Action) -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-auto">
                    <div>
                        <p class="text-xs text-gray-400">Harga</p>
                        <p class="text-lg font-bold text-gray-800">Rp <?php echo number_format($menu->harga, 0, ',', '.'); ?></p>
                    </div>
                    
                    <!-- LOGIKA ROLE -->
                    <?php if($this->session->userdata('role') === 'admin'): ?>
                        <div class="flex gap-2">
                            <button class="p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if($this->session->userdata('role') === 'guest'): ?>
                        <button class="bg-gray-900 text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-indigo-600 transition flex items-center gap-2">
                            <span>Add</span>
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach; ?>

        </div>
    </div>

</div>