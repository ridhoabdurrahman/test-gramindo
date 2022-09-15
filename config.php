<?php
if (!$connection = new Mysqli("localhost", "root", "", "db_po")) {
    echo "<script>Alert('ERROR: Koneksi Database Gagal')</script>";
}

if (isset($_GET["page"])) {
    $_PAGE = $_GET["page"];
} else {
    $_PAGE = "dashboard";
}

/**
 * page setup
 * @param page
 * @return page filename
 */
function page($page)
{
    return "page/" . $page . ".php";
}

/**
 * Alert notification
 * @param message, redirection
 * @return alert notify
 */
function alert($msg, $to = null)
{
    $to = ($to) ? $to : $_SERVER["PHP_SELF"];
    return "<script>alert('{$msg}');window.location='{$to}';</script>";
}
