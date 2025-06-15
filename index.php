<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚗 Modern Impound System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .impound-card {
        transition: all 0.3s ease;
        border-left: 4px solid #3B82F6;
    }

    .impound-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-car-crash text-blue-500 mr-2"></i> Impound Records
            </h1>
            <a href="add.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-1"></i> New Impound
            </a>
        </div>

        <!-- Search Box -->
        <div class="mb-6">
            <input type="text" placeholder="Search by plate or model..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Impound List -->
        <div class="grid gap-4">
            <?php
            $sql = "SELECT * FROM impounded_vehicles ORDER BY timestamp DESC";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '
                    <div class="impound-card bg-white rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">'.$row['vehicle_type'].'</h3>
                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                    <i class="fas fa-tag mr-1 text-blue-500"></i> '.$row['plate_number'].'
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-palette mr-1 text-blue-500"></i> '.$row['color'].'
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">'.date("M d, Y", strtotime($row['timestamp'])).'</span>
                                <a href="detail.php?id='.$row['id'].'" class="block mt-2 text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="bg-white p-8 text-center text-gray-500 rounded-lg">
                    <i class="fas fa-car-crash text-4xl mb-4 text-gray-300"></i>
                    <p>No impound records found</p>
                </div>';
            }
            ?>
        </div>
    </div>
</body>

</html>