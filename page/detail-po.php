<?php
if (empty($_SESSION["logged_in"])) {
    header('location: ../login.php');
}
$get_data = mysqli_query($connection, "SELECT * FROM t_po JOIN t_po_detail ON t_po_detail.id_po=t_po.id_po WHERE t_po.id_po=" . $_GET["id"]);
$d = mysqli_fetch_assoc($get_data);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <a href="?page=list-po" class="btn btn-danger btn-sm"><i class="fas fa-chevron-left"></i> Kembali</a>
        </div>
        <div class="col-lg-7">
            <div class="card mt-3 mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            Tanggal Purchase Order : <h5 class="mb-1 mt-2"><?= date("d/F/Y", strtotime($d["tanggal_po"])) ?></h5>
                        </div>
                        <div class="col-3">
                            Kode Purchase Order : <h5 class="mb-1 mt-2">#<?= $d["kode_po"] ?></h5>
                        </div>
                        <div class="col-3">
                            Nama Supplier :
                            <h5 class="mb-1 mt-2"><?= $d["supplier"] ?></h5>
                        </div>
                        <div class="col-3">
                            Metode Pembayaran :
                            <?= $d["payment_method"] == "cash" ? "<h5 class='mt-2 mb-1'><span class='badge badge-pill badge-success'>C a s h</span></h5>" : "<h5 class='mt-2 mb-1'><span class='badge badge-pill badge-primary'>T r a n s f e r</span></h5>"  ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card mt-3 mb-5">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td style="width: 25%;">Nama Barang</td>
                                <td>:</td>
                                <td><?= ucwords($d["nama_barang"]) ?></td>
                            </tr>
                            <tr>
                                <td>Merk Barang</td>
                                <td>:</td>
                                <td><?= ucwords($d["merk_barang"]) ?></td>
                            </tr>
                            <tr>
                                <td>Satuan Barang</td>
                                <td>:</td>
                                <td><?= ucwords($d["satuan_barang"]) ?></td>
                            </tr>
                            <tr>
                                <td>Harga Satuan</td>
                                <td>:</td>
                                <td>Rp <?= number_format($d["harga_satuan"]) ?></td>
                            </tr>
                            <tr>
                                <td>Qty</td>
                                <td>:</td>
                                <td><?= $d["qty"] ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9">
                            <h5 class="text-right">Sub Total : </h5>
                        </div>
                        <div class="col-lg-3">
                            <h5 class="text-right">Rp <?= number_format($d["harga_satuan"] * $d["qty"]) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>