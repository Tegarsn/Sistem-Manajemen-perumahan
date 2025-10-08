<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Sistem Manajemen Perumahan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      top: 0;
      left: 0;
      z-index: 1;
    }

    .login-box {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.9);
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 20px 30px rgba(0, 0, 0, 0.3);
      width: 100%;
      max-width: 400px;
      animation: slideIn 0.6s ease;
      backdrop-filter: blur(5px);
    }

    @keyframes slideIn {
      from {
        transform: translateY(-50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .login-box h2 {
      margin-bottom: 25px;
      color: #333;
      text-align: center;
    }

    .login-box label {
      font-weight: 600;
      color: #444;
      display: block;
      margin-bottom: 6px;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 94%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      transition: border-color 0.3s ease;
    }

    .login-box input:focus {
      border-color: #764ba2;
      outline: none;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-box button:hover {
      background: linear-gradient(to right, #764ba2, #667eea);
    }

    .footer-text {
      text-align: center;
      margin-top: 15px;
      color: #555;
      font-size: 14px;
    }

    .footer-text a {
      color: #764ba2;
      text-decoration: none;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="login-box">
    <h2>Login</h2>
    <form action="/login/auth" method="post">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Masuk</button>
    </form>
    <div class="footer-text">
      <!-- Belum punya akun? <a href="/register">Daftar</a> <br>
      <a href="/lupapassword">Lupa Password?</a> -->
    </div>
  </div>
</body>
</html>
