<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  $insertOrder = $conn->prepare("INSERT INTO messages (name, email, message) values (?, ?, ?)");
  $insertOrder->bind_param("sss", $name, $email, $message);
  $insertOrder->execute();

  echo "Pesan dari $name telah terkirim.";
  echo "<br><button onclick = 'window.location.href=\"index.php\"'>Selesai</button>";
}
?>