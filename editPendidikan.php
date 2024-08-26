<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $warga_buta = $_POST['warga_buta'];
    $kel_belajarA = $_POST['kel_belajarA'];
    $warga_belajarA = $_POST['warga_belajarA'];
    $kel_belajarB = $_POST['kel_belajarB'];
    $warga_belajarB = $_POST['warga_belajarB'];
    $kel_belajarC = $_POST['kel_belajarC'];
    $warga_belajarC = $_POST['warga_belajarC'];
    $kel_belajarKF = $_POST['kel_belajarKF'];
    $warga_belajarKF = $_POST['warga_belajarKF'];
    $paud = $_POST['paud'];
    $taman_bacaan = $_POST['taman_bacaan'];
    $jumlah_klp = $_POST['jumlah_klp'];
    $jumlah_ibu_peserta = $_POST['jumlah_ibu_peserta'];
    $jumlah_ape = $_POST['jumlah_ape'];
    $jumlah_kel_simulasi = $_POST['jumlah_kel_simulasi'];
    $KF = $_POST['KF'];
    $paud_tutor = $_POST['paud_tutor'];
    $BKB = $_POST['BKB'];
    $koperasi = $_POST['koperasi'];
    $ketrampilan = $_POST['ketrampilan'];
    $LP3PKK = $_POST['LP3PKK'];
    $TP3PKK = $_POST['TP3PKK'];
    $damas_pkk = $_POST['damas_pkk'];

    $user_id = $_POST['id_pokja2_bidang1'];
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    try {
        $query = "UPDATE laporan_pendidikan_n_keterampilan SET warga_buta = '$warga_buta', kel_belajarA = '$kel_belajarA', 
                    warga_belajarA = '$warga_belajarA', kel_belajarB = '$kel_belajarB', 
                    warga_belajarB = '$warga_belajarB', kel_belajarC = '$kel_belajarC', 
                    warga_belajarC = '$warga_belajarC', kel_belajarKF = '$kel_belajarKF', 
                    warga_belajarKF = '$warga_belajarKF', paud = '$paud', taman_bacaan = '$taman_bacaan', 
                    jumlah_klp = '$jumlah_klp', jumlah_ibu_peserta = '$jumlah_ibu_peserta', 
                    jumlah_ape = '$jumlah_ape', jumlah_kel_simulasi = '$jumlah_kel_simulasi', KF = '$KF', 
                    paud_tutor = '$paud_tutor', BKB = '$BKB', koperasi = '$koperasi', ketrampilan = '$ketrampilan', 
                    LP3PKK = '$LP3PKK', TP3PKK = '$TP3PKK', damas_pkk = '$damas_pkk', catatan = '', 
                    status = 'Proses', updated_at = '$created_at' WHERE id_pokja2_bidang1 = '$user_id'";
        
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
