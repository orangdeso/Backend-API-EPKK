<?php
require('koneksi.php');
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Memeriksa apakah id ada di dalam tabel user
        $queryCheckUser = "SELECT * FROM `penggunas` WHERE `id` = '$id'";
        $checkUserResult = mysqli_query($koneksi, $queryCheckUser);

        if (mysqli_num_rows($checkUserResult) > 0) {
            // Memeriksa apakah data yang akan diupdate ada di dalam request
            if (isset($_POST['nama_pengguna']) && isset($_POST['nama_kec']) && isset($_POST['no_whatsapp'])) {
                $nama_pengguna = $_POST['nama_pengguna'];
                $nama_kec = $_POST['nama_kec'];
                $no_whatsapp = $_POST['no_whatsapp'];

                // Melakukan pembaruan data pada tabel user berdasarkan id
                $queryUpdateUser = "UPDATE `penggunas` SET `nama_pengguna` = '$nama_pengguna', `nama_kec` = '$nama_kec', `no_whatsapp` = '$no_whatsapp' WHERE `id` = '$id'";
                $updateUserResult = mysqli_query($koneksi, $queryUpdateUser);

                if ($updateUserResult) {
                    $response["kode"] = 1;
                    $response["pesan"] = "Data berhasil diperbarui";
                } else {
                    $response["kode"] = 0;
                    $response["pesan"] = "Terjadi kesalahan dalam memperbarui data";
                }
            } else {
                $response["kode"] = 0;
                $response["pesan"] = "Data yang diperlukan tidak lengkap";
            }
        } else {
            $response["kode"] = 0;
            $response["pesan"] = "Data User tidak ditemukan";
        }
    } else {
        $response["kode"] = 0;
        $response["pesan"] = "ID User tidak ditemukan";
    }
} else {
    $response["kode"] = 0;
    $response["pesan"] = "Metode HTTP yang digunakan bukan POST";
}

echo json_encode($response);
mysqli_close($koneksi);
?>
