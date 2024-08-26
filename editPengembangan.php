<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_kelompok_pemula = $_POST['jumlah_kelompok_pemula'];
    $jumlah_peserta_pemula = $_POST['jumlah_peserta_pemula'];
    $jumlah_kelompok_madya = $_POST['jumlah_kelompok_madya'];
    $jumlah_peserta_madya = $_POST['jumlah_peserta_madya'];
    $jumlah_kelompok_utama = $_POST['jumlah_kelompok_utama'];
    $jumlah_peserta_utama = $_POST['jumlah_peserta_utama'];
    $jumlah_kelompok_mandiri = $_POST['jumlah_kelompok_mandiri'];
    $jumlah_peserta_mandiri = $_POST['jumlah_peserta_mandiri'];
    $jumlah_kelompok_hukum = $_POST['jumlah_kelompok_hukum'];
    $jumlah_peserta_hukum = $_POST['jumlah_peserta_hukum'];

    $user_id = $_POST['id_pokja2_bidang2'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "UPDATE laporan_pengembangan_kehidupan SET jumlah_kelompok_pemula = '$jumlah_kelompok_pemula', 
                    jumlah_peserta_pemula = '$jumlah_peserta_pemula', 
                    jumlah_kelompok_madya = '$jumlah_kelompok_madya', 
                    jumlah_peserta_madya = '$jumlah_peserta_madya', 
                    jumlah_kelompok_utama = '$jumlah_kelompok_utama', 
                    jumlah_peserta_utama = '$jumlah_peserta_utama', 
                    jumlah_kelompok_mandiri = '$jumlah_kelompok_mandiri', 
                    jumlah_peserta_mandiri = '$jumlah_peserta_mandiri', 
                    jumlah_kelompok_hukum = '$jumlah_kelompok_hukum',
                    jumlah_peserta_hukum = '$jumlah_peserta_hukum', catatan = '',
                    status = 'Proses', updated_at = '$created_at' WHERE id_pokja2_bidang2 = '$user_id'";

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
