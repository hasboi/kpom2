<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kpoml - login</title>
  <link rel="stylesheet" href="style-login.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="login-container">
      <h1>Login</h1>
      <form id="loginForm" action="login_process.php" method="POST">
        <input type="text" id="nis" name="nis" placeholder="Masukkan NIS" required>
        <button type="submit" class="submit-btn"><i class="fa-solid fa-arrow-right"></i></button>
      </form>
      <small id="error-msg-format" class="error-msg" style="display: none;">
        <i class="fa-solid fa-circle-exclamation"></i> NIS hanya boleh berisi angka
      </small>
      <small id="error-msg-nis" class="error-msg" style="display: none;">
        <i class="fa-solid fa-circle-exclamation"></i> Tidak bisa menemukan ID kamu
      </small>
      <small id="error-msg-user-voted" class="error-msg" style="display: none;">
        <i class="fa-solid fa-circle-exclamation"></i> Kamu sudah melaksanakan voting
      </small>
    </div>

  <script>
    document.getElementById('nis').addEventListener('keypress', function(event) {
      const char = String.fromCharCode(event.which);
      const allowedChars = /^[0-9]+$/;
      
      if (!allowedChars.test(char)) {
        event.preventDefault();
      }

      if (event.key === 'Enter') {
        event.preventDefault();
        document.getElementById('loginForm').submit();
      }
    });

    // validasi nis pas submit
    document.getElementById('loginForm').addEventListener('submit', function(event) {
      const nisInput = document.getElementById('nis');
      const nisValue = nisInput.value;
      const allowedFormat = /^[0-9]+$/;
      const errorMsgFormat = document.getElementById('error-msg-format');

      if (!allowedFormat.test(nisValue)) {
        event.preventDefault();
        nisInput.classList.add('error');
        errorMsgFormat.style.display = 'flex';
      } else {
        nisInput.classList.remove('error');
        errorMsgFormat.style.display = 'none';
      }
    });

    // ini buat ngecek parameter error
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('error') === 'nis_invalid') {
      const nisInput = document.getElementById('nis');
      const errorMsgNis = document.getElementById('error-msg-nis');
      
      nisInput.classList.add('error');
      errorMsgNis.style.display = 'flex'; 
    }
    
    if (urlParams.get('error') === 'user_already_voted') {
      const nisInput = document.getElementById('nis');
      const errorMsgUserVoted = document.getElementById('error-msg-user-voted');
      nisInput.classList.add('error');
      errorMsgUserVoted.style.display = 'flex';
    }

    document.getElementById('nis').addEventListener('focus', function() {
      this.classList.remove('error');
      this.style.boxShadow = '0 0 10px rgba(0, 122, 255, 0.3)'; // saat fokus
    });

    document.getElementById('nis').addEventListener('blur', function() {
      this.style.boxShadow = 'none';
    });
  </script>
</body>
</html>
