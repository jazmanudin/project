<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title" align="center">DATA PERUSAHAAN</h2>
                <div class="table-rep-plugin">
                    <a href="<?php echo base_url(); ?>perusahaan/input_perusahaan" class="btn btn-primary btn-sm input">Tambah Data</a>
                    <div class="table-responsive mb-0">
                        <table id="datatable" class="table table-striped table-bordered table-hover table-sm">
                            <thead style="background-color: #0085cd;color:white">
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>Alamat</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>No HP</th>
                                    <th>Email</th>
                                    <th>Exp Date</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?php echo $d->nama_perusahaan; ?></td>
                                        <td><?php echo $d->alamat; ?></td>
                                        <td><?php echo $d->provinsi; ?></td>
                                        <td><?php echo $d->kota; ?></td>
                                        <td><?php echo $d->kecamatan; ?></td>
                                        <td><?php echo $d->desa; ?></td>
                                        <td><?php echo $d->no_hp; ?></td>
                                        <td><?php echo $d->email; ?></td>
                                        <td><?php echo $d->exp_date; ?></td>
                                        <td>
                                            <img width="70px" src="<?php echo base_url(); ?>assets/images/perusahaan/<?php if ($d->foto != "") {
                                                                                                                            echo $d->foto;
                                                                                                                        } else {
                                                                                                                            echo "perusahaan.png";
                                                                                                                        } ?>">
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm detail" href="#" data-kode="<?php echo $d->kode_perusahaan; ?>"><i class="mdi mdi-eye"></i></a>
                                            <a class="btn btn-danger btn-sm delete" href="#" data-href="<?php echo base_url(); ?>perusahaan/hapus_perusahaan/<?php echo $d->kode_perusahaan; ?>"><i class="mdi mdi-trash-can"></i></a>
                                            <a class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>perusahaan/edit_perusahaan/<?php echo $d->kode_perusahaan; ?>"><i class="mdi mdi-pencil"></i></a>
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

<div class="modal fade" id="detailperusahaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detail Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="loaddetailperusahaan">

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

        $('#datatable').dataTable({
            bFilter: false,
            searching: true,
            paging: true,
            info: false
        });

        $('.detail').click(function(e) {
            e.preventDefault();
            var kode_perusahaan = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>perusahaan/detail_perusahaan',
                data: {
                    kode_perusahaan: kode_perusahaan
                },
                cache: false,
                success: function(respond) {
                    $("#loaddetailperusahaan").html(respond);
                    $("#detailperusahaan").modal("show");
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
                location.reload();
            })
        });

    });
</script>