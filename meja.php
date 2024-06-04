<?php 
    // import koneksi database dari database.php
    require_once "services/database.php";

    // validasi cek masih login atau tidak, jika tidak arahkan ke login page
    session_start();
    if($_SESSION['is_login'] == false) {
        header("location: login.php");
    }

    define('APP_NAME', 'NOMOR MEJA  ');

    $no_meja = "";
    $nama_pelanggan = "";

    if(isset($_GET['no_meja']) && $_GET['no_meja'] !== "") {
        $no_meja =  $_GET['no_meja'];
    }

    // jika parameter yang dikirim dari index.php berisi data , maka kirim datanya ke finish_order.php
    if(isset($_GET['nama_pelanggan']) && $_GET['nama_pelanggan'] !== "") {
        $nama_pelanggan =  $_GET['nama_pelanggan'];
        header("location: finish_order.php?no_meja=$no_meja&nama_pelanggan=$nama_pelanggan");
    }

    if(isset($_POST['update_meja'])) {
        // ambil value inputan dan kirim
        $nama_pelanggan = $_POST['nama_pelanggan'];
        $jumlah_orang = $_POST['jumlah_orang'];

        // kirim datanya untuk me-replace data di database tabel meja
        $update_meja_query = "UPDATE meja SET nama_pelanggan='$nama_pelanggan', jumlah_orang='$jumlah_orang', status=1 WHERE no_meja='$no_meja' ";
        $update_data_meja = $database -> query($update_meja_query);

        // jika terkirim arahkan ke index.php
        if($update_data_meja) {
            header("location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Form Isi data Meja</title>
</head>
<body>
    <?php include("layouts/header.php") ?>
    <div class="super_center">
        <h1><?= APP_NAME; echo $no_meja ?></h1>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="">Nama pelanggan</label>
                <input type="text" name="nama_pelanggan">
                <label for="">Jumlah orang</label>
                <input type="text" name="jumlah_orang">
            <button type="submit" name="update_meja">Update Meja</button>
        </form>
    </div>
</body>
</html>