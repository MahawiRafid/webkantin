<?php
include 'koneksi.php';
$input = json_decode(file_get_contents("php://input"), true);
$items = $input['items'];
$total = $input['total'];

mysqli_query($koneksi, "INSERT INTO pesanan(nama_pemesan, email, total_harga) VALUES('Anonymous', 'none', $total)");
$id_pesanan = mysqli_insert_id($koneksi);

foreach ($items as $item) {
    $id = $item['id'];
    $qty = $item['qty'];
    $result = mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $id");
    $menu = mysqli_fetch_assoc($result);
    $subtotal = $menu['harga'] * $qty;
    mysqli_query($koneksi, "INSERT INTO pesanan_detail(id_pesanan, id_menu, jumlah, subtotal) VALUES($id_pesanan, $id, $qty, $subtotal)");
    mysqli_query($koneksi, "UPDATE menu SET stok = stok - $qty WHERE id = $id");
}
echo json_encode(['success' => true]);
?>