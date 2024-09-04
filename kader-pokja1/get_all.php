<?php
header('Content-Type: application/json');
require("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idUser = $_GET['id_user'];

    $perintah = "SELECT * FROM laporan_kader_pokja1 WHERE id_user = '$idUser' 
                ORDER BY id_kader_pokja1 DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_num_rows($eksekusi); 

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data laporan kader pokja I tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_kader_pokja1"] = $ambil->id_kader_pokja1;
            $F["PKBN"] = $ambil->PKBN;
            $F["PKDRT"] = $ambil->PKDRT;
            $F["pola_asuh"] = $ambil->pola_asuh;
            $F['catatan'] = $ambil->catatan;
            $F["status"] = $ambil->status;
            $F['tanggal'] = $ambil->tanggal;
            $F['waktu'] = $ambil->waktu;
            $F['role'] = $ambil->role;
            $F['role_bidang'] = $ambil->role_bidang;
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
?>
