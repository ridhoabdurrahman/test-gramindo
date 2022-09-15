<?php
if (empty($_SESSION["logged_in"])) {
    header('location: ../login.php');
}
$get_po = mysqli_query($connection, "SELECT * FROM t_po WHERE id_po='" . $_GET["id"] . "'");
$data_po = mysqli_fetch_assoc($get_po);

$get_detail = mysqli_query($connection, "SELECT * FROM t_po_detail WHERE id_po='" . $_GET["id"] . "'");
$data_detail = mysqli_fetch_assoc($get_detail);
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
                                    <input class="form-control" type="date" name="tanggal" readonly value="<?= date("Y-m-d", strtotime($data_po["tanggal_po"])) ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Kode Purchase Order</label>
                                    <input class="form-control" type="text" name="kode" readonly value="<?= $data_po["kode_po"] ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Nama Supplier</label>
                                    <input class="form-control" type="text" name="supplier" value="<?= $data_po["supplier"] ?>" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Metode Pembayaran</label>
                                    <select class="form-control" name="payment" id="" required>
                                        <option value="">--- Pilih Pembayaran ---</option>
                                        <option value="cash" <?= $data_po["payment_method"] == 'cash' ? 'selected' : '' ?>>Cash</option>
                                        <option value="transfer" <?= $data_po["payment_method"] == 'transfer' ? 'selected' : '' ?>>Transfer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nama Barang</label>
                                    <input class="form-control" type="text" name="nama_barang" id="" value="<?= $data_detail["nama_barang"] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Merk Barang</label>
                                    <input class="form-control" type="text" name="merk_barang" id="" value="<?= $data_detail["merk_barang"] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Satuan Barang</label>
                                    <select class="form-control" name="satuan" id="" required>
                                        <option value="">--- Pilih Satuan ---</option>
                                        <option value="pcs" <?= $data_detail["satuan_barang"] == 'pcs' ? 'selected' : '' ?>>PCS</option>
                                        <option value="unit" <?= $data_detail["satuan_barang"] == 'unit' ? 'selected' : '' ?>>Unit</option>
                                        <option value="bungkus" <?= $data_detail["satuan_barang"] == 'bungkus' ? 'selected' : '' ?>>Bungkus</option>
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
                                        <input type="text" name="harga" class="form-control" id="harga-satuan" value="<?= $data_detail["harga_satuan"] ?>" placeholder="0,-" onkeyup="subTotal()" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <input class="form-control" type="number" name="qty" id="qty" min="1" value="<?= $data_detail["qty"] ?>" onkeyup="subTotal()" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Total</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="text" class="form-control" id="sub-total" placeholder="0,-" value="<?= $data_detail["harga_satuan"] * $data_detail["qty"] ?>" readonly>
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
if (isset($_POST["save"])) {
    $nama_supplier = mysqli_real_escape_string($connection, $_POST["supplier"]);
    $payment_method = mysqli_real_escape_string($connection, $_POST["payment"]);
    $query_update_po = mysqli_query($connection, "UPDATE t_po SET supplier='$nama_supplier', payment_method='$payment_method' WHERE id_po='" . $_GET['id'] . "'");

    $nama_barang = mysqli_real_escape_string($connection, $_POST["nama_barang"]);
    $merk_barang = mysqli_real_escape_string($connection, $_POST["merk_barang"]);
    $satuan = mysqli_real_escape_string($connection, $_POST["satuan"]);
    $harga = mysqli_real_escape_string($connection, $_POST["harga"]);
    $qty = mysqli_real_escape_string($connection, $_POST["qty"]);
    $query_update_detail = mysqli_query($connection, "UPDATE t_po_detail SET nama_barang='$nama_barang', merk_barang='$merk_barang', satuan_barang='$satuan', qty='$qty', harga_satuan='$harga' WHERE id_po='" . $_GET['id'] . "'");

    if ($query_update_po && $query_update_detail) {
        echo alert("Data Berhasil diubah!", "?page=list-po");
    } else {
        echo alert("Data Gagal diubah!", "?page=edit-po&id=" . $data_po["id_po"]);
    }
}
?>