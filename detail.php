<?php 
include 'config.php';
$id = $_GET['id'];
$sql = "SELECT * FROM impounded_vehicles WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Impound Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Back Button -->
        <a href="index.php" class="inline-block mb-6 text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>

        <!-- Impound Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-500 px-6 py-4 text-white">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-car mr-2"></i> '.$row['vehicle_type'].'
                </h1>
                <p class="text-blue-100">Impound ID: #'.$row['id'].'</p>
            </div>

            <!-- Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Vehicle Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Vehicle Information</h2>
                        <div class="space-y-3">
                            <p><span class="font-medium text-gray-700">Plate Number:</span> '.$row['plate_number'].'</p>
                            <p><span class="font-medium text-gray-700">Color:</span> '.$row['color'].'</p>
                            <p><span class="font-medium text-gray-700">Model:</span> '.$row['vehicle_type'].'</p>
                            <p><span class="font-medium text-gray-700">Impound Date:</span> '.date("F j, Y",
                                strtotime($row['timestamp'])).'</p>
                        </div>
                    </div>

                    <!-- Case Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Case Details</h2>
                        <div class="space-y-3">
                            <p><span class="font-medium text-gray-700">Impound Officer:</span> '.$row['officer'].'</p>
                            <p><span class="font-medium text-gray-700">Owner:</span> '.$row['owner'].'</p>
                            <p><span class="font-medium text-gray-700">Status:</span>
                                <span
                                    class="px-2 py-1 rounded-full text-xs '.($row['status'] == 'Released' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800').'">
                                    '.$row['status'].'
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Impound Reason</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        '.nl2br($row['reason']).'
                    </div>
                </div>

                <!-- Proof Images (Optional) -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Evidence</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-200 h-40 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                        <div class="bg-gray-200 h-40 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="edit.php?id='.$row['id'].'"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <a href="release.php?id='.$row['id'].'"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        <i class="fas fa-check mr-1"></i> Release
                    </a>
                    <a href="delete.php?id='.$row['id'].'"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>