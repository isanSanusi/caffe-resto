<?php
// Import library TCPDF dan koneksi
require_once "services/PDF/tcpdf.php";
require_once "services/database.php";

session_start();
if($_SESSION['is_login'] == false) {
    header("location: login.php");
    exit();
}

if(isset($_POST['report'])) {
    $hari = $_POST['hari'];

    // Membuat instance kelas TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set judul dokumen
    $pdf->SetTitle('Laporan Pengunjung');

    // Tambahkan halaman baru
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', 'B', 14);

    // Ambil semua data di tabel history
    $select_history_query = "SELECT * FROM history WHERE hari='$hari'";
    $select_history = $database->query($select_history_query);

    if($select_history->num_rows > 0 ) {
        // Tulis jumlah pengunjung
        $pdf->Cell(0, 10, "Total " . $select_history->num_rows . " pengunjung pada $hari", 0, 1, 'C');

        // Tambahkan spasi
        $pdf->Ln();

        // Hitung posisi tengah halaman untuk tabel
        // $centerX = ($pdf->getPageWidth() - $pdf->GetStringWidth("No. MejaNama PelangganHari KeluarJam Keluar")) / 4;
        // $pdf->SetX($centerX);

        // Tabel header
        $pdf->Cell(38, 10, "No. Meja", 1, 0, 'C');
        $pdf->Cell(50, 10, "Nama Pelanggan", 1, 0, 'C');
        $pdf->Cell(50, 10, "Hari Keluar", 1, 0, 'C');
        $pdf->Cell(50, 10, "Jam Keluar", 1, 1, 'C');

        // Tampilkan data
        while($history = $select_history->fetch_assoc()) {
            $pdf->Cell(38, 10, $history['no_meja'], 1, 0, 'C');
            $pdf->Cell(50, 10, $history['nama_pelanggan'], 1, 0, 'C');
            $pdf->Cell(50, 10, $history['hari'], 1, 0, 'C');
            $pdf->Cell(50, 10, $history['jam'], 1, 1, 'C');
        }

        // Outputkan PDF
        $pdf->Output('laporan_pengunjung.pdf', 'I');
        exit();
    } else {
        // Jika tidak ada data
        $pdf->Cell(0, 10, "Tidak ada Pengunjung pada tanggal $hari", 0, 1, 'C' );
        $pdf->Output('laporan_pengunjung.pdf', 'I');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Report Page</title>
</head>

<body>
    <?php include("layouts/header.php"); ?>
    <div class="super_center">
        <h3>Cetak Struk PDF</h3>
        <br />
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="date" name="hari">
            <button type="submit" name="report">Generate Report</button>
        </form>
    </div>

</body>

</html>
