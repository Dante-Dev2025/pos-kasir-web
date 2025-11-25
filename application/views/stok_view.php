<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <!-- Summary Cards -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col">
        <p class="text-gray-500 text-xs uppercase tracking-wide font-semibold">Total Menu</p>
        <p class="text-3xl font-bold text-indigo-600 mt-1"><?php echo isset($total_item) ? $total_item : 0; ?></p>
    </div>
    <div class="bg-red-50 p-4 rounded-xl shadow-sm border border-red-100 flex flex-col">
        <p class="text-red-500 text-xs uppercase tracking-wide font-semibold">Stok Kritis / Habis</p>
        <p class="text-3xl font-bold text-red-600 mt-1"><?php echo isset($stok_kritis) ? $stok_kritis : 0; ?></p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h3 class="font-bold text-gray-800">Laporan Stok Makanan</h3>
        
        <button onclick="openModal('add')" class="text-xs bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Menu
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Menu</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php if(!empty($stok_barang)): ?>
                    <?php foreach($stok_barang as $item): ?>
                    
                    <?php 
                        $current_stock = $item->stock; 
                        $status_label = 'Aman';
                        $status_color = 'bg-green-100 text-green-700 border-green-200';
                        
                        if ($current_stock == 0) {
                            $status_label = 'Habis';
                            $status_color = 'bg-gray-100 text-gray-600 border-gray-200';
                        } elseif ($current_stock <= 10) {
                            $status_label = 'Kritis';
                            $status_color = 'bg-red-100 text-red-700 border-red-200';
                        } elseif ($current_stock <= 50) {
                            $status_label = 'Menipis';
                            $status_color = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                        }
                        
                        $itemJson = htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8');
                    ?>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                    <img class="h-10 w-10 object-cover" src="<?php echo $item->image_url; ?>" alt="" onerror="this.src='https://via.placeholder.com/40'">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900"><?php echo $item->name; ?></div>
                                    <div class="text-xs text-gray-500">ID: #PRD-<?php echo $item->id; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600 capitalize bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                <?php echo $item->category; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900"><?php echo $item->stock; ?> <span class="text-xs font-normal text-gray-500">Porsi</span></div>
                            <div class="w-24 h-1.5 bg-gray-200 rounded-full mt-1 overflow-hidden">
                                <div class="h-full <?php echo str_replace(['bg-green-100', 'bg-red-100', 'bg-yellow-100'], ['bg-green-500', 'bg-red-500', 'bg-yellow-500'], $status_color); ?>" style="width: <?php echo min($item->stock, 100); ?>%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border <?php echo $status_color; ?>">
                                <?php echo $status_label; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick="openModal('edit', <?php echo $itemJson; ?>)" class="text-indigo-600 hover:text-white hover:bg-indigo-600 border border-indigo-200 hover:border-indigo-600 p-2 rounded-lg transition shadow-sm" title="Edit Menu & Stok">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data menu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL FORM -->
<div id="menuModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>

    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fa-solid fa-utensils text-indigo-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Menu</h3>
                        <div class="mt-4 space-y-4">
                            
                            <input type="hidden" id="edit_id"> 
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Menu</label>
                                <input type="text" id="edit_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <select id="edit_category" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="food">Makanan</option>
                                        <option value="drink">Minuman</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                    <input type="number" id="edit_price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stok Tersedia</label>
                                <div class="flex items-center border border-gray-300 rounded-md mt-1">
                                    <button onclick="adjustStock(-1)" class="px-3 py-2 bg-gray-50 border-r hover:bg-gray-100 text-gray-600 font-bold">-</button>
                                    <input type="number" id="edit_stock" class="block w-full text-center border-none focus:ring-0 sm:text-sm" value="0">
                                    <button onclick="adjustStock(1)" class="px-3 py-2 bg-gray-50 border-l hover:bg-gray-100 text-gray-600 font-bold">+</button>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">URL Gambar</label>
                                <input type="text" id="edit_image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- TOMBOL HAPUS MENU (Hanya Muncul saat Edit) -->
                            <div id="delete-container" class="hidden pt-2 border-t border-gray-100 mt-4">
                                <button onclick="deleteMenu()" class="w-full text-red-600 text-sm font-medium hover:bg-red-50 p-2 rounded transition flex items-center justify-center gap-2 border border-red-200 hover:border-red-400">
                                    <i class="fa-solid fa-trash-can"></i> Hapus Menu Ini Permanen
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="saveMenu()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan
                </button>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(mode, data = null) {
        const modal = document.getElementById('menuModal');
        const title = document.getElementById('modal-title');
        const deleteBtn = document.getElementById('delete-container');
        
        modal.classList.remove('hidden');
        
        if (mode === 'edit' && data) {
            title.innerText = 'Edit Stok & Menu';
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_category').value = data.category;
            document.getElementById('edit_price').value = data.price;
            document.getElementById('edit_stock').value = data.stock;
            document.getElementById('edit_image').value = data.image_url;
            
            // Tampilkan tombol hapus saat mode edit
            deleteBtn.classList.remove('hidden');
        } else {
            title.innerText = 'Tambah Menu Baru';
            document.getElementById('edit_id').value = '';
            document.getElementById('edit_name').value = '';
            document.getElementById('edit_category').value = 'food';
            document.getElementById('edit_price').value = '';
            document.getElementById('edit_stock').value = 0;
            document.getElementById('edit_image').value = '';
            
            // Sembunyikan tombol hapus saat mode tambah
            deleteBtn.classList.add('hidden');
        }
    }

    function closeModal() {
        document.getElementById('menuModal').classList.add('hidden');
    }

    function adjustStock(amount) {
        const input = document.getElementById('edit_stock');
        let val = parseInt(input.value) || 0;
        val += amount;
        if (val < 0) val = 0;
        input.value = val;
    }

    function saveMenu() {
        const id = document.getElementById('edit_id').value;
        const name = document.getElementById('edit_name').value;
        const category = document.getElementById('edit_category').value;
        const price = document.getElementById('edit_price').value;
        const stock = document.getElementById('edit_stock').value;
        const image_url = document.getElementById('edit_image').value;

        if(!name || !price) {
            alert("Nama dan Harga wajib diisi!");
            return;
        }

        const formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
        formData.append('category', category);
        formData.append('price', price);
        formData.append('stock', stock);
        formData.append('image_url', image_url);

        fetch('<?php echo site_url("dashboard/save_product"); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Data berhasil disimpan!');
                location.reload();
            } else {
                alert('Gagal menyimpan: ' + (data.message || 'Error server'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi.');
        });
    }

    // FUNGSI HAPUS MENU
    function deleteMenu() {
        const id = document.getElementById('edit_id').value;
        
        if(confirm('Yakin ingin menghapus menu ini secara permanen? Tindakan ini tidak bisa dibatalkan.')) {
            const formData = new FormData();
            formData.append('id', id);

            fetch('<?php echo site_url("dashboard/delete_product"); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Menu berhasil dihapus!');
                    location.reload();
                } else {
                    alert('Gagal menghapus: ' + (data.message || 'Error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
            });
        }
    }
</script>