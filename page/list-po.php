<?php if (empty($_SESSION["logged_in"])) {
    header('location: ../login.php');
} ?>
<div class="container-fluid">
    <h1 class="mt-4">Purchase Order</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Purchase Order</li>
    </ol>
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-list mr-1"></i> Data Purchase Order
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kode Purchase Order</th>
                                    <th>Nama Supplier</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $get_data = mysqli_query($connection, "SELECT * FROM t_po ORDER BY id_po DESC");
                                while ($data = mysqli_fetch_assoc($get_data)) {
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date("d/F/Y", strtotime($data["tanggal_po"])) ?></td>
                                        <td><?= $data["kode_po"] ?></td>
                                        <td><?= $data["supplier"] ?></td>
                                        <td><?= $data["payment_method"] ?></td>
                                        <td class="text-center">
                                            <a href="?page=detail-po&id=<?= $data["id_po"] ?>" class="btn btn-info btn-sm mr-2">Detail</a>
                                            <a href="?page=edit-po&id=<?= $data["id_po"] ?>" class="btn btn-warning btn-sm">Ubah</a>
                                            <a href="?page=delete-po&id=<?= $data["id_po"] ?>" class="btn btn-danger btn-sm ml-2" onclick="return confirm('Data akan dihapus?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>