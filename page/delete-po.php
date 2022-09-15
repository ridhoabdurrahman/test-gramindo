<?php
if (empty($_SESSION["logged_in"])) {
    header('location: ../login.php');
}
$query_delete = mysqli_query($connection, "DELETE FROM t_po WHERE id_po='" . $_GET["id"] . "'");
if ($query_delete) {
    echo alert("Data berhasil dihapus!", "?page=list-po");
} else {
    echo alert("Data gagal dihapus!", "?page=list-po");
}
