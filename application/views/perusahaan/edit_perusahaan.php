<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h4 align="center">Input Data Perusahaan</h4>
            <form autocomplete="off" id="form" class="pelangganForm" method="POST" enctype="multipart/form-data" data-action="<?php echo base_url(); ?>perusahaan/edit_perusahaan">

                <div class="form-group">
                    <label>Kode Perusahaan</label>
                    <input type="text" value="<?php echo $getdata['kode_perusahaan']; ?>" name="kode_perusahaan" id="kode_perusahaan" class="form-control kosong form-control-sm" placeholder="Kode Perusahaan" />
                </div>
                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" value="<?php echo $getdata['nama_perusahaan']; ?>" name="nama_perusahaan" id="nama_perusahaan" class="form-control form-control-sm" placeholder="Nama Perusahaan" />
                </div>
                <div class="form-group">
                    <label>Email Perusahaan</label>
                    <input type="text" value="<?php echo $getdata['email']; ?>" nama="email" id="email" class="form-control form-control-sm" placeholder="Email Perusahaan" />
                </div>
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" value="<?php echo $getdata['no_hp']; ?>" name="no_hp" id="no_hp" class="form-control form-control-sm" placeholder="No HP" />
                </div>
                <div class="form-group">
                    <label>Alamat Perusahaan</label>
                    <input type="text" value="<?php echo $getdata['alamat']; ?>" name="alamat" id="alamat" class="form-control form-control-sm" placeholder="Alamat Perusahaan" />
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" value="<?php echo $getdata['provinsi']; ?>" name="provinsi" id="provinsi" class="form-control form-control-sm" placeholder="Kota" />
                </div>
                <div class="form-group">
                    <label>Kota</label>
                    <input type="text" value="<?php echo $getdata['kota']; ?>" name="kota" id="kota" class="form-control form-control-sm" placeholder="Kota" />
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" value="<?php echo $getdata['kecamatan']; ?>" name="kecamatan" id="kecamatan" class="form-control form-control-sm" placeholder="Kecamatan" />
                </div>
                <div class="form-group">
                    <label>Desa</label>
                    <input type="text" value="<?php echo $getdata['desa']; ?>" name="desa" id="desa" class="form-control form-control-sm" placeholder="Desa" />
                </div>
                <div class="form-group">
                    <label>Exp Date</label>
                    <input type="text" value="<?php echo $getdata['exp_date']; ?>" name="exp_date" id="exp_date" class="form-control form-control-sm datepicker-here" data-language="en" />
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <?php if ($getdata['exp_date'] != "") { ?>
                        <input type="file" name="foto" id="foto" value="<?php echo $getdata['foto']; ?>" class="form-control form-control-sm" placeholder="Foto" />
                    <?php } else { ?>
                        <input type="file" name="foto" id="foto" class="form-control form-control-sm" placeholder="Foto" />
                    <?php } ?>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" name="submit" class="btn btn-primary btn-sm waves-effect waves-light mr-1">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $("#form").submit(function() {
        var action = $(this).attr('data-action');
        var kode_perusahaan = $('#kode_perusahaan').val();
        var nama_perusahaan = $('#nama_perusahaan').val();
        var alamat = $('#alamat').val();
        var no_hp = $('#no_hp').val();
        if (kode_perusahaan == "") {
            Swal.fire("Oopss", "Data Tidak Boleh Kosong", "warning");
            $('#kode_perusahaan').focus();
            return false;
        } else if (nama_perusahaan == "") {
            Swal.fire("Oopss", "Data Tidak Boleh Kosong", "warning");
            $('#nama_perusahaan').focus();
            return false;
        } else if (alamat == "") {
            Swal.fire("Oopss", "Data Tidak Boleh Kosong", "warning");
            $('#alamat').focus();
            return false;
        } else if (no_hp == "") {
            Swal.fire("Oopss", "Data Tidak Boleh Kosong", "warning");
            $('#no_hp').focus();
            return false;
        } else {
            location.href = action;
            return true;
        }
    });
</script>