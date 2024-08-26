<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posyandu = $_POST['posyandu'];
    $gizi = $_POST['gizi'];
    $kesling = $_POST['kesling'];
    $penyuluhan_narkoba = $_POST['penyuluhan_narkoba'];
    $PHBS = $_POST['PHBS'];
    $KB = $_POST['KB'];
    $user_id = $_POST['id_kader_pokja4'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "UPDATE laporan_kader_pokja4 SET catatan = '', status = 'Dibatalkan', 
                    updated_at = '$created_at' WHERE id_kader_pokja4 = '$user_id'";

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
