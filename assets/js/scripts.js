// ketika card di klik , halaman pindah dengan membawa 2 parameter untuk di patch di meja.php
function goToMeja(no_meja, nama_pelanggan) {
  const url = "meja.php";
  const params = `?no_meja=${no_meja}&nama_pelanggan=${nama_pelanggan}`;

  window.location.replace(url + params);
}
