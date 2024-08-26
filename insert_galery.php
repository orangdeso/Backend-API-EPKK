<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $desc = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $file = $_FILES['file'];
    $id_user = $_POST['id_user'];


    if ($file != null) {
        // echo 'tes File' . $file;
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $destination = 'assets/gallery/' . $fileName;
        move_uploaded_file($fileTmpName, $destination);

        $query = "INSERT INTO galery (judul, deskripsi, tanggal, status, image , id_user) 
        VALUES ('$judul', '$desc', '$tanggal' , 'Proses', '$fileName' , '$id_user' )";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $response['kode'] = 1;
            $response['message'] = "Data Gambar Masuk";
            $response['data'] = [
                'Berhasil' => $check
            ];
        } else {
            $response['kode'] = 0;
            $response['message'] = "Data Gagal Masuk";
        }
        echo json_encode($response);
        mysqli_close($koneksi);
    }
}

// =================== Revisi Sementara ===================

// include 'koneksi.php';
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $judul = $_POST['judul'];
//     $tanggal = $_POST['tanggal'];
//     $file = $_FILES['file'];
//     $id_user = $_POST['id_user'];


//     if ($file != null) {
//         // echo 'tes File' . $file;
//         $fileName = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName;
//         move_uploaded_file($fileTmpName, $destination);

//         $query = "INSERT INTO galerys (judul, gambar1, status, tanggal, id_user) 
//         VALUES ('$judul', '$fileName' , 'Proses', '$tanggal'  '$id_user' )";

//         $result = mysqli_query($koneksi, $query);
//         $check = mysqli_affected_rows($koneksi);

//         if ($check > 0) {
//             $response['kode'] = 1;
//             $response['message'] = "Data Gambar Masuk";
//             $response['data'] = [
//                 'Berhasil' => $check
//             ];
//         } else {
//             $response['kode'] = 0;
//             $response['message'] = "Data Gagal Masuk";
//         }
//         echo json_encode($response);
//         mysqli_close($koneksi);
//     }
// }


// ============== Revisi ====================

// include 'koneksi.php';
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $judul = $_POST['judul'];
//     $tanggal = $_POST['tanggal'];
//     $file = $_FILES['file'];
//     $id_user = $_POST['id_user'];


//     if ($file != null) {
//         // echo 'tes File' . $file;
//         $fileName1 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName1;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName2 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName2;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName3 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName3;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName4 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName4;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName5 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName5;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName6 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName6;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName7 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName7;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName8 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName8;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName9 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName9;
//         move_uploaded_file($fileTmpName, $destination);

//         $fileName10 = $file['name'];
//         $fileTmpName = $file['tmp_name'];
//         $destination = 'assets/gallery/' . $fileName10;
//         move_uploaded_file($fileTmpName, $destination);

//         $query = "INSERT INTO galerys (judul, gambar1, gambar2, gambar3, gambar4, gambar5, gambar6, 
//                 gambar7, gambar8, gambar9, gambar10, status, tanggal, id_user) 
//         VALUES ('$judul', '$fileName1', '$fileName2', '$fileName3', '$fileName4', '$fileName5', '$fileName6',
//                 '$fileName7', '$fileName8', '$fileName9', '$fileName10', 'Proses', '$tanggal', '$id_user' )";

//         $result = mysqli_query($koneksi, $query);
//         $check = mysqli_affected_rows($koneksi);

//         if ($check > 0) {
//             $response['kode'] = 1;
//             $response['message'] = "Data Gambar Masuk";
//             $response['data'] = [
//                 'Berhasil' => $check
//             ];
//         } else {
//             $response['kode'] = 0;
//             $response['message'] = "Data Gagal Masuk";
//         }
//         echo json_encode($response);
//         mysqli_close($koneksi);
//     }
// }
