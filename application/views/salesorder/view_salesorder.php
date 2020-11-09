<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA SALES ORDER</h2>
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>salesorder/view_salesorder" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <input class="form-control form-control-sm" value="<?php echo $no_so; ?>" name="no_so" placeholder="No PO">
                            </div>
                            <div class="form-group">
                                <select class="selectize" id="kode_pelanggan" name="kode_pelanggan" tabindex="1">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    <?php foreach ($pelanggan->result() as $s) { ?>
                                        <option <?php if ($kode_pelanggan == $s->kode_pelanggan) {
                                                    echo "selected";
                                                } ?> value="<?php echo $s->kode_pelanggan; ?>"><?php echo $s->nama_pelanggan; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <input type="text" value="<?php echo $dari; ?>" name="dari" id="dari" placeholder="Dari" class="form-control form-control-sm datepicker-here" data-language="en" />
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <input type="text" value="<?php echo $sampai; ?>" name="sampai" id="sampai" placeholder="Sampai" class="form-control form-control-sm datepicker-here" data-language="en" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" align="right">
                                <button type="submit" name="submit" class="btn btn-info btn-sm btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-rep-plugin">
                    <a href="<?php echo base_url(); ?>salesorder/input_salesorder" class="btn btn-primary btn-sm input">Tambah Data</a>
                    <div class="table-responsive mb-0">
                        <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th style="width: 2%;">No</th>
                                    <th style="width: 8%;">No SO</th>
                                    <th style="width: 7%;">Tanggal</th>
                                    <th style="width: 15%;">Pelanggan</th>
                                    <th style="width: 8%;">Total</th>
                                    <th>Keterangan</th>
                                    <th style="width: 5%;">PPN</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no  = $row + 1;
                                foreach ($data as $d) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $d['no_so']; ?></td>
                                        <td><?php echo $d['tgl_transaksi']; ?></td>
                                        <td><?php echo $d['nama_pelanggan']; ?></td>
                                        <td align="right"><?php echo number_format($d['total']); ?></td>
                                        <td><?php echo $d['keterangan']; ?></td>
                                        <td><?php echo $d['ppn']; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm detail" href="#" data-kode="<?php echo $d['no_so']; ?>"><i class="mdi mdi-eye"></i></a>
                                            <a class="btn btn-danger btn-sm delete" style="color:white;" data-href="<?php echo base_url(); ?>salesorder/hapus_salesorder/<?php echo $d['no_so']; ?>"><i class="fa fa-trash"></i></a>
                                            <a class="btn btn-warning btn-sm" style="color:white;" href="<?php echo base_url(); ?>salesorder/edit_salesorder/<?php echo $d['no_so']; ?>"><i class="mdi mdi-pencil"></i></a>
                                            <?php if ($d['status'] == "0") { ?>
                                                <a class="btn btn-primary btn-sm" style="color:white;" href="<?php echo base_url(); ?>penjualan/input_penjualan/<?php echo $d['no_so']; ?>/<?php echo $d['kode_pelanggan']; ?>/<?php echo $d['ppn']; ?>">Proses</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div style='margin-top: 10px;'>
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailsalesorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loaddetailsalesorder">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {


        $('.detail').click(function(e) {
            e.preventDefault();
            var no_so = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>salesorder/detail_salesorder',
                data: {
                    no_so: no_so
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailsalesorder").html(respond);
                    $("#detailsalesorder").modal("show");
                }
            });
        });

        $('.delete').click(function(e) {
            e.preventDefault();
            var getLink = $(this).attr('data-href');
            Swal.fire({
                title: 'Yakin Mau di Hapus??',
                text: "Data tidak akan kembali lagi..",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.dismiss) {
                    Swal.fire(
                        'Batal',
                        'Batal di Hapus, Data Masih Aman',
                        'error'
                    )
                } else {
                    Swal.fire(
                        'Hapus',
                        'Berhasil di Hapus',
                        'success'
                    )
                    window.location.href = getLink
                }
            })
        });

    });
</script>