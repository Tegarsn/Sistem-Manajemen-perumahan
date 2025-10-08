<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>
<body>
  <div class="container1">
    <!-- Sidebar -->
    <div class="sidebar1" id="sidebar">
      <div>
        <h4>
          Sistem Manajemen Perumahan
        </h4>
        <div class="nav1">
          <a class=" menu-link" href="/dashboard"><span class="material-icons rotate-icon">dashboard</span> Dashboard</a>
          <!-- Manajemen Marketing -->
           <div class="menu-dropdown">
            <button class="dropdown-btn">
               <span class="material-icons rotate-icon">analytics</span> Marketing
              <span class="material-icons arrow">expand_more</span>
            </button>
            <div class="dropdown-container">
            <a class="menu-link"href="/data-customer"><span class="material-icons rotate-icon">groups</span> Data Customer</a>
             <a class="menu-link"href="/pembatalan-transaksi"><span class="material-icons rotate-icon">remove_shopping_cart</span> Pembatalan Transaksi</a>
            </div>
           </div>

          <!-- Manejemen Proyek -->
          <div class="menu-dropdown">
            <button class="dropdown-btn">
              <span class="material-icons rotate-icon">business_center</span> Manajemen Proyek
              <span class="material-icons arrow">expand_more</span>
            </button>
            <div class="dropdown-container">
              <a class="menu-link" href="/data-bahan" style="margin-top: 10px;">
                <span class="material-icons rotate-icon">construction</span> Bahan Bangunan
              </a>
              <a class="menu-link" href="/data-rumah">
                <span class="material-icons rotate-icon">home_work</span> Data Rumah
              </a>
               </a>
               <a class="menu-link" href="/rab-rumah">
                <span class="material-icons rotate-icon">description</span> RAB Rumah
              </a>
               <a class="menu-link" href="/rab-bahan">
                <span class="material-icons rotate-icon">description</span> RAB Bahan
              </a>
              <a class="menu-link" href="/rab-pekerja">
                <span class="material-icons rotate-icon">description</span> RAB Pekerja
              </a>
               <a class="menu-link" href="/realisasi-rumah">
                <span class="material-icons rotate-icon">description</span> Realisasi Rumah
              </a>
               <a class="menu-link" href="/realisasi-bahan">
                <span class="material-icons rotate-icon">description</span> Realisasi Bahan
              </a>
              <a class="menu-link" href="/realisasi-pekerja">
                <span class="material-icons rotate-icon">description</span> Realisasi Pekerja
              </a>
              <a class="menu-link" href="/data-bahan-pembangunan">
                <span class="material-icons rotate-icon">business</span> Data Bahan Pembangunan
              </a>
               <a class="menu-link" href="/pekerjaan-insidentil">
                <span class="material-icons rotate-icon">architecture</span> Data Pekerjaan Insidentil
              </a>
            </div>
        </div>
        <!-- Manajemen LOgistik -->
        <div class="menu-dropdown">
            <button class="dropdown-btn">
              <span class="material-icons rotate-icon">fact_check</span> Manajemen Logistik
              <span class="material-icons arrow">expand_more</span>
            </button>
            <div class="dropdown-container">
              <a class="menu-link" href="data-pembelian-bahan"><span class="material-icons rotate-icon">shopping_cart</span> Data Pembelian Bahan</a>
              <a class="menu-link" href="/detail-pembelian-bahan"><span class="material-icons rotate-icon">receipt_long</span> Detail Pembelian  Bahan</a> 
            </div>
        </div>
        <!-- Manajemen Keuangan -->
        <div class="menu-dropdown">
           <button class="dropdown-btn">
            <span class="material-icons rotate-icon">monetization_on </span> Keuangan
            <span class="material-icons arrow">expand_more</span>
           </button>
           <div class="dropdown-container" style="margin-top: 10px;">
            <a class="menu-link active" href="/pembelian-rumah"><span class="material-icons rotate-icon">real_estate_agent</span> Data Pembelian Rumah</a>
           </div>
        </div> 
        <!-- Menu Master -->
         <div class="menu-dropdown">
           <button class="dropdown-btn">
            <span class="material-icons rotate-icon">folder_open</span> Menu Master
            <span class="material-icons arrow">expand_more</span>
           </button>
           <div class="dropdown-container">
            <a class="menu-link"href="/data-user"><span class="material-icons rotate-icon">groups</span> Data User</a>
            <a class="menu-link"href="/data-user"><span class="material-icons rotate-icon">engineering</span> Data Mandor</a>
            <a class="menu-link"href="/data-user"><span class="material-icons rotate-icon">supervisor_account</span> Data SPV</a>
           </div>
        </div>
        </div>
      </div>
      <div class="logout">
        <a href="/logout"><span class="material-icons">logout</span> Logout</a>
      </div>
    </div>
    <!-- Main -->
    <div class="main">
      <!-- Navbar -->
      <div class="navbar1">
        <span class="material-icons toggle-btn" onclick="toggleSidebar()">menu</span>
        <div class="search">
          
        </div>
        <div class="actions">
          <div class="notifications">
            <span class="material-icons">notifications</span>
            <span class="badge">3</span>
          </div>
          <div class="profile">
            <img src="https://i.pravatar.cc/40" alt="Profile">
          </div>
        </div>
      </div>
      <!-- Content -->
      <div class="content1">
        <h2>Sistem Manajemen Informasi Perumahan</h1>
        <h2>Data Pembelian rumah</h2>
        <div class="table-header">
          <!-- <a class="add-btn1" onclick="openCreateForm()">+ Tambah Data</a> -->
          <button onclick="openCreateForm()" class="add-btn1">
              <i class="fas fa-plus me-1"></i> Tambah Data
          </button>


        </div>  
          <table  id="pembelianRumahTable" class="display table table-striped table-bordered w-100">
              <thead>
                  <tr>
                    
                      <th>Nama Customer</th>
                      <th>Kode Rumah</th>
                      <th>Tanggal</th>
                      <th>Harga</th>
                      <th>Status</th>
                      <th>Metode</th>
                      <th>action</th>
                  </tr>
              </thead>
              <tbody>
                 
              </tbody>
          </table>
           <style>
            #pembelianRumahTable thead th {
                background-color: #1a5590ff;
                color: #ecf0f1;
                text-align: center;
            }
          </style>
      </div>
        <footer class="footer1">
            <p>&copy; <?= date('Y') ?> Sistem Manajemen Informasi Perumahan. All rights reserved.</p>
        </footer>
    </div>

    <!-- Modal Tambah dan Edit -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalFormLabel">Form Pembelian Rumah</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form onsubmit="event.preventDefault(); simpanForm();">
            <div class="modal-body">
            <input type="hidden" name="id">
            <!-- Customer -->
            <div class="mb-3">
                <label for="customer_id" class="form-label">Nama Customer</label>
                <select class="form-control" name="customer_id" required>
                <option value="">-- Nama Customer --</option>
                <?php foreach ($customer as $cs): ?>
                    <option value="<?= $cs['id']; ?>"><?= $cs['nama']; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <!-- Kode Rumah -->
            <!-- Kode Rumah -->
            <div class="mb-3">
            <label for="perumahan_id" class="form-label">Kode Rumah</label>
            <select name="perumahan_id" class="form-control" required>
                <option value="">-- Pilih Rumah --</option>   
                <?php foreach ($perumahan as $item): ?>
                    <?php
                        // Tentukan warna berdasarkan status
                        switch (strtolower($item['status'])) {
                            case 'terjual':
                                $style = 'background-color:#f8d7da;color:#842029;'; // merah
                                $labelStatus = ' (Sudah Terjual)';
                                break;
                            case 'proses pembangunan':
                                $style = 'background-color:#fff3cd;color:#856404;'; // kuning
                                $labelStatus = ' (Proses Pembangunan)';
                                break;
                            case 'dijual':
                                $style = 'background-color:#d4edda;color:#155724;'; // hijau
                                $labelStatus = ' (Dijual)';
                                break;
                            default:
                                $style = '';
                                $labelStatus = '';
                                break;
                        }
                    ?>
                    <option value="<?= $item['id']; ?>" style="<?= $style ?>">
                        <?= $item['kode_rumah']; ?><?= $labelStatus ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </div>
            <!-- Tanggal -->
            <div class="mb-3">
                <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                <input type="date" class="form-control" name="tanggal_pembelian" required>
            </div>
            <!-- Harga -->
            <div class="mb-3">
                <label for="harga_beli" class="form-label">Harga Beli</label>
                <input type="number" class="form-control" name="harga_beli" placeholder="Contoh: 3000000000" required>
            </div>
            <!-- Status Pembelian -->
            <div class="mb-3">
                <label for="status_pembelian" class="form-label">Status Pembelian</label>
                <select name="status_pembelian" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Lunas">Lunas</option>
                <option value="Cicil">Cicil</option>
                <option value="DP">DP</option>
                <option value="Batal">Batal</option>
                </select>
            </div>
            <!-- Metode Pembayaran -->
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Cash">Cash</option>
                <option value="KPR">KPR</option>
                <option value="Cicilan Internal">Cicilan Internal</option>
                </select>
            </div>
            <!-- Status Dokumen -->
            <div class="mb-3">
                <label for="status_dokumen" class="form-label">Status Dokumen</label>
                <select name="status_dokumen" class="form-control" required>
                <option value="">-- Pilih Status Dokumen --</option>
                <option value="Lengkap">Lengkap</option>
                <option value="Pending">Pending</option>
                <option value="Verifikasi">Verifikasi</option>
                </select>
            </div>
            <!-- Request Khusus -->
            <div class="mb-3">
                <label for="request_khusus" class="form-label">Request Khusus</label>
                <textarea class="form-control" name="request_khusus" rows="2" placeholder="Contoh: Tambah pagar depan"></textarea>
            </div>
            <!-- Catatan Marketing -->
            <div class="mb-3">
                <label for="catatan_marketing" class="form-label">Catatan Marketing</label>
                <textarea class="form-control" name="catatan_marketing" rows="2" placeholder="Contoh: Dari pameran Expo, Instagram Ads, dll."></textarea>
            </div>
            <div class="mb-3">
            <label for="pembatalan_transaksi" class="form-label">Pembatalan Transaksi</label><br>
              <!-- Tombol trigger collapse -->
              <button id="btnBatal" class="btn btn-sm btn-danger mb-1" type="button" 
                      data-bs-toggle="collapse" data-bs-target="#textareaBatal" 
                      aria-expanded="false" aria-controls="textareaBatal">
                Batalkan Pembelian ? 
              </button> <br>
              <label for="pembatalan_transaksi" class="form-label">Jangan Gunakan Button Batalkan Pembelian ketika melakukan Input Data</label>
              <!-- Textarea di dalam collapse -->
              <div class="collapse mt-2" id="textareaBatal">
                <label for="keterangan_batal" class="form-label">Keterangan Pembatalan</label>
                <textarea id="keterangan_batal" name="alasan_pembatalan" class="form-control" rows="3"></textarea>
              </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Modal Detail Data -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-info text-white">
            <h5 class="modal-title" id="detailModalLabel">Detail Pembelian Rumah</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <tbody>
                <tr><th>Nama Customer</th><td id="detailCustomer"></td></tr>
                <tr><th>Kode Rumah</th><td id="detailKodeRumah"></td></tr>
                <tr><th>Tanggal</th><td id="detailTanggal"></td></tr>
                <tr><th>Harga</th><td id="detailHarga"></td></tr>
                <tr><th>Status Pembelian</th><td id="detailStatusPembelian"></td></tr>
                <tr><th>Metode Pembayaran</th><td id="detailMetode"></td></tr>
                <tr><th>Status Dokumen</th><td id="detailDokumen"></td></tr>
                <tr><th>Request Khusus</th><td id="detailRequest"></td></tr>
                <tr><th>Catatan Marketing</th><td id="detailCatatan"></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL HAPUS -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Apakah kamu yakin ingin menghapus data ini?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">Hapus</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL KONFIRMASI PESAN BERHASIL DIHAPUS -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content bg-success text-black">
          <div class="modal-header border-0">
            <h5 class="modal-title" id="successModalLabel">✔️ Berhasil</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <p id="successMessage">Data berhasil dihapus!</p>
          </div>
        </div>
      </div>
    </div>
  

  </div>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");
      sidebar.classList.toggle("active");
      
    }
    function showSuccess(message = 'Data berhasil diproses.') {
        $('#successMessage').text(message);
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
        setTimeout(() => {
          modal.hide();
        }, 2500);
    }

  
 document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', function () {
    this.parentElement.classList.toggle('aktif');
    });
  });
  </script>
  <script src="<?= base_url('assets/js/pembelianrumah.js') ?>"></script>
    
</body>
</html>
