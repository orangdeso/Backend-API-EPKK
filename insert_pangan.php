<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $beras = $_POST['beras'];
    $non_beras = $_POST['non_beras'];
    $peternakan = $_POST['peternakan'];
    $perikanan = $_POST['perikanan'];
    $warung_hidup = $_POST['warung_hidup'];
    $lumbung_hidup = $_POST['lumbung_hidup'];
    $toga = $_POST['toga'];
    $tanaman_keras = $_POST['tanaman_keras'];
    
    $user_id = $_POST['id_user'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "INSERT INTO laporan_pangan (beras, non_beras, 
                    peternakan, perikanan, warung_hidup, lumbung_hidup, toga, 
                    tanaman_keras, status, tanggal, id_user, waktu, created_at) 
        VALUES ('$beras', '$non_beras', '$peternakan', '$perikanan', '$warung_hidup', '$lumbung_hidup', 
                    '$toga', '$tanaman_keras', 'Proses', '$tanggal', 
                    '$user_id', '$waktu', '$created_at')";

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
