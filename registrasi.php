<?php
include('koneksi.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_whatsapp = $_POST['no_whatsapp'];
    $nama_user = $_POST['nama_user'];
    $password = $_POST['password'];
    $telp = $_POST['telp'];

    $queryCheck = "SELECT * FROM admin where email = '$email'";
    $checkEmail = mysqli_query($konek, $queryCheck);
    $rowsEmail = mysqli_affected_rows($konek);

    if ($rowsEmail > 0) {
        $response['kode'] = 3;
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user(no_whatsa,email,pass) VALUES ('$nama_user','$email','$hash')";
        $result = mysqli_query($konek, $query);

        $last_id = $konek->insert_id;

        //random number
        $digits = 5;
        $verifNumber =  rand(pow(10, $digits - 1), pow(10, $digits) - 1);

        //insert table register
        $query2 = "INSERT INTO validasi VALUES ('$verifNumber','Belum Verifikasi','$last_id')";
        $result2 = mysqli_query($konek, $query2);
        $check = mysqli_affected_rows($konek);

        if ($check > 0) {
            $response['kode'] = 1;
            $response['data'] = [
                'id_user' => $last_id
            ];
        } else {
            $response['kode'] = 0;
        }
    }

    echo json_encode($response);
    mysqli_close($konek);
}