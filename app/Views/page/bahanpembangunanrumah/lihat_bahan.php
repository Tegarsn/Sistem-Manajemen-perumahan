<?php if (empty($bahan_pembangunan)): ?>
  <div class="alert alert-warning">Tidak ada data bahan pembangunan untuk rumah ini.</div>
<?php else: ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nama Bahan</th>
        <th>Jumlah Pemakaian</th>
        <th>Tanggal Penggunaan</th>
        <th>Keterangan</th>
        <th>Nama Mandor</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bahan_pembangunan as $b): ?>
        <tr>
          <td><?= esc($b['nama_bahan']) ?></td>
          <td><?= esc($b['jumlah_pemakaian']) ?></td>
          <td><?= esc($b['tanggal_penggunaan']) ?></td>
          <td><?= esc($b['keterangan']) ?></td>
          <td><?= esc($b['nama_mandor'])?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
