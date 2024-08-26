<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jamban = $_POST['jamban'];
    $spal = $_POST['spal'];
    $tps = $_POST['tps'];
    $mck = $_POST['mck'];
    $pdam = $_POST['pdam'];
    $sumur = $_POST['sumur'];
    $dll = $_POST['dll'];

    $user_id = $_POST['id_user'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "INSERT INTO laporan_kelestarian_lingkungan_hidup (jamban, spal, 
                    tps, mck, pdam, sumur, dll, 
                    status, tanggal, id_user, waktu, created_at) 
        VALUES ('$jamban', '$spal', '$tps', '$mck', '$pdam', '$sumur', '$dll', 
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
