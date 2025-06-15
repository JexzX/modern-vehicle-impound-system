<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">🚗 Tambah Kendaraan Impound</h1>
        <form method="POST" action="save_vehicle.php">
            <div class="mb-3">
                <label class="form-label">Jenis Kendaraan</label>
                <input type="text" name="vehicle_type" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Plat Nomor</label>
                <input type="text" name="plate_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alasan Impound</label>
                <textarea name="reason" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Durasi (contoh: 7 hari, 1 bulan)</label>
                <input type="text" name="impound_duration" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>