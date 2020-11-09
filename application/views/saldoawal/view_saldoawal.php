<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA SALDO AWAL</h2>
                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>saldoawal/view_saldoawal" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <select class="selectize" id="bulan" name="bulan">
                                            <option value="">Bulan</option>
                                            <?php for ($a = 1; $a <= 12; $a++) { ?>
                                                <option <?php if ($bulans == $a) {
                                                            echo "selected";
                                                        } ?> value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <select class="selectize" id="tahun" name="tahun">
                                            <option value="">Tahun</option>
                                            <?php for ($t = 2019; $t <= date('Y'); $t++) { ?>
                                                <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                                            <?php } ?>
                                        </select>
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
                    <a href="<?php echo base_url(); ?>saldoawal/input_saldoawal" class="btn btn-primary btn-sm input">Tambah Data</a>
                    <div class="table-responsive mb-0">
                        <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th style="width: 10%;">Kode Saldoawal</th>
                                    <th style="width: 10%;">Tanggal Input</th>
                                    <th style="width: 10%;">Bulan</th>
                                    <th style="width: 10%;">Tahun</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($data as $d) {
                                    $bulan = $d->bulan;
                                    if ($bulan == "01") {
                                        $bulan = "Januari";
                                    } elseif ($bulan == "02") {
                                        $bulan = "Februari";
                                    } elseif ($bulan == "03") {
                                        $bulan = "Maret";
                                    } elseif ($bulan == "04") {
                                        $bulan = "April";
                                    } elseif ($bulan == "05") {
                                        $bulan = "Mei";
                                    } elseif ($bulan == "06") {
                                        $bulan = "Juni";
                                    } elseif ($bulan == "07") {
                                        $bulan = "Juli";
                                    } elseif ($bulan == "08") {
                                        $bulan = "Agustus";
                                    } elseif ($bulan == "09") {
                                        $bulan = "September";
                                    } elseif ($bulan == "10") {
                                        $bulan = "Oktober";
                                    } elseif ($bulan == "11") {
                                        $bulan = "November";
                                    } elseif ($bulan == "12") {
                                        $bulan = "Desember";
                                    }

                                ?>
                                    <tr>
                                        <td><?php echo $d->kode_saldoawal; ?></td>
                                        <td><?php echo DateToIndo2($d->tgl_transaksi); ?></td>
                                        <td><?php echo $bulan; ?></td>
                                        <td><?php echo $d->tahun; ?></td>
                                        <td>
                                            <a class="btn btn-info btn-sm detail" href="#" data-kode="<?php echo $d->kode_saldoawal; ?>"><i class="mdi mdi-eye"></i></a>
                                            <a class="btn btn-danger btn-sm delete" style="color:white;" data-href="<?php echo base_url(); ?>saldoawal/hapus_saldoawal/<?php echo $d->kode_saldoawal; ?>"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailsaldoawal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loaddetailsaldoawal">

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
            var kode_saldoawal = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>saldoawal/detail_saldoawal',
                data: {
                    kode_saldoawal: kode_saldoawal
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailsaldoawal").html(respond);
                    $("#detailsaldoawal").modal("show");
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