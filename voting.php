<?php
session_start();

if (!isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedChoices = json_decode($_POST['selectedChoices'], true);
    
    $votedFile = 'csv/voted.csv';
    $nama = $_SESSION['nama'];

    $dataToSave = [$nama, $selectedChoices['osis'], $selectedChoices['mps'], $selectedChoices['ldp']];

    $fp = fopen($votedFile, 'a');
    fputcsv($fp, $dataToSave);
    fclose($fp);

    header('Location: redirect.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kpoml - voting</title>
    <link rel="stylesheet" href="style-voting.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="voting-container">
        <div class="user-info">
            <p><?php echo $_SESSION['nama']; ?></p>
            <p class="not-you"><a href="login.php">Bukan kamu?</a></p>
        </div>

        <form id="voting-form" method="POST">
            <!-- Pemilihan OSIS -->
            <section class="voting-section" id="osis-section">
                <h1>Pemilihan OSIS</h1>
                <div class="card-container">
                    <div class="card" data-category="osis" data-id="osis-1">
                        <div class="card-image" style="background-image: url('foto-paslon/emir-azlan.JPG');"></div>
                        <div class="card-content">
                            <h3>Emir & Azlan</h3>
                            <a href="visi-misi/emir-azlan.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="osis" data-id="osis-2">
                        <div class="card-image" style="background-image: url('foto-paslon/fadel-rafa.JPG');"></div>
                        <div class="card-content">
                            <h3>Fadel & Rafa</h3>
                            <a href="visi-misi/fadel-rafa.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="osis" data-id="osis-3">
                        <div class="card-image" style="background-image: url('foto-paslon/arkan-anja.JPG');"></div>
                        <div class="card-content">
                            <h3>Arkan & Anja</h3>
                            <a href="visi-misi/arkan-anja.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pemilihan MPS -->
            <section class="voting-section" id="mps-section">
                <h1>Pemilihan MPS</h1>
                <div class="card-container">
                    <div class="card" data-category="mps" data-id="mps-1">
                        <div class="card-image" style="background-image: url('foto-paslon/naufal-diego.JPG');"></div>
                        <div class="card-content">
                            <h3>Naufal & Diego</h3>
                            <a href="visi-misi/afif-diego.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="mps" data-id="mps-2">
                        <div class="card-image" style="background-image: url('foto-paslon/gilang-delka.JPG');"></div>
                        <div class="card-content">
                            <h3>Delka & Gilang</h3>
                            <a href="visi-misi/delka-gilang.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pemilihan LDP -->
            <section class="voting-section" id="ldp-section">
                <h1>Pemilihan LDP</h1>
                <div class="card-container">
                    <div class="card" data-category="ldp" data-id="ldp-1">
                        <div class="card-image" style="background-image: url('foto-paslon/lita-guci.JPG');"></div>
                        <div class="card-content">
                            <h3>Lita & Guci</h3>
                            <a href="visi-misi/lita-guci.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="ldp" data-id="ldp-2">
                        <div class="card-image" style="background-image: url('foto-paslon/aan-sayyid.JPG');"></div>
                        <div class="card-content">
                            <h3>Aan & Sayyid</h3>
                            <a href="visi-misi/aan-sayyid.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                </div>

                <!-- Tampilan Pilihan -->
                <div class="selected-choices-container">
                    <div class="choices-display">
                        <span>OSIS: <span id="choice-osis">_</span></span>
                        <span>MPS: <span id="choice-mps">_</span></span>
                        <span>LDP: <span id="choice-ldp">_</span></span>
                        <button type="submit" class="submit-btn"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <input type="hidden" name="selectedChoices" id="selectedChoices">
            </section>
        </form>
    </div>

    <script>
        const selectedChoices = {
            osis: null,
            mps: null,
            ldp: null
        };

        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                const id = this.getAttribute('data-id');
                const choiceNumber = id.split('-')[1]; // Ambil nomor pilihan

                document.querySelectorAll(`.card[data-category="${category}"]`).forEach(otherCard => {
                    otherCard.classList.remove('selected');
                });

                this.classList.add('selected');
                // this.style.boxShadow = '0 0 10px rgba(0, 122, 255, 0.3)';

                selectedChoices[category] = choiceNumber;

                document.getElementById(`choice-${category}`).innerText = choiceNumber;
            });
        });

        document.querySelector('.submit-btn').addEventListener('click', function(event) {
            event.preventDefault();
            if (selectedChoices.osis && selectedChoices.mps && selectedChoices.ldp) {
                document.getElementById('selectedChoices').value = JSON.stringify(selectedChoices);
                document.getElementById('voting-form').submit();
            } else {
                alert('Silakan pilih semua kategori sebelum submit.');
            }
        });
    </script>
</body>
</html>
