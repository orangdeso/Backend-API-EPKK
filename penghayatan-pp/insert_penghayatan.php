<?php
header('Content-Type: application/json');
require("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $jml_kel_simulasi1 = $input['jumlah_kel_simulasi1'];
    $jml_anggota1 = $input['jumlah_anggota1'];
    $jml_kel_simulasi2 = $input['jumlah_kel_simulasi2'];
    $jml_anggota2 = $input['jumlah_anggota2'];
    $jml_kel_simulasi3 = $input['jumlah_kel_simulasi3'];
    $jml_anggota3 = $input['jumlah_anggota3'];
    $jml_kel_simulasi4 = $input['jumlah_kel_simulasi4'];
    $jml_anggota4 = $input['jumlah_anggota4'];
    $user_id = $input['id_user'];
    $role = $input['role'];
    $role_bidang = $input['role_bidang'];

    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "INSERT INTO laporan_penghayatan_n_pengamalan (jumlah_kel_simulasi1, jumlah_anggota1, 
                    jumlah_kel_simulasi2, jumlah_anggota2, jumlah_kel_simulasi3, jumlah_anggota3,
                    jumlah_kel_simulasi4, jumlah_anggota4, status, tanggal, id_user, waktu, role, role_bidang, created_at) 
        VALUES ('$jml_kel_simulasi1', '$jml_anggota1', '$jml_kel_simulasi2', '$jml_anggota2',
                '$jml_kel_simulasi3', '$jml_anggota3', '$jml_kel_simulasi4', '$jml_anggota4',
                'Proses', '$tanggal', '$user_id', '$waktu', '$role', '$role_bidang', '$created_at')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $selectQuery = "SELECT * FROM laporan_penghayatan_n_pengamalan WHERE id_user = '$user_id' AND created_at = '$created_at'";
            $selectResult = mysqli_query($koneksi, $selectQuery);

            $allData = [];
            while ($row = mysqli_fetch_assoc($selectResult)) {
                $allData[] = $row;
            }

            $response['kode'] = 1;
            $response['message'] = "Berhasil upload laporan Penghayatan & Pengamalan";
            $response['data'] = $allData; 
        } else {
            $response['kode'] = 0;
            $response['message'] = "Gagal upload laporan";
        }

    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
?>


