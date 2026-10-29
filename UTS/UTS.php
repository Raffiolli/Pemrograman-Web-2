<?php
session_start();

// Reset data jika tombol reset ditekan
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Inisialisasi daftar nama bulan
$daftar_bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

// Proses simpan data ke session
if (isset($_POST['simpan'])) {
    $kode = strtoupper(trim($_POST['kode_pendaftaran']));
    $nama = $_POST['nama_pendaftar'];
    $jk = $_POST['jk'];
    $tmp_lahir = $_POST['tmp_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $pekerjaan_ortu = $_POST['pekerjaan_ortu'];
    $mat = floatval($_POST['nilai_mat']);
    $ingg = floatval($_POST['nilai_ingg']);
    $umum = floatval($_POST['nilai_umum']);

    // Logika penguraian Kode Pendaftaran (Contoh: A2-101-9)
    $gedung_kode = substr($kode, 0, 1);
    $gelombang = substr($kode, 1, 1);
    
    $nama_gedung = match ($gedung_kode) {
        'A' => 'Gedung A',
        'B' => 'Gedung B',
        'V' => 'Viktor',
        default => 'Lainnya',
    };
    $tempat_tes = $nama_gedung . " - Gelombang " . $gelombang;

    // Bulan tes dari karakter paling akhir kode
    $karakter_terakhir = substr($kode, -1);
    $angka_bulan = intval($karakter_terakhir);
    $bulan_tes = $daftar_bulan[$angka_bulan] ?? '-';

    // Perhitungan Rata-rata Nilai
    $rata_rata = ($mat + $ingg + $umum) / 3;

    // Logika Keterangan Kelulusan
    if ($rata_rata >= 70) {
        $keterangan = "Lulus";
    } elseif ($rata_rata >= 60 && $rata_rata < 70) {
        $keterangan = "Cadangan";
    } else {
        $keterangan = "Tidak Lulus";
    }

    // Simpan ke array session
    $_SESSION['data_pendaftar'][] = [
        'kode' => $kode,
        'nama' => $nama,
        'tmp_lahir' => $tmp_lahir,
        'jk' => $jk,
        'tgl_lahir' => $tgl_lahir,
        'pek_ortu' => $pekerjaan_ortu,
        'tempat_tes' => $tempat_tes,
        'bln_tes' => $bulan_tes,
        'mat' => $mat,
        'ingg' => $ingg,
        'umum' => $umum,
        'rata_rata' => number_format($rata_rata, 2),
        'keterangan' => $keterangan
    ];
}

$data_list = $_SESSION['data_pendaftar'] ?? [];

// Hitung rekapitulasi data
$total_pendaftar = count($data_list);
$total_lulus = 0;
$total_tidak_lulus = 0;

foreach ($data_list as $row) {
    if ($row['keterangan'] === 'Lulus') {
        $total_lulus++;
    } elseif ($row['keterangan'] === 'Tidak Lulus') {
        $total_tidak_lulus++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran Mahasiswa Baru</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 13px; }
        .form-container { width: 450px; border: 1px solid #999; padding: 15px; margin-bottom: 25px; }
        .form-group { margin-bottom: 8px; display: flex; align-items: center; }
        .form-group label { width: 140px; }
        .form-group input[type="text"], .form-group input[type="number"], .form-group select, .form-group input[type="date"] {
            flex: 1; padding: 3px;
        }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; font-size: 12px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 5px; text-align: center; }
        .footer-rekap td { font-weight: bold; text-align: right; }
    </style>
</head>
<body>

    <div class="form-container">
        <h4 style="margin-top:0;">INPUT PENDAFTARAN</h4>
        <form method="POST" action="">
            <div class="form-group">
                <label>KODE PENDAFTARAN</label>
                <input type="text" name="kode_pendaftaran" placeholder="Contoh: A2-101-9" required>
            </div>
            <div class="form-group">
                <label>NAMA PENDAFTAR</label>
                <input type="text" name="nama_pendaftar" required>
            </div>
            <div class="form-group">
                <label>JENIS KELAMIN</label>
                <div>
                    <input type="radio" name="jk" value="Laki-Laki" id="jk_l" required> <label for="jk_l" style="width:auto;">Laki-Laki</label>
                    <input type="radio" name="jk" value="Perempuan" id="jk_p" required> <label for="jk_p" style="width:auto;">Perempuan</label>
                </div>
            </div>
            <div class="form-group">
                <label>TEMPAT LAHIR</label>
                <input type="text" name="tmp_lahir" required>
            </div>
            <div class="form-group">
                <label>TGL LAHIR</label>
                <input type="date" name="tgl_lahir" required>
            </div>
            <div class="form-group">
                <label>ASAL SEKOLAH</label>
                <input type="text" name="asal_sekolah">
            </div>
            <div class="form-group">
                <label>PEKERJAAN ORTU</label>
                <select name="pekerjaan_ortu" required>
                    <option value="">-- PILIH PEKERJAAN ORTU --</option>
                    <option value="PNS">PNS</option>
                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="TNI/Polri">TNI/Polri</option>
                    <option value="Buruh">Buruh</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            
            <p style="margin: 10px 0 5px 0; font-weight: bold;">NILAI TES</p>
            <div class="form-group">
                <label>MATEMATIKA</label>
                <input type="number" step="any" min="0" max="100" name="nilai_mat" required>
            </div>
            <div class="form-group">
                <label>BHS. INGGRIS</label>
                <input type="number" step="any" min="0" max="100" name="nilai_ingg" required>
            </div>
            <div class="form-group">
                <label>P. UMUM</label>
                <input type="number" step="any" min="0" max="100" name="nilai_umum" required>
            </div>

            <div style="margin-top: 12px;">
                <button type="submit" name="simpan">SIMPAN</button>
                <button type="submit" name="reset">RESET</button>
            </div>
        </form>
    </div>

    <h4>TABEL DATA</h4>
    <table>
        <thead>
            <tr>
                <th>Kode Pendf.</th>
                <th>Nama Pendf.</th>
                <th>Tmp. Lahir</th>
                <th>JK</th>
                <th>Tgl Lahir</th>
                <th>Pek. Ortu</th>
                <th>Tempat Tes</th>
                <th>Bln. Tes</th>
                <th>MAT</th>
                <th>INGG</th>
                <th>UMUM</th>
                <th>N. RATA</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data_list)): ?>
                <tr>
                    <td colspan="13">Belum ada data pendaftar.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data_list as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kode']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['tmp_lahir']) ?></td>
                        <td><?= htmlspecialchars($row['jk']) ?></td>
                        <td><?= htmlspecialchars($row['tgl_lahir']) ?></td>
                        <td><?= htmlspecialchars($row['pek_ortu']) ?></td>
                        <td><?= htmlspecialchars($row['tempat_tes']) ?></td>
                        <td><?= htmlspecialchars($row['bln_tes']) ?></td>
                        <td><?= $row['mat'] ?></td>
                        <td><?= $row['ingg'] ?></td>
                        <td><?= $row['umum'] ?></td>
                        <td><?= $row['rata_rata'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="footer-rekap">
                <td colspan="12">JUMLAH PENDAFTAR</td>
                <td style="text-align: center;"><?= $total_pendaftar ?></td>
            </tr>
            <tr class="footer-rekap">
                <td colspan="12">JUMLAH PESERTA LULUS</td>
                <td style="text-align: center;"><?= $total_lulus ?></td>
            </tr>
            <tr class="footer-rekap">
                <td colspan="12">JUMLAH TIDAK PESERTA LULUS</td>
                <td style="text-align: center;"><?= $total_tidak_lulus ?></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>