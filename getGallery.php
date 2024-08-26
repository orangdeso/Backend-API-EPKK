<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];

    // $perintah = "SELECT DISTINCT * FROM galerys WHERE id_user =  '$id_user' ORDER BY id DESC";
    $perintah = "SELECT * FROM `galerys` WHERE id_user = '$id_user' GROUP BY id ORDER BY id DESC";

    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id"] = $ambil->id;
            $F["deskripsi"] = $ambil->deskripsi;
            $F["gambar"] = $ambil->gambar;
            $F["pokja"] = $ambil->pokja;
            $F["bidang"] = $ambil->bidang;
            $F["status"] = $ambil->status;
            $F["tanggal"] = $ambil->tanggal;
            $F["id_user"] = $ambil->id_user;
            $F["waktu"] = $ambil->waktu;

            array_push($response["data"], $F);
        }
    } else {
        $response["kode"] = 0;
        $response["message"] = "Data Tidak Tersedia";
        $response["data"] = null;
    }
}
echo json_encode($response);
mysqli_close($koneksi);
