<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD']==='GET') {
$perintah = "SELECT * FROM laporan WHERE status LIKE '%menunggu%'";
$eksekusi = mysqli_query($koneksi, $perintah);
$cek= mysqli_affected_rows($koneksi);

if($cek > 0) {
    $response["kode"] = 1;
    $response["message"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil= mysqli_fetch_object($eksekusi)) {
        $F["id_laporan"] = $ambil->id_laporan;
        $F["title_laporan"] = $ambil->title_laporan;
        $F["tanggal"] = $ambil->tanggal;
        $F["deskripsi"] = $ambil->deskripsi;
        $F["image"] = $ambil->image;
        $F["status"] = $ambil->status;
        $F["id_kategori"] = $ambil->id_kategori;
        $F["id_user"] = $ambil->id_user;
        
        array_push($response["data"], $F);
    }
}
else {
    $response["kode"] = 0;
    $response["message"] = "Data Tidak Tersedia";
    $response["data"] = null;

}
}
echo json_encode($response);
mysqli_close($koneksi);
