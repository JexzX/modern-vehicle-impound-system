<?php 
include 'config.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid vehicle ID');
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM impounded_vehicles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Vehicle not found');
}

$row = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Impound Details #<?= $row['id'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .evidence-img {
        max-height: 300px;
        transition: transform 0.3s;
    }

    .evidence-img:hover {
        transform: scale(1.03);
    }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <a href="index.php" class="inline-flex items-center text-blue-500 hover:text-blue-700 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-500 px-6 py-4 text-white">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-car mr-2"></i> <?= htmlspecialchars($row['vehicle_type']) ?>
                </h1>
                <p class="text-blue-100">Impound ID: #<?= $row['id'] ?></p>
            </div>

            <!-- Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Vehicle Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-car-side mr-2 text-blue-500"></i> Vehicle Information
                        </h2>
                        <div class="space-y-3">
                            <p><span class="font-medium text-gray-700">Plate Number:</span>
                                <?= htmlspecialchars($row['plate_number']) ?></p>
                            <p><span class="font-medium text-gray-700">Color:</span>
                                <?= htmlspecialchars($row['color']) ?></p>
                            <p><span class="font-medium text-gray-700">Model:</span>
                                <?= htmlspecialchars($row['vehicle_type']) ?></p>
                            <p><span class="font-medium text-gray-700">Impound Date:</span>
                                <?= date("F j, Y", strtotime($row['timestamp'])) ?></p>
                            <p><span class="font-medium text-gray-700">Duration:</span>
                                <?= htmlspecialchars($row['impound_duration']) ?></p>
                            <?php if ($row['expiry_date']): ?>
                            <p><span class="font-medium text-gray-700">Expiry Date:</span>
                                <?= date("F j, Y", strtotime($row['expiry_date'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Case Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Case Details
                        </h2>
                        <div class="space-y-3">
                            <p><span class="font-medium text-gray-700">Impound Officer:</span>
                                <?= htmlspecialchars($row['officer']) ?></p>
                            <p><span class="font-medium text-gray-700">Owner:</span>
                                <?= htmlspecialchars($row['owner']) ?></p>
                            <p><span class="font-medium text-gray-700">Status:</span>
                                <span
                                    class="px-2 py-1 rounded-full text-xs <?= $row['status'] === 'Released' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 border-b pb-2">
                        <i class="fas fa-exclamation-triangle mr-2 text-blue-500"></i> Impound Reason
                    </h2>
                    <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-line">
                        <?= htmlspecialchars($row['reason']) ?>
                    </div>
                </div>

                <!-- Evidence -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-camera mr-2 text-blue-500"></i> Evidence
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if ($row['proof1']): ?>
                        <div class="text-center">
                            <img src="<?= htmlspecialchars(UPLOAD_DIR . '/' . $row['proof1']) ?>"
                                class="evidence-img mx-auto rounded-lg border shadow-sm" alt="Proof 1">
                            <p class="mt-2 text-sm text-gray-500">Proof #1</p>
                        </div>
                        <?php endif; ?>

                        <?php if ($row['proof2']): ?>
                        <div class="text-center">
                            <img src="<?= htmlspecialchars(UPLOAD_DIR . '/' . $row['proof2']) ?>"
                                class="evidence-img mx-auto rounded-lg border shadow-sm" alt="Proof 2">
                            <p class="mt-2 text-sm text-gray-500">Proof #2</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-wrap justify-end gap-3">
                    <a href="edit.php?id=<?= $row['id'] ?>"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <?php if ($row['status'] !== 'Released'): ?>
                    <a href="release.php?id=<?= $row['id'] ?>"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        <i class="fas fa-check mr-1"></i> Release
                    </a>
                    <?php endif; ?>
                    <a href="delete.php?id=<?= $row['id'] ?>"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                        onclick="return confirm('Are you sure? This cannot be undone.')">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>