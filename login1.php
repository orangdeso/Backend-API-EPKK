<?php
header('Content-Type: application/json');
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_whatsapp = $_POST['no_whatsapp'];
    $password = $_POST['password'];
    $input_role = $_POST['role'];  // Role yang dipilih dari client (Desa atau Kecamatan)

    $koneksi->autocommit(false);
    try {
        // Pertama, periksa apakah nomor WhatsApp sudah terdaftar
        $result = $koneksi->query("SELECT * FROM penggunas WHERE no_whatsapp = '$no_whatsapp'");
        $user = mysqli_fetch_object($result);

        if ($user) {
            // Nomor WhatsApp terdaftar, lanjutkan dengan pengecekan password
            if (password_verify($password, $user->password)) {
                // Jika password cocok, cek apakah role sesuai
                if ($user->role === $input_role) {
                    // Role sesuai, lanjutkan proses login
                    $response['kode'] = 1;
                    $response['pesan'] = "Berhasil Login";
                    $response['data'] = [
                        'id' => $user->id,
                        'nama_pengguna' => $user->nama_pengguna,
                        'no_whatsapp' => $user->no_whatsapp,
                        'kecamatan' => $user->kecamatan,
                        'desa' => $user->desa,
                        'role' => $user->role,
                        'role_bidang' => $user->role_bidang,
                        'status' => $user->status
                    ];
                } else {
                    // Role tidak sesuai
                    $response['kode'] = 4;
                    $response['pesan'] = "Role anda adalah " . $user->role . ", bukan " . $input_role;
                }
            } else {
                // Jika password tidak cocok
                $response['kode'] = 3;
                $response['pesan'] = "Password anda salah";
            }
        } else {
            // Nomor WhatsApp tidak terdaftar, tidak perlu memeriksa password
            $response['kode'] = 2;
            $response['pesan'] = "Nomor WhatsApp tidak terdaftar";
        }

        $koneksi->commit();

    } catch (Exception $e) {
        $response['kode'] = 0;
        $response['pesan'] = $e->getMessage();
        $koneksi->rollback();
    }
    echo json_encode($response);
    mysqli_close($koneksi);
}
?>