<?php

require("koneksi.php");
//header("Content-Type: application/jsont/html; charset: utf-8;");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_whatsapp = $_POST['no_whatsapp'];
    $password = $_POST['password'];
    $perintah =  "SELECT * FROM user WHERE no_whatsapp = '$no_whatsapp' AND password = '$password'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if ($cek > 0) {
        $response["kode"] = 1;
        $response["message"] = "Data Tersedia";
        while($ambil= mysqli_fetch_object($eksekusi)) {
            $response["no_whatsapp"] = $ambil->no_whatsapp;
            $response["nama_user"] = $ambil->nama_user;
            $response["tanggal_lahir"] = $ambil->tanggal_lahir;
            $response["alamat"] = $ambil->alamat;
            $response["password"] = $ambil->password;
        }
        //$response["data"] = array();

        // while($ambil= mysqli_fetch_object($eksekusi)) {
        //     $F["no_whatsapp"] = $ambil->no_whatsapp;
        //     $F["nama_user"] = $ambil->nama_user;
        //     $F["tanggal_lahir"] = $ambil->tanggal_lahir;
        //     $F["alamat"] = $ambil->alamat;
        //     $F["password"] = $ambil->password;

        //     array_push($response["data"], $F);
        // }
    } else {
        $response["kode"] = 0;
        $response["message"] = "Data Tidak Tersedia";
        //$response["data"] = null;

    }

    echo json_encode($response);
    mysqli_close($konek);
}
