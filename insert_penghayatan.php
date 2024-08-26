<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jml_kel_simulasi1 = $_POST['jumlah_kel_simulasi1'];
    $jml_anggota1 = $_POST['jumlah_anggota1'];
    $jml_kel_simulasi2 = $_POST['jumlah_kel_simulasi2'];
    $jml_anggota2 = $_POST['jumlah_anggota2'];
    $jml_kel_simulasi3 = $_POST['jumlah_kel_simulasi3'];
    $jml_anggota3 = $_POST['jumlah_anggota3'];
    $jml_kel_simulasi4 = $_POST['jumlah_kel_simulasi4'];
    $jml_anggota4 = $_POST['jumlah_anggota4'];
    $user_id = $_POST['id_user'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);
    // informasi file yang diupload
    try {

        $query = "INSERT INTO laporan_penghayatan_n_pengamalan (jumlah_kel_simulasi1, jumlah_anggota1, 
                    jumlah_kel_simulasi2, jumlah_anggota2, jumlah_kel_simulasi3, jumlah_anggota3,
                    jumlah_kel_simulasi4, jumlah_anggota4, status, tanggal, id_user, waktu, created_at) 
        VALUES ('$jml_kel_simulasi1', '$jml_anggota1', '$jml_kel_simulasi2', '$jml_anggota2',
                '$jml_kel_simulasi3', '$jml_anggota3', '$jml_kel_simulasi4', '$jml_anggota4',
                'Proses', '$tanggal', '$user_id', '$waktu', '$created_at')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $response['kode'] = 1;
            $response['message'] = "Data Masuk";
            $response['data'] = [
                'Berhasil' => $check
            ];
        } else {
            $response['kode'] = 0;
            $response['message'] = "Data Gagal Masuk";
        }

        // echo 'Data berhasil disimpan!';
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['message'] = $e->getMessage();
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
