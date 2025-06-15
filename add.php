<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ New Impound | Modern System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .proof-preview {
        max-height: 200px;
        display: none;
    }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <a href="index.php" class="inline-flex items-center text-blue-500 hover:text-blue-700 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-500 px-6 py-4 text-white">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-car-crash mr-3"></i> New Vehicle Impound
                </h1>
                <p class="text-blue-100 mt-1">Fill all required information</p>
            </div>

            <!-- Form -->
            <form method="POST" action="save_vehicle.php" enctype="multipart/form-data"
                class="divide-y divide-gray-200">
                <!-- Vehicle Section -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-car mr-2 text-blue-500"></i> Vehicle Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Vehicle Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Model*</label>
                            <input type="text" name="vehicle_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Plate Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">License Plate*</label>
                            <input type="text" name="plate_number" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Color*</label>
                            <select name="color" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Select color</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                                <option value="Blue">Blue</option>
                                <option value="Red">Red</option>
                                <option value="Green">Green</option>
                            </select>
                        </div>

                        <!-- Impound Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Impound Duration*</label>
                            <select name="impound_duration" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="1 day">24 Hours / 1 Day</option>
                                <option value="3 days">3 Days</option>
                                <option value="7 days">1 Week</option>
                                <option value="14 days">2 Weeks</option>
                                <option value="30 days">1 Month</option>
                                <option value="Permanent">Permanent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Case Section -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Case Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Officer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Impound Officer*</label>
                            <input type="text" name="officer" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Owner -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Owner*</label>
                            <input type="text" name="owner" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Impound Reason*</label>
                        <textarea name="reason" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <!-- Proof Section -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-camera mr-2 text-blue-500"></i> Evidence
                    </h2>

                    <div class="space-y-4">
                        <!-- Proof 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Proof Photo 1*</label>
                            <input type="file" name="proof1" accept="image/*" required
                                class="proof-input block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <img id="preview1" class="proof-preview mt-2 rounded-lg border">
                        </div>

                        <!-- Proof 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Proof Photo 2 (Optional)</label>
                            <input type="file" name="proof2" accept="image/*"
                                class="proof-input block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <img id="preview2" class="proof-preview mt-2 rounded-lg border">
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button type="reset"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        <i class="fas fa-save mr-1"></i> Save Impound
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Preview image sebelum upload
    document.querySelectorAll('.proof-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const previewId = this.name.replace('proof', 'preview');
            const preview = document.getElementById(previewId);

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    </script>
</body>

</html>