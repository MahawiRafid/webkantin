<?php
include 'koneksi.php';
$data = [];
$result = mysqli_query($koneksi, "SELECT * FROM menu");
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
header('Content-Type: application/json');
echo json_encode($data);
?>