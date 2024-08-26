<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $J_Psubur = $_POST['J_Psubur'];
    $J_Wsubur = $_POST['J_Wsubur'];
    $Kb_p = $_POST['Kb_p'];
    $Kb_w = $_POST['Kb_w'];
    $Kk_tbg = $_POST['Kk_tbg'];
    
    $user_id = $_POST['id_user'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "INSERT INTO laporan_perencanaan_sehat (J_Psubur, J_Wsubur, Kb_p, Kb_w, Kk_tbg, 
                    status, tanggal, id_user, waktu, created_at) 
        VALUES ('$J_Psubur', '$J_Wsubur', '$Kb_p', '$Kb_w', '$Kk_tbg', 
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
