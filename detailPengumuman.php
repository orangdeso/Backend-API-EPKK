<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $perintah = "SELECT * FROM pengumumen WHERE id = '$id'";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id"] = $ambil->id;
            $F["judulPengumuman"] = $ambil->judulPengumuman;
            $F["deskripsiPengumuman"] = $ambil->deskripsiPengumuman;
            $F["tempatPengumuman"] = $ambil->tempatPengumuman;
            $F["tanggalPengumuman"] = $ambil->tanggalPengumuman;
            $F["updated_at"] = $ambil->updated_at;
            $F["created_at"] = $ambil->created_at;

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

