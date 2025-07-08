<?php
include 'koneksi.php';

$tanggal = $_POST['tanggal'];
$status  = $_POST['status'];

// Query dengan DISTINCT untuk mencegah duplikasi data
$query = "
    SELECT DISTINCT b.id, b.username, b.tanggal, b.jam, b.status, b.dokumen,
                    u.username AS nama_user, a.nama AS nama_alat
    FROM booking b
    JOIN users u ON b.username = u.username
    JOIN alat a ON b.alat_id = a.id
    WHERE 1
";

if (!empty($tanggal)) {
    $query .= " AND b.tanggal = '$tanggal'";
}
if (!empty($status)) {
    $query .= " AND b.status = '$status'";
}

$query .= " ORDER BY b.tanggal DESC, b.jam DESC";

$q = mysqli_query($koneksi, $query);

echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th>No</th><th>Mahasiswa</th><th>Alat</th><th>Tanggal</th><th>Status</th><th>Dokumen</th><th>Aksi</th></tr></thead>';
echo '<tbody>';

$no = 1;
while ($d = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td>$no</td>
        <td>{$d['nama_user']}</td>
        <td>{$d['nama_alat']}</td>
        <td>{$d['tanggal']} {$d['jam']}</td>
        <td>{$d['status']}</td>
        <td>";

    if (!empty($d['dokumen'])) {
        echo "<a href='upload/{$d['dokumen']}' target='_blank' class='btn btn-info btn-sm'>Lihat</a>";
    } else {
        echo "<span class='text-muted'>Tidak ada</span>";
    }

    echo "</td>
        <td>
            <a href='verifikasi.php?id={$d['id']}&aksi=setujui' class='btn btn-success btn-sm'>Setujui</a>
            <a href='verifikasi.php?id={$d['id']}&aksi=tolak' class='btn btn-danger btn-sm'>Tolak</a>
        </td>
    </tr>";
    $no++;
}

if ($no === 1) {
    echo "<tr><td colspan='7' class='text-center text-muted'>Tidak ada data booking.</td></tr>";
}

echo '</tbody></table>';
?>