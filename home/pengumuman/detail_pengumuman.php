<?php
header('Content-Type: application/json');
require("../../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $perintah = "SELECT * FROM pengumumen WHERE id = '$id'";
        $eksekusi = mysqli_query($koneksi, $perintah);
        $cek = mysqli_num_rows($eksekusi);

        if ($cek > 0) {
            $response["kode"] = 1;
            $response["message"] = "Data Pengumuman tersedia";
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
    } else {
        $response["kode"] = 0;
        $response["message"] = "Parameter id_kader_pokja1 not found";
        $response["data"] = null;
    }
}
echo json_encode($response);
mysqli_close($koneksi);

