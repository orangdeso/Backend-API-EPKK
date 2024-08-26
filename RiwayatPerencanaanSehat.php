<?php
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];
    $perintah = "SELECT * FROM laporan_perencanaan_sehat WHERE id_user = '$idUser' 
                ORDER BY id_p_sehat DESC";
    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_affected_rows($koneksi);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        $response["data"] = array();

        while ($ambil = mysqli_fetch_object($eksekusi)) {
            $F["id_p_sehat"] = $ambil->id_p_sehat;
            $F["J_Psubur"] = $ambil->J_Psubur;
            $F["J_Wsubur"] = $ambil->J_Wsubur;
            $F["Kb_p"] = $ambil->Kb_p;
            $F["Kb_w"] = $ambil->Kb_w;
            $F["Kk_tbg"] = $ambil->Kk_tbg;
            $F["catatan"] = $ambil->catatan;
            $F["status"] = $ambil->status;
            $F["id_user"] = $ambil->id_user;
            $F['tanggal'] = $ambil->tanggal;
            $F['waktu'] = $ambil->waktu;
            // $F['status'] = $ambil->status;
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
