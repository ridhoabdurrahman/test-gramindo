<?php
if (empty($_SESSION["logged_in"])) {
    header('location: ../login.php');
}

$kode = "";
$prefix_kode = "PO";
// cek kode
$queryKd = $connection->query("SELECT max(right(kode_po,4)) AS kode FROM t_po WHERE DATE(tanggal_po) = CURDATE()");
if ($queryKd->num_rows > 0) {
    foreach ($queryKd as $q) {
        $no = ((int)$q['kode']) + 1;
        $kd = sprintf("%04s", $no);
    }
} else {
    $kd = "0001";
}

date_default_timezone_set('Asia/Jakarta');

$kode = $prefix_kode . date("dmy") . $kd;
?>

<div class="container-fluid">
    <h1 class="mt-4">Purchase Order</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Data Purchase Order</li>
    </ol>
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    DataTable Example
                </div>
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Tanggal Purchase Order</label>
                                    <input class="form-control" type="date" name="tanggal" readonly value="<?= date("Y-m-d") ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Kode Purchase Order</label>
                                    <input class="form-control" type="text" name="kode" readonly value="<?= $kode ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Nama Supplier</label>
                                    <input class="form-control" type="text" name="supplier" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Metode Pembayaran</label>
                                    <select class="form-control" name="payment" id="" required>
                                        <option value="">--- Pilih Pembayaran ---</option>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nama Barang</label>
                                    <input class="form-control" type="text" name="nama_barang" id="" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Merk Barang</label>
                                    <input class="form-control" type="text" name="merk_barang" id="" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Satuan Barang</label>
                                    <select class="form-control" name="satuan" id="" required>
                                        <option value="">--- Pilih Satuan ---</option>
                                        <option value="pcs">PCS</option>
                                        <option value="unit">Unit</option>
                                        <option value="bungkus">Bungkus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Harga Satuan</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" name="harga" class="form-control" id="harga-satuan" placeholder="0,-" onkeyup="subTotal()" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <input class="form-control" type="number" name="qty" id="qty" min="1" value="1" onkeyup="subTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Total</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control" id="sub-total" placeholder="0,-" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="sumbit" class="btn btn-success" name="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function subTotal() {
        const hargaSatuan = document.getElementById("harga-satuan").value;
        const qty = document.getElementById("qty").value;
        const subTotal = hargaSatuan * qty;
        document.getElementById('sub-total').value = subTotal;
    }
</script>

<?php
$get_id_po = mysqli_query($connection, "SELECT * FROM t_po");
$row_po = mysqli_num_rows($get_id_po);
if ($row_po == 0) {
    $id_po = 1;
} else {
    $id_po = $row_po + 1;
}

if (isset($_POST["save"])) {
    $tanggal_po = mysqli_real_escape_string($connection, $_POST["tanggal"]);
    $kode_po = mysqli_real_escape_string($connection, $_POST["kode"]);
    $nama_supplier = mysqli_real_escape_string($connection, $_POST["supplier"]);
    $payment_method = mysqli_real_escape_string($connection, $_POST["payment"]);
    $user_id = mysqli_real_escape_string($connection, $_SESSION["id_user"]);
    $query_po = mysqli_query($connection, "INSERT INTO t_po VALUES('$id_po', '$kode_po', '$tanggal_po', '$nama_supplier', '$payment_method', '$user_id')");

    $nama_barang = mysqli_real_escape_string($connection, $_POST["nama_barang"]);
    $merk_barang = mysqli_real_escape_string($connection, $_POST["merk_barang"]);
    $satuan = mysqli_real_escape_string($connection, $_POST["satuan"]);
    $harga = mysqli_real_escape_string($connection, $_POST["harga"]);
    $qty = mysqli_real_escape_string($connection, $_POST["qty"]);
    $query_detail = mysqli_query($connection, "INSERT INTO t_po_detail VALUES(NULL, '$id_po', '$nama_barang', '$merk_barang', '$satuan', '$qty', '$harga')");

    if ($query_po && $query_detail) {
        echo alert("Data Berhasil disimpan!", "?page=add-po");
    } else {
        echo alert("Data Gagal disimpan!", "?page=add-po");
    }
}
?>