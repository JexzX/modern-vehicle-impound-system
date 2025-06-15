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
        max-height: 150px;
        transition: all 0.3s;
    }

    .file-input-label {
        border: 2px dashed #d1d5db;
        transition: all 0.3s;
    }

    .file-input-label:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Tombol Kembali -->
        <a href="index.php" class="inline-flex items-center text-blue-500 hover:text-blue-700 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Form -->
            <div class="bg-blue-500 px-6 py-4 text-white">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-car-crash mr-2"></i> New Vehicle Impound
                </h1>
            </div>

            <!-- Form Input -->
            <form method="POST" action="save_vehicle.php" enctype="multipart/form-data" class="p-6 space-y-6">

                <!-- 1. Vehicle Information -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        <i class="fas fa-car mr-2 text-blue-500"></i> Vehicle Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Vehicle Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Model *</label>
                            <input type="text" name="vehicle_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="E.g: Premier">
                        </div>

                        <!-- Plate Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">License Plate *</label>
                            <input type="text" name="plate_number" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="E.g: GA999NE">
                        </div>

                        <!-- Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Color *</label>
                            <select name="color" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Color</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                                <option value="Blue">Blue</option>
                                <option value="Red">Red</option>
                            </select>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Impound Duration *</label>
                            <select name="impound_duration" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="1 day">24 Hours</option>
                                <option value="3 days">3 Days</option>
                                <option value="7 days">1 Week</option>
                                <option value="30 days">1 Month</option>
                                <option value="Permanent">Permanent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 2. Case Information -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Case Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Officer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Impound Officer *</label>
                            <input type="text" name="officer" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="E.g: John Doe">
                        </div>

                        <!-- Owner -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Owner *</label>
                            <input type="text" name="owner" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="E.g: Jane Smith">
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Impound Reason *</label>
                        <textarea name="reason" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Detailed reason..."></textarea>
                    </div>
                </div>

                <!-- 3. Evidence Photos -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        <i class="fas fa-camera mr-2 text-blue-500"></i> Evidence Photos *
                    </h2>

                    <!-- File Upload -->
                    <div class="space-y-2">
                        <label
                            class="file-input-label cursor-pointer flex flex-col items-center justify-center p-4 rounded-lg text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-blue-500 mb-2"></i>
                            <p class="font-medium">Click to upload or drag & drop</p>
                            <p class="text-sm text-gray-500">JPEG or PNG (Max 5MB per file)</p>
                            <input type="file" name="proofs[]" multiple accept="image/*" class="hidden" id="fileInput"
                                required>
                        </label>

                        <!-- Preview -->
                        <div id="previewContainer" class="grid grid-cols-2 gap-2 hidden"></div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="reset"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        <i class="fas fa-save mr-1"></i> Submit Impound
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Preview Uploaded Images
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const container = document.getElementById('previewContainer');
        container.innerHTML = '';

        if (this.files.length > 0) {
            container.classList.remove('hidden');

            Array.from(this.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="proof-preview w-full h-32 object-cover rounded border">
                        <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            ×
                        </button>
                    `;
                    div.querySelector('button').addEventListener('click', () => {
                        div.remove();
                        if (container.children.length === 0) {
                            container.classList.add('hidden');
                        }
                    });
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
        }
    });

    // Drag and Drop
    const label = document.querySelector('.file-input-label');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        label.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        label.addEventListener(eventName, () => {
            label.classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        label.addEventListener(eventName, () => {
            label.classList.remove('border-blue-500', 'bg-blue-50');
        });
    });

    label.addEventListener('drop', (e) => {
        const input = document.getElementById('fileInput');
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    });
    </script>
</body>

</html>