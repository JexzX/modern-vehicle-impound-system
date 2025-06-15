<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Sistem Impound Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">📋 Daftar Kendaraan Impound</h1>
        <a href="add.php" class="btn btn-primary mb-3">➕ Tambah Kendaraan</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Plat Nomor</th>
                    <th>Alasan</th>
                    <th>Durasi</th>
                    <th>Expire</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM impounded_vehicles";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $expired = (strtotime($row['expiry_date']) < time()) ? "🔴 EXPIRED" : "🟢 AKTIF";
                        echo "<tr>
                            <td>{$row['vehicle_type']}</td>
                            <td>{$row['plate_number']}</td>
                            <td>{$row['reason']}</td>
                            <td>{$row['impound_duration']}</td>
                            <td>{$row['expiry_date']} ($expired)</td>
                            <td>
                                <a href='remove.php?plate={$row['plate_number']}' class='btn btn-danger btn-sm'>Hapus</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>