<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak RAB</title>
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      font-size: 13px;
      color: #222;
      margin: 30px;
      background: #fff;
    }

    h2, h4, h5, h6 {
      margin: 5px 0;
    }

    .header {
      text-align: center;
      margin-bottom: 25px;
      border-bottom: 3px solid #000;
      padding-bottom: 8px;
    }

    .header h2 {
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .info {
      margin-bottom: 15px;
      font-size: 13px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      border: 1px solid #aaa;
    }

    th {
      background: #f2f2f2;
      text-align: center;
      padding: 8px;
      font-weight: bold;
      border: 1px solid #aaa;
    }

    td {
      padding: 6px;
      border: 1px solid #aaa;
      vertical-align: top;
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }

    .section-title {
      background: #e8e8e8;
      padding: 5px 8px;
      border-left: 4px solid #000;
      margin: 25px 0 10px 0;
      font-weight: bold;
    }

    .total-box {
      border-top: 2px solid #000;
      text-align: right;
      padding: 10px 0;
      margin-top: 10px;
      font-size: 14px;
    }

    .signature {
      margin-top: 50px;
      text-align: right;
      font-size: 13px;
    }

    .signature small {
      display: block;
      margin-top: 3px;
    }

    /* Untuk tampilan cetak */
    @media print {
      body { margin: 0; }
      .header { border: none; }
      .section-title { background: #ddd !important; -webkit-print-color-adjust: exact; }
      th { background: #f2f2f2 !important; -webkit-print-color-adjust: exact; }
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>Rencana Anggaran Biaya (RAB)</h2>
    <p>Kode RAB: <b><?= $rab['kode_rab'] ?></b> &nbsp; | &nbsp; Rumah: <b><?= $rab['kode_rumah'] ?></b></p>
  </div>

  <!-- Rincian Bahan -->
  <div class="section-title">1. Rincian Bahan</div>
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
      <?php $no=1; foreach($rabBahan as $bahan): ?>
      <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td><?= $bahan['nama_bahan'] ?></td>
        <td class="text-center"><?= $bahan['jumlah_rencana'] ?></td>
        <td class="text-right">Rp <?= number_format($bahan['harga_satuan'],0,',','.') ?></td>
        <td class="text-right">Rp <?= number_format($bahan['sub_total'],0,',','.') ?></td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($rabBahan)): ?>
      <tr><td colspan="5" class="text-center">Tidak ada data bahan</td></tr>
      <?php endif; ?>
      <tr>
        <td colspan="4" class="text-right bold">Total Bahan</td>
        <td class="text-right bold">Rp <?= number_format($total_bahan,0,',','.') ?></td>
      </tr>
    </tbody>
  </table>

  <!-- Rincian Pekerja -->
  <div class="section-title">2. Rincian Pekerja</div>
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
      <?php $no=1; foreach($rabPekerja as $pk): ?>
      <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td><?= $pk['nama_kontraktor'] ?></td>
        <td class="text-center"><?= $pk['estimasi_hari'] ?></td>
        <td class="text-right">Rp <?= number_format($pk['biaya_kontraktor'],0,',','.') ?></td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($rabPekerja)): ?>
      <tr><td colspan="4" class="text-center">Tidak ada data pekerja</td></tr>
      <?php endif; ?>
      <tr>
        <td colspan="3" class="text-right bold">Total Pekerja</td>
        <td class="text-right bold">Rp <?= number_format($total_pekerja,0,',','.') ?></td>
      </tr>
    </tbody>
  </table>

  <!-- Total Keseluruhan -->
  <div class="total-box">
    <strong>Total Anggaran (RAB): Rp <?= number_format($total_semua, 0, ',', '.') ?></strong>
  </div>

  <div class="signature">
    <p>Jember, <?= date('d F Y') ?></p>
    <br><br><br>
    <p><strong>______________________</strong></p>
    <small>Mengetahui</small>
  </div>
</body>
</html>
