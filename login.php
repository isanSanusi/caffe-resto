<!-- Method Login -->
<!-- Ambil data dari database lalu compare dengan value inputan -->
<!-- setelah berhasil login alihkan ke page selanjutnya -->

<?php
    // call connections database
    require_once "services/database.php";
    session_start();
    $login_notification = "";

    // validasi agar jika sudah login tidak di arahkan ke page login lagi
    if(isset($_SESSION['is_login']) && $_SESSION['is_login']) {
        header('location: index.php');
    }

    // trigger button login untuk submit value input
    if(isset($_POST['btn_login'])) {
        // ambil value dari inputan yang akan di compare dan simpan dalam variable
        $username = $_POST['input_username'];
        $password = $_POST['input_password'];

        // compare data input dan tabel admin
        $select_query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password' ";
        $data_tabel_admin = $database -> query($select_query);

        // > 0 = jika ada datanya, maka:
        if($data_tabel_admin -> num_rows > 0) {
            $data_admin = $data_tabel_admin -> fetch_assoc();
            
            // jika admin telah login, buat session nya
            $_SESSION['is_login'] = true;
            $_SESSION['username'] = $data_admin['username'];

            // setelah login ,alihkan ke halaman index.php
            header('location: index.php');
        } else {
            // jika akun tidak ada beri notif
            $login_notification = "!! <span>Account not found</span> !!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to caffe</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="super_center">
        <h1> <?= $login_notification ?> </h1>
        <!-- <?php $_SERVER['PHP_SELF'] ?> = mengambil data di file saat ini -->
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1>Validation form</h1>
                <label for="username">Username</label>
                <input type="text" name="input_username" />
                <label for="password">Password</label>
                <input type="password" name="input_password" >
            <button type="submit" name="btn_login">Login</button>
        </form>   
    </div> 
</body>
</html>












