<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kehadiran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e6f3ff;
            transition: background-color 0.3s ease;
        }
        td {
            font-size: 14px;
        }
        /* Styling untuk kolom Status */
        td.status-hadir {
            color: #27ae60;
            font-weight: bold;
        }
        td.status-tidak-hadir {
            color: #c0392b;
            font-weight: bold;
        }
        /* Responsif untuk layar kecil */
        @media screen and (max-width: 600px) {
            table {
                font-size: 12px;
            }
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <h1>Daftar Kehadiran Mahasiswa</h1>
    <table>
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
                <td><?= htmlspecialchars($item['npm']) ?></td>
                <td><?= htmlspecialchars($item['nama_mahasiswa']) ?></td>
                <td><?= htmlspecialchars($item['tanggal']) ?></td>
                <td><?= htmlspecialchars($item['pertemuan']) ?></td>
                <td class="status-<?= strtolower(str_replace(' ', '-', $item['status'])) ?>">
                    <?= htmlspecialchars($item['status']) ?>
                </td>
                <td><?= htmlspecialchars($item['nama_matkul']) ?></td>
                <td><?= htmlspecialchars($item['nama_dosen']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>