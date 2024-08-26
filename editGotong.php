<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kerja_bakti = $_POST['kerja_bakti'];
    $rukun_kematian = $_POST['rukun_kematian'];
    $keagamaan = $_POST['keagamaan'];
    $jimpitan = $_POST['jimpitan'];
    $arisan = $_POST['arisan'];
    $user_id = $_POST['id_pokja1_bidang2'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "UPDATE laporan_gotong_royong SET kerja_bakti = '$kerja_bakti', rukun_kematian = '$rukun_kematian', 
                    keagamaan = '$keagamaan', jimpitan = '$jimpitan', arisan = '$arisan', 
                    catatan = '', status = 'Proses', updated_at = '$created_at' WHERE id_pokja1_bidang2 = '$user_id'";

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
