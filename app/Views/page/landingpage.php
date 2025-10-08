<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Landing Page Jual Rumah</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('https://images.unsplash.com/photo-1600607688188-cf5d6e4caa3d') center/cover fixed no-repeat;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.85);
      z-index: -1;
    }

    header {
      background: linear-gradient(to right, #4CAF50, #2E7D32);
      padding: 1rem 2rem;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    nav a {
      color: white;
      margin-left: 1.5rem;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #C8E6C9;
    }

    .hero {
      background: linear-gradient(rgba(0, 100, 0, 0.7), rgba(0, 100, 0, 0.7)), url('https://source.unsplash.com/1600x600/?real-estate,green') center/cover no-repeat;
      color: white;
      padding: 5rem 2rem;
      text-align: center;
      border-bottom-left-radius: 40px;
      border-bottom-right-radius: 40px;
    }

    .hero h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .search-box {
      margin-top: 1.5rem;
    }

    .search-box input {
      padding: 0.8rem 1rem;
      border-radius: 30px;
      border: none;
      width: 80%;
      max-width: 500px;
      font-size: 1rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    main {
      background: url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
      background-attachment: fixed;
      padding: 3rem 2rem;
      backdrop-filter: blur(3px);
    }

    .section-title {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2.5rem;
      color: #ffffffff;
      /* text-shadow: 1px 1px 2px #fff; */
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 2rem;
    }

    .card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
      width: 300px;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.25);
    }

    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .card-content {
      padding: 1rem;
    }

    .card-content h3 {
      margin-bottom: 0.5rem;
      color: #388e3c;
    }

    .card-content p {
      font-size: 0.95rem;
      color: #555;
    }

    footer {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 1.5rem 1rem;
      margin-top: auto;
    }

    footer a {
      color: #BBDEFB;
      margin: 0 10px;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2rem;
      }

      .card {
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <header>
    <h2>GreenHome.id</h2>
    <nav>
      <a href="#">Beranda</a>
      <a href="#">Tentang</a>
      <a href="#">Daftar Rumah</a>
      <a href="#">Kontak</a>
    </nav>
  </header>

  <section class="hero">
    <h1>Lingkungan Asri, Hidup Lebih Harmonis</h1>
    <div class="search-box">
      <input type="text" placeholder="Cari rumah berdasarkan lokasi, tipe, harga..." />
    </div>
  </section>

  <main>
    <div class="section-title">Daftar Rumah</div>
    <div class="card-container">
      <div class="card">
        <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80" alt="Rumah Modern" />
        <div class="card-content">
          <h3>Rumah Modern</h3>
          <p>Lokasi strategis, 3 kamar tidur, harga mulai 500jt.</p>
        </div>
      </div>
      <div class="card">
        <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80" alt="Rumah Klasik" />
        <div class="card-content">
          <h3>Rumah Klasik</h3>
          <p>Dekat alam, lingkungan tenang, harga mulai 400jt.</p>
        </div>
      </div>
      <div class="card">
        <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80" alt="Rumah Mewah" />
        <div class="card-content">
          <h3>Rumah Mewah</h3>
          <p>Desain elegan, 5 kamar tidur, kolam renang pribadi.</p>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 GreenHome.id — Semua Hak Dilindungi</p>
    <div style="margin-top: 1rem;">
      <a href="https://instagram.com/greenhomeid" target="_blank">Instagram</a> |
      <a href="https://facebook.com/greenhomeid" target="_blank">Facebook</a> |
      <a href="mailto:info@greenhome.id">Email</a> |
      <span>📞 0812-3456-7890</span>
    </div>
  </footer>
</body>
</html>
