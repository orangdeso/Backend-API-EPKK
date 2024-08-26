<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];

    $perintah = "SELECT * FROM laporan_sandang WHERE id_user = '$idUser' 
                ORDER BY id_pokja3_bidang2 DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F['id_pokja3_bidang2'] = $ambil->id_pokja3_bidang2;
            $F['pangan'] = $ambil->pangan;
            $F['sandang'] = $ambil->sandang;
            $F['jasa'] = $ambil->jasa;
            $F['catatan'] = $ambil->catatan;
            $F["status"] = $ambil->status;
            $F['tanggal'] = $ambil->tanggal;
            $F['waktu'] = $ambil->waktu;
            $F["created_at"] = $ambil->created_at;
            $F["updated_at"] = $ambil->updated_at;

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
