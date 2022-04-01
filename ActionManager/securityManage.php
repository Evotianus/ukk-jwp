<?php
session_start();

// Digunakan untuk cek session dengan variable auth, jika ada maka dibiarkan dan jika tidak ada, maka diarahkan kembali ke login
if (!$_SESSION['auth']) {
    header('Location: index.php');
} else {
}
