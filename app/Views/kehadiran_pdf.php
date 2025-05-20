<!DOCTYPE html>
<html>
<head>
    <title>Data Kehadiran</title>
</head>
<body>
    <h1>Daftar Kehadiran Mahasiswa</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>NPM</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Pertemuan</th>
                <th>Status</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kehadiran as $item): ?>
            <tr>
                <td><?= $item['npm'] ?></td>
                <td><?= $item['nama_mahasiswa'] ?></td>
                <td><?= $item['tanggal'] ?></td>
                <td><?= $item['pertemuan'] ?></td>
                <td><?= $item['status'] ?></td>
                <td><?= $item['nama_matkul'] ?></td>
                <td><?= $item['nama_dosen'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
