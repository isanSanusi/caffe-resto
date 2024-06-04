<?php
    // import koneksi database dari database.php
    require_once "services/database.php";

    // validasi cek masih login atau tidak, jika tidak arahkan ke login page
    session_start();
    if($_SESSION['is_login'] == false) {
        header("location: login.php");
    }

    define("APP_NAME", "Sans Caffe & Resto");

    // ambil data dari tabel meja 
    $select_meja_query = "SELECT * FROM meja";
    $count_meja_query = "SELECT COUNT(status) as total_count, SUM(status=1) as total_row FROM meja";

    $data_tabel_meja = $database -> query($select_meja_query);
    $count_meja = $database -> query($count_meja_query);

    $result = $count_meja -> fetch_assoc();
    $jumlah_meja = $result['total_count'];
    $meja_isi = $result['total_row'];

    $is_full = false;
    if($jumlah_meja == $meja_isi) {
        $is_full = true;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title> <?= APP_NAME ?> </title>
</head>
<body>
    <?php include("layouts/header.php") ?>

    <?php
        $sisa_meja = $jumlah_meja - $meja_isi;
        if($is_full) {
            echo "<h2>Meja Penuh</h2>";
        } else {
            echo "<h2> $sisa_meja Meja Kosong</h2>";
        }
    ?>
    
    <div class="container">
        <!-- looping data tabel meja  -->
        <?php foreach ( $data_tabel_meja as $meja ) { ?>
            <!-- kirim parameter berisi data meja dengan onclick js ke meja.php -->
            <div class="card" onclick="goToMeja(`<?= $meja['no_meja']?>`, `<?= $meja['nama_pelanggan'] ?>`)">
            <!-- menampilkan data dari tabel meja , no meja dan nama pelanggan -->
                <p><?= $meja['no_meja'] . " " . $meja['type_meja']; ?></p>
                <br />
                <p>
                    <?= $meja['nama_pelanggan'] == NULL && $meja['jumlah_orang'] == NULL ? "Meja Kosong" : $meja['nama_pelanggan'] . " " . $meja['jumlah_orang'] ." Orang"; ?>
                </p>
            </div>
            <?php } ?>
    </div>

    <script src="assets/js/scripts.js"></script>
</body>
</html>





