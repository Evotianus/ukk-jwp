<?php
session_start();

// Digunakan untuk menghapus semua session dari website ini
session_destroy();

// Diarahkan kembali ke file index.php
header("Location: ../index.php");
