<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header('Location: login.php'); // kalau belum login, redirect ke login
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Voting</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
      }

      body, html {
          font-family: 'Poppins', sans-serif;
          background-image: linear-gradient(to bottom, rgba(0, 122, 255, 0.05), rgba(0, 122, 255, 0.15));
          color: #333;
          height: 100vh;
          width: 100vw;
          display: flex;
          justify-content: center;
          align-items: center;
          flex-direction: column;
      }

      .container {
          background-color: rgba(255, 255, 255, 0.4);
          backdrop-filter: blur(20px);
          -webkit-backdrop-filter: blur(20px);
          border-radius: 20px;
          padding: 40px 60px;
          text-align: center;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
          animation: fadeIn 0.6s ease-out;
          transition: transform 0.3s;
      }

      @keyframes fadeIn {
          from {
              opacity: 0;
              transform: translateY(-20px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }

      .container h1 {
          font-size: 2rem;
          color: #007aff;
          margin-bottom: 20px;
      }

      p {
          font-size: 1.2rem;
          color: #555;
      }

      .emoji {
          font-size: 3rem;
          margin-bottom: 20px;
      }

      .redirect-info {
          font-size: 1rem;
          color: #888;
          margin-top: 20px;
      }

      .redirect-info span {
          color: #007aff;
      }
    </style>
    <script>
      let countdown = 5;

      function startCountdown() {
          const countdownElement = document.getElementById('countdown');
          const interval = setInterval(() => {
              countdown--;
              countdownElement.innerText = countdown;

              if (countdown <= 0) {
                  clearInterval(interval);
                  window.location.href = 'login.php';
              }
          }, 1000);
      }

      window.onload = startCountdown;
    </script>
</head>
<body>
    <div class="container">
        <div class="emoji">🎉</div>
        <h1>Terima Kasih :D</h1>
        <p class="thank-you-message">Kamu sudah berhasil melakukan voting!</p>
    </div>
    <p class="redirect-info">Kamu akan kembali ke halaman login dalam <span id="countdown">5</span> detik...</p>
</body>
</html>
