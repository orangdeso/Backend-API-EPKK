<?php
header('Content-Type: application/json');
require("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $perintah = "SELECT * FROM laporan_kader_pokja1 WHERE id_kader_pokja1 = '$id'";
        $eksekusi = mysqli_query($koneksi, $perintah);
        $cek = mysqli_num_rows($eksekusi); 

        if ($cek > 0) {
            $response["kode"] = 1;
            $response["message"] = "Data laporan kader pokja I ID: $id tersedia";
            $response["data"] = array();

            while ($ambil = mysqli_fetch_object($eksekusi)) {
                $F["id_user"] = $ambil->id_user;
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
    } else {
        // Jika parameter tidak ada, kembalikan pesan kesalahan
        $response["kode"] = 0;
        $response["message"] = "Parameter id_kader_pokja1 not found";
        $response["data"] = null;
    }
}

echo json_encode($response);
mysqli_close($koneksi);
?>
