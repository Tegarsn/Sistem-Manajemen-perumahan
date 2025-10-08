<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Realisasi Rumah</title>
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      font-size: 12px;
      color: #222;
      margin: 30px;
    }

    header {
      text-align: center;
      border-bottom: 3px double #333;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    header h1 {
      font-size: 20px;
      margin: 0;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    header p {
      font-size: 11px;
      margin: 3px 0 0 0;
    }

    h3 {
      background: #f2f2f2;
      padding: 6px;
      border-left: 4px solid #333;
      font-size: 14px;
      margin-top: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
      margin-bottom: 15px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 6px;
    }

    th {
      background-color: #f8f8f8;
      font-weight: bold;
      text-align: center;
    }

    td {
      vertical-align: top;
    }

    .right { text-align: right; }
    .bold { font-weight: bold; }

    .summary-box {
      border: 1px solid #aaa;
      padding: 10px;
      background: #f9f9f9;
      margin-top: 15px;
      width: 45%;
      float: right;
    }

    .summary-box p {
      margin: 3px 0;
      font-size: 13px;
    }

    .footer {
      clear: both;
      margin-top: 80px;
      text-align: right;
    }

    .signature {
      margin-top: 60px;
      text-align: center;
      width: 200px;
      float: right;
    }

    .signature .line {
      border-top: 1px solid #000;
      margin-top: 60px;
      padding-top: 5px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <h1>LAPORAN REALISASI RUMAH</h1>
    <p>Sistem Informasi Manajemen Proyek Perumahan</p>
  </header>

  <section>
    <table style="margin-bottom:10px;">
      <tr>
        <td width="25%"><b>Kode Rumah</b></td>
        <td>: <?= $realisasi['kode_rumah'] ?></td>
      </tr>
      <tr>
        <td><b>Tanggal Mulai</b></td>
        <td>: <?= date('d-m-Y', strtotime($realisasi['tanggal_mulai'])) ?></td>
      </tr>
      <tr>
        <td><b>Tanggal Selesai</b></td>
        <td>: <?= date('d-m-Y', strtotime($realisasi['tanggal_selesai'])) ?></td>
      </tr>
    </table>
  </section>

  <!-- BAGIAN 1 -->
  <h3>1. Bahan Bangunan</h3>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Bahan</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Sub Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalBahan = 0; foreach($realisasiBahan as $i => $b): 
        $subTotal = $b['jumlah'] * $b['harga_satuan'];
        $totalBahan += $subTotal;
      ?>
      <tr>
        <td align="center"><?= $i+1 ?></td>
        <td><?= $b['nama_bahan'] ?></td>
        <td align="center"><?= $b['jumlah'] ?></td>
        <td class="right">Rp <?= number_format($b['harga_satuan'],0,',','.') ?></td>
        <td class="right">Rp <?= number_format($subTotal,0,',','.') ?></td>
      </tr>
      <?php endforeach; ?>
      <tr class="bold">
        <td colspan="4" class="right">Total Bahan</td>
        <td class="right">Rp <?= number_format($totalBahan,0,',','.') ?></td>
      </tr>
    </tbody>
  </table>

  <!-- BAGIAN 2 -->
  <h3>2. Biaya Pekerja</h3>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Kontraktor</th>
        <th>Jumlah Hari</th>
        <th>Biaya</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalPekerja = 0; foreach($realisasiPekerja as $i => $p): 
        $totalPekerja += $p['biaya_kontraktor'];
      ?>
      <tr>
        <td align="center"><?= $i+1 ?></td>
        <td><?= $p['nama_kontraktor'] ?></td>
        <td align="center"><?= $p['jumlah_hari'] ?></td>
        <td class="right">Rp <?= number_format($p['biaya_kontraktor'],0,',','.') ?></td>
      </tr>
      <?php endforeach; ?>
      <tr class="bold">
        <td colspan="3" class="right">Total Pekerja</td>
        <td class="right">Rp <?= number_format($totalPekerja,0,',','.') ?></td>
      </tr>
    </tbody>
  </table>

  <!-- BAGIAN 3 -->
  <h3>3. Pekerjaan Insidentil</h3>
  <?php if (!empty($pekerjaanInsidentil)): ?>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pekerjaan</th>
        <th>Mandor</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Total Biaya</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalInsidentil = 0; foreach ($pekerjaanInsidentil as $i => $ins): ?>
      <tr>
        <td align="center"><?= $i+1 ?></td>
        <td><?= esc($ins['nama_pekerjaan']) ?></td>
        <td><?= esc($ins['nama_mandor']) ?></td>
        <td align="center"><?= date('d-m-Y', strtotime($ins['tanggal'])) ?></td>
        <td><?= esc($ins['keterangan']) ?></td>
        <td class="right">Rp <?= number_format($ins['total_biaya'], 0, ',', '.') ?></td>
        <td align="center"><?= ucfirst($ins['status']) ?></td>
      </tr>
      <?php 
        if ($ins['status'] === 'approved') {
          $totalInsidentil += $ins['total_biaya'];
        }
      endforeach; ?>
      <tr class="bold">
        <td colspan="5" class="right">Total Insidentil (Approved)</td>
        <td colspan="2" class="right">Rp <?= number_format($totalInsidentil,0,',','.') ?></td>
      </tr>
    </tbody>
  </table>
  <?php else: ?>
    <p><i>Tidak ada pekerjaan insidentil.</i></p>
  <?php endif; ?>

  <!-- RINGKASAN TOTAL -->
  <?php $grandTotal = $totalBahan + $totalPekerja + ($totalInsidentil ?? 0); ?>
  <div class="summary-box">
    <p><b>Total Bahan:</b> Rp <?= number_format($totalBahan,0,',','.') ?></p>
    <p><b>Total Pekerja:</b> Rp <?= number_format($totalPekerja,0,',','.') ?></p>
    <p><b>Total Insidentil (Approved):</b> Rp <?= number_format($totalInsidentil,0,',','.') ?></p>
    <hr>
    <p><b>Total Realisasi Keseluruhan:</b><br>
      <span style="font-size:14px;">Rp <?= number_format($grandTotal,0,',','.') ?></span>
    </p>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <p>Jember, <?= date('d F Y') ?></p>
  </div>

  <div class="signature">
    <div class="line">Mengetahui</div>
  </div>
</body>
</html>
