<?php
header('Content-Type: application/json');
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pengguna = $_POST['nama_pengguna'];
    $no_whatsapp = $_POST['no_whatsapp'];
    $kecamatan = $_POST['kecamatan'];
    $desa = $_POST['desa'];
    $role = $_POST['role'];
    $role_bidang = $_POST['role_bidang'];
    $password = $_POST['password'];
    $kode_otp = $_POST['kode_otp'];
    $status = $_POST['status'];

    // Enkripsi password menggunakan Hash
    $password_encrypted = password_hash($password, PASSWORD_BCRYPT);

    $koneksi->autocommit(false);
    try {
        // Query untuk menyimpan data ke dalam database
        $koneksi->query("INSERT INTO penggunas (nama_pengguna, no_whatsapp, kecamatan, desa, role, role_bidang, password, kode_otp, status) 
                         VALUES ('$nama_pengguna', '$no_whatsapp', '$kecamatan', '$desa', '$role', '$role_bidang', '$password_encrypted', '$kode_otp', '$status')");

        // Ambil ID pengguna yang baru saja dibuat
        $id_pengguna = $koneksi->insert_id;

        // Ambil data pengguna yang baru saja dimasukkan
        $result = $koneksi->query("SELECT * FROM penggunas WHERE id = $id_pengguna");
        $data_pengguna = $result->fetch_assoc();

        $koneksi->commit();
        $response['kode'] = 1;
        $response['pesan'] = "Success Create Account";
        $response['data'] = $data_pengguna;
    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['pesan'] = $e->getMessage();
        $koneksi->rollback();
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
