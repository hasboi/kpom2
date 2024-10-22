<?php
// baca csv dan cek nis
function checkNisInCsv($nis) {
    $file = fopen('data.csv', 'r');
    fgetcsv($file);
    
    while (($data = fgetcsv($file)) !== FALSE) {
        $csvNis = $data[0];
        $csvNama = $data[1];
        
        if ($csvNis == $nis) {
            fclose($file);
            return $csvNama; // return nama user kalau nis valid
        }
    }
    
    fclose($file);
    return false; // return false kalau nis tidak ditemukan
}

// fungsi buat cek apakah nama sudah voting
function checkUserAlreadyVoted($nama) {
    $file = fopen('csv/voted.csv', 'r');
    while (($data = fgetcsv($file)) !== FALSE) {
        if ($data[0] == $nama) {
            fclose($file);
            return true; // sudah voting
        }
    }
    fclose($file);
    return false; // belum voting
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = $_POST['nis'];

    // validasi nis di csv
    $nama = checkNisInCsv($nis);

    if ($nama) {
        // cek apakah pengguna sudah voting
        if (checkUserAlreadyVoted($nama)) {
            // jika sudah voting, redirect dengan pesan error
            header('Location: login.php?error=user_already_voted');
            exit;
        }

        // login sukses, redirect ke halaman voting pake nama user
        session_start();
        $_SESSION['nama'] = $nama; // simpan nama user ke session biar bisa dipake di voting.php
        header('Location: voting.php');
        exit;
    } else {
        // kalo nis gak ada, balik ke halaman login dengan parameter error
        header('Location: login.php?error=nis_invalid');
        exit;
    }
}
?>
