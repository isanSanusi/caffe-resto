<?php
    // import koneksi database dari database.php
    require_once "services/database.php";
    session_start();

    $no_meja = "";
    $nama_pelanggan = "";

    // cek status login
    if($_SESSION['is_login'] == false) {
        header("location: login.php");
    }

    // cek parameter telah di set no_meja jika iya bernilai true 
    // dan no_meja tidak kosong maka bernilai true,
    // jika 22nya true maka isi variable no_meja dengan parameter tsb.
    // ini cara ambil data dari params
    if(isset($_GET['no_meja']) && $_GET['no_meja']) {
        $no_meja = $_GET['no_meja'];
    }
    if(isset($_GET['nama_pelanggan']) && $_GET['nama_pelanggan']) {
        $nama_pelanggan = $_GET['nama_pelanggan'];
    }

    // aksi button finis order
    if(isset($_POST['finish_order'])) {
        // variable untuk hari dan jam
        $hari = date("Y-m-d");
        $jam = date("H:i:s");

        //query untuk update meja
        $clear_meja_query = "UPDATE meja SET nama_pelanggan=NULL , jumlah_orang=NULL, status=0 WHERE no_meja='$no_meja' ";

        // query untuk setelah meja kosong masukan ke tabel history datanya
        $insert_history_query = "INSERT INTO history (`no_meja`,`nama_pelanggan`,`hari`,`jam`) VALUES('$no_meja','$nama_pelanggan','$hari','$jam')";

        //jalankan query nya
        $clear_meja = $database -> query($clear_meja_query);
        $insert_history = $database -> query($insert_history_query);

        //validasi jika meja kosong dan masukan datanya
        if($clear_meja && $insert_history) {
            header("location: index.php");
        } else {
            echo "Meja masih ada orangnya";
        }
        // setiap query berhasil di eksekusi tutup koneksi database
        $database -> close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Finish Order</title>
</head>
<body>

    <?php include("layouts/header.php") ?>
    <div class="super_center">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <button type="submit" name="finish_order">Kosongkan meja <?= $no_meja ?> atas nama <?= $nama_pelanggan ?> ?</button>
        </form>
    </div>
</body>
</html>