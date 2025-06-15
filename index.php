<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚗 Impound System | Modern</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <style>
    body {
        background-color: #f9fafb;
    }

    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .smooth-transition {
        transition: all 0.3s ease;
    }

    /* Loading spinner */
    .spinner {
        width: 24px;
        height: 24px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body class="font-sans bg-gray-50" x-data="{
    loading: false,
    confirmDelete(plate) {
        if (confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')) {
            this.loading = true;
            window.location.href = 'remove.php?plate=' + plate;
        }
    }
}">
    <!-- Header -->
    <header class="bg-white shadow-sm smooth-transition">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-car mr-2 text-blue-500"></i> Impound System
            </h1>
            <a href="add.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg smooth-transition">
                <i class="fas fa-plus mr-1"></i> Tambah Kendaraan
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <!-- Loading Indicator -->
        <div x-show="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="spinner"></div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden smooth-transition">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Durasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $sql = "SELECT * FROM impounded_vehicles";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        $delay = 0;
                        while($row = $result->fetch_assoc()) {
                            $isExpired = strtotime($row['expiry_date']) < time();
                            $statusClass = $isExpired ? "bg-red-100 text-red-800" : "bg-green-100 text-green-800";
                            $statusText = $isExpired ? "Expired" : "Aktif";
                            
                            echo "<tr class='hover:bg-gray-50 smooth-transition fade-in' style='animation-delay: {$delay}ms'>
                                <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>{$row['vehicle_type']}</td>
                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['plate_number']}</td>
                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['reason']}</td>
                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['impound_duration']}</td>
                                <td class='px-6 py-4 whitespace-nowrap'>
                                    <span class='px-2 py-1 text-xs rounded-full {$statusClass}'>{$statusText}</span>
                                </td>
                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>
                                    <button @click='confirmDelete(\"{$row['plate_number']}\")' class='text-red-500 hover:text-red-700 smooth-transition'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </td>
                            </tr>";
                            $delay += 50;
                        }
                    } else {
                        echo "<tr class='fade-in'>
                            <td colspan='6' class='px-6 py-4 text-center text-gray-500'>Tidak ada data kendaraan.</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8 py-4 smooth-transition">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500 text-sm">
            © 2023 Impound System | Dibuat dengan <i class="fas fa-heart text-red-500"></i>
        </div>
    </footer>

    <!-- Notification Toast -->
    <div x-show="$store.notification.show" x-transition
        class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center" x-data="{
             show: false,
             init() {
                 if (new URLSearchParams(window.location.search).has('success')) {
                     this.show = true;
                     setTimeout(() => this.show = false, 3000);
                 }
             }
         }" x-init="init" @notification.window="show = true; setTimeout(() => show = false, 3000)">
        <i class="fas fa-check-circle mr-2"></i>
        <span x-text="$store.notification.message"></span>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('notification', {
            show: false,
            message: '',

            notify(msg) {
                this.message = msg;
                this.show = true;
                setTimeout(() => this.show = false, 3000);
            }
        });

        // Check for success parameter in URL
        if (new URLSearchParams(window.location.search).has('success')) {
            Alpine.store('notification').notify('Operasi berhasil!');
        }
    });
    </script>
</body>

</html>