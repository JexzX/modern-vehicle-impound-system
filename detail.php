<?php 
include 'config.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid vehicle ID");
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM impounded_vehicles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Vehicle record not found");
}

$vehicle = $result->fetch_assoc();
$stmt->close();

// Get total records for proper numbering
$count_stmt = $conn->query("SELECT COUNT(*) as total FROM impounded_vehicles");
$total_records = $count_stmt->fetch_assoc()['total'];
$record_number = $total_records - $id + 1; // Reverse order numbering

// Decode proofs
$proofs = json_decode($vehicle['proofs'], true) ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impound Details | <?= htmlspecialchars($vehicle['plate_number']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .proof-image {
        max-height: 200px;
        transition: transform 0.3s;
    }

    .proof-image:hover {
        transform: scale(1.03);
    }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <a href="index.php" class="inline-flex items-center text-blue-500 hover:text-blue-700 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-500 px-6 py-4 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold">
                            <i class="fas fa-car mr-2"></i> <?= htmlspecialchars($vehicle['vehicle_type']) ?>
                        </h1>
                        <p class="text-blue-100">Record #<?= $record_number ?> (DB ID: <?= $vehicle['id'] ?>)</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="edit.php?id=<?= $vehicle['id'] ?>"
                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="delete.php?id=<?= $vehicle['id'] ?>"
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm"
                            onclick="return confirm('Are you sure you want to delete this record?')">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </a>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Vehicle Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-car-side mr-2 text-blue-500"></i> Vehicle Information
                        </h2>
                        <div class="space-y-2">
                            <p><span class="font-medium">License Plate:</span>
                                <?= htmlspecialchars($vehicle['plate_number']) ?></p>
                            <p><span class="font-medium">Color:</span> <?= htmlspecialchars($vehicle['color']) ?></p>
                            <p><span class="font-medium">Impound Duration:</span>
                                <?= htmlspecialchars($vehicle['impound_duration']) ?></p>
                            <?php if ($vehicle['expiry_date']): ?>
                            <p><span class="font-medium">Expiry Date:</span>
                                <?= date('M j, Y', strtotime($vehicle['expiry_date'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Case Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Case Details
                        </h2>
                        <div class="space-y-2">
                            <p><span class="font-medium">Impound Officer:</span>
                                <?= htmlspecialchars($vehicle['officer']) ?></p>
                            <p><span class="font-medium">Vehicle Owner:</span>
                                <?= htmlspecialchars($vehicle['owner']) ?></p>
                            <p><span class="font-medium">Status:</span>
                                <span
                                    class="px-2 py-1 rounded-full text-xs <?= $vehicle['status'] === 'Released' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= htmlspecialchars($vehicle['status']) ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 border-b pb-2">
                        <i class="fas fa-exclamation-circle mr-2 text-blue-500"></i> Impound Reason
                    </h2>
                    <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-line">
                        <?= htmlspecialchars($vehicle['reason']) ?>
                    </div>
                </div>

                <!-- Proof Photos -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-camera mr-2 text-blue-500"></i> Evidence Photos
                    </h2>

                    <?php if (!empty($proofs)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach ($proofs as $index => $proof): ?>
                        <div class="border rounded-lg overflow-hidden bg-white">
                            <img src="uploads/<?= htmlspecialchars($proof) ?>"
                                class="proof-image w-full h-48 object-cover"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/300?text=Photo+Not+Found';"
                                alt="Evidence Photo <?= $index + 1 ?>">
                            <div class="p-2 bg-gray-50 text-center text-sm text-gray-600">
                                Photo <?= $index + 1 ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="bg-yellow-50 text-yellow-800 p-4 rounded-lg">
                        <i class="fas fa-exclamation-triangle mr-2"></i> No evidence photos available
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-wrap justify-end gap-3">
                    <?php if ($vehicle['status'] !== 'Released'): ?>
                    <a href="release.php?id=<?= $vehicle['id'] ?>"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        <i class="fas fa-check mr-1"></i> Mark as Released
                    </a>
                    <?php endif; ?>
                    <a href="edit.php?id=<?= $vehicle['id'] ?>"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="fas fa-edit mr-1"></i> Edit Record
                    </a>
                    <a href="delete.php?id=<?= $vehicle['id'] ?>"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                        onclick="return confirm('Are you sure you want to permanently delete this record?')">
                        <i class="fas fa-trash mr-1"></i> Delete Record
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>