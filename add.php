<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ Add Vehicle | Impound System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <!-- Card Form -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-car-side mr-2 text-blue-500"></i> Add Impounded Vehicle
            </h2>

            <form method="POST" action="save_vehicle.php">
                <!-- Vehicle Type -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Vehicle Type</label>
                    <input type="text" name="vehicle_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Plate Number -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">License Plate</label>
                    <input type="text" name="plate_number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Reason -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Impound Reason</label>
                    <textarea name="reason" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required></textarea>
                </div>

                <!-- Duration -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Impound Duration</label>
                    <div class="relative">
                        <select name="impound_duration"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="3 days">3 Days</option>
                            <option value="7 days">1 Week</option>
                            <option value="14 days">2 Weeks</option>
                            <option value="30 days">1 Month</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-clock text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="index.php"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        <i class="fas fa-save mr-2"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>