<div class="row">
    <div class="col-sm-12">
        <h5 style="text-align: center;color:white;"><b>INPUT BARCODE</b></h5>
    </div>
</div>

<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>barcode/insert_barcode">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" style="padding-left:7px;padding-right:0px;">
                            <a class="btn btn-danger btn-sm btn-block getbarcode" href="#" tabindex="3">GENERATE BARCODE</a>
                        </div>
                        <div class="col-md-12" style="padding-left:7px;padding-right:0px">
                            <div class="table-responsive mb-0">
                                <table id="tech-companies-1" class="table table-striped table-bordered table-hover table-sm">
                                    <thead style="background-color: #0085cd;color:white">
                                        <tr>
                                            <th style="width: 10%;">Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th style="width: 10%;">Satuan</th>
                                            <th style="width: 10%;">Kategori Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loaddetailbarcode" style="font-size: 13px;">

                                    </tbody>

                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-end">
                                <input type="submit" name="submit" class="btn btn-block btn-sm btn-primary" value="Simpan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {


        $('.getbarcode').click(function(e) {
            var countdata = $('#countdata').val();
            if (countdata > 0) {
                Swal.fire('Oppss..', 'Semua barang sudah ada Barcode', 'warning')
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>barcode/getdetailbarcode',
                    data: '',
                    cache: false,
                    success: function(respond) {
                        $("#loaddetailbarcode").html(respond);
                    }
                });
            }
        });
    });
</script>