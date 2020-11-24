<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Penjualan (Bulan Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="text-align:left"><?php echo $hariini; ?> Transaksi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Penjualan (Bulan Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="text-align:right">Rp. <?php echo number_format($totbulan['total'], 2); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Penjualan (Hari Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="text-align:right">Rp. 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Saldo Sekarang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="text-align:right">Rp. <?php echo number_format($totbulan['total'], 2); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">15 Stok Barang yang Akan Habis</h4>
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="width: 2%;background-color:#0085cd;color:white;text-align:center" rowspan="2">No</th>
                            <th style="width: 20%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Nama Barang</th>
                            <th style="width: 5%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Satuan</th>
                            <th style="width: 5%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Kategori</th>
                            <th style="width: 6%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Stok Min</th>
                            <th style="width: 6%;background-color:#0085cd;color:white;text-align:center" rowspan="2">Stok</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #a6cdd8;">
                        <?php
                        $no                     = 1;
                        foreach ($data as $d) {
                            if ($d->stok <= $d->min_stok) {
                        ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $d->nama_barang; ?></td>
                                    <td><?php echo $d->satuan; ?></td>
                                    <td><?php echo $d->nama_kategori; ?></td>
                                    <td align="center">
                                        <?php if (!empty($d->min_stok)) {
                                            echo number_format($d->min_stok);
                                        } ?>
                                    </td>
                                    <td align="center">
                                        <?php if (!empty($d->stok)) {
                                            echo number_format($d->stok);
                                        } ?>
                                    </td>
                                </tr>
                        <?php
                                $no++;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end card-->
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Barang Yang akan Kadaluarsa <= 15 Hari</h4>
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="width: 2%;background-color:#0085cd;color:white;text-align:center">No</th>
                            <th style="width: 15%;background-color:#0085cd;color:white;text-align:center">Nama Barang</th>
                            <th style="width: 5%;background-color:#0085cd;color:white;text-align:center">Satuan</th>
                            <th style="width: 7%;background-color:#0085cd;color:white;text-align:center">Kategori</th>
                            <th style="width: 10%;background-color:#0085cd;color:white;text-align:center">Exp Date</th>
                            <th style="width: 5%;background-color:#0085cd;color:white;text-align:center">Sisa Hari</th>
                    </thead>
                    <tbody style="background-color: #a6cdd8;">
                        <?php
                        $no                     = 1;
                        foreach ($data as $d) {
                            $brg    = @$data[$key + 1]->exp_date;
                            $exp    = $d->exp_date;
                            $skr    = date('Y-m-d');
                            $tgl1   = new DateTime("$exp");
                            $tgl2   = new DateTime("$skr");
                            $sisa   = $tgl2->diff($tgl1)->days + 1;
                            if (15 >= $sisa) {
                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d->nama_barang; ?></td>
                                    <td><?php echo $d->satuan; ?></td>
                                    <td><?php echo $d->nama_kategori; ?></td>
                                    <td><?php echo dateToIndo2($d->exp_date); ?></td>
                                    <td><?php echo $sisa; ?></td>
                                </tr>
                                <?php if ($brg != $d->exp_date) { ?>
                                    <tr bgcolor="#024a75" style="color:white; text-align: right">
                                        <td style="color:#024a75" colspan="8">.</td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end card-->
    </div>
</div>

<?php
foreach ($data as $data) {
    $nama[] = $data->nama_barang;
    $stok[] = (float) $data->stok;
    $min_stok[] = (float) $data->min_stok;
}
?>
<!-- 
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Column with Data Labels</h4>

                <div id="column_chart_datalabel" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Bar Chart</h4>

                <div id="bar_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Pie Chart</h4>

                <div id="pie_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Donut Chart</h4>

                <div id="donut_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div> -->

<script>
    if ($("#column_chart_datalabel").length) {
        options = {
            chart: {
                height: 350,
                type: "bar",
                toolbar: {
                    show: !1
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: "top"
                    }
                }
            },
            dataLabels: {
                enabled: !0,
                formatter: function(e) {
                    return e + "%"
                },
                offsetY: -20,
                style: {
                    fontSize: "12px",
                    colors: ["#00a7e1"]
                }
            },
            series: [{
                name: "Inflation",
                data: [2.5, 3.2, 5, 10.1, 4.2, 3.8, 3, 2.4, 4, 1.2, 3.5, .8]
            }],
            colors: ["#0db4d6"],
            grid: {
                borderColor: "#f1f1f1"
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                position: "top",
                labels: {
                    offsetY: -18
                },
                axisBorder: {
                    show: !1
                },
                axisTicks: {
                    show: !1
                },
                crosshairs: {
                    fill: {
                        type: "gradient",
                        gradient: {
                            colorFrom: "#D8E3F0",
                            colorTo: "#BED1E6",
                            stops: [0, 100],
                            opacityFrom: .4,
                            opacityTo: .5
                        }
                    }
                },
                tooltip: {
                    enabled: !0,
                    offsetY: -35
                }
            },
            fill: {
                gradient: {
                    shade: "light",
                    type: "horizontal",
                    shadeIntensity: .25,
                    gradientToColors: void 0,
                    inverseColors: !0,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [50, 0, 100, 100]
                }
            },
            yaxis: {
                axisBorder: {
                    show: !1
                },
                axisTicks: {
                    show: !1
                },
                labels: {
                    show: !1,
                    formatter: function(e) {
                        return e + "%"
                    }
                }
            },
            title: {
                text: "Monthly Inflation in Argentina, 2002",
                floating: !0,
                offsetY: 320,
                align: "center",
                style: {
                    color: "#444"
                }
            }
        };
        (chart = new ApexCharts(document.querySelector("#column_chart_datalabel"), options)).render()
    }
    if ($("#bar_chart").length) {
        options = {
            chart: {
                height: 350,
                type: "bar",
                toolbar: {
                    show: !1
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !0
                }
            },
            dataLabels: {
                enabled: !1
            },
            series: [{
                data: [380, 430, 450, 475, 550, 584, 780, 1100, 1220, 1365]
            }],
            colors: ["#7c8a96"],
            grid: {
                borderColor: "#f1f1f1"
            },
            xaxis: {
                categories: ["South Korea", "Canada", "United Kingdom", "Netherlands", "Italy", "France", "Japan", "United States", "China", "Germany"]
            }
        };
        (chart = new ApexCharts(document.querySelector("#bar_chart"), options)).render()
    }

    if ($("#pie_chart").length) {
        options = {
            chart: {
                height: 320,
                type: "pie"
            },
            series: [44, 55, 41, 17, 15],
            labels: ["Series 1", "Series 2", "Series 3", "Series 4", "Series 5"],
            colors: ["#3051d3", "#3ddc97", "#e4cc37", "#f06543", "#eff2f7"],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0,
                offsetY: -10
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                }
            }]
        };
        (chart = new ApexCharts(document.querySelector("#pie_chart"), options)).render()
    }
    if ($("#donut_chart").length) {
        var chart;
        options = {
            chart: {
                height: 320,
                type: "donut"
            },
            series: [44, 55, 41, 17, 15],
            labels: ["Series 1", "Series 2", "Series 3", "Series 4", "Series 5"],
            colors: ["#3051d3", "#00a7e1", "#3ddc97", "#f06543", "#eff2f7"],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0,
                offsetY: -10
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                }
            }]
        };
        (chart = new ApexCharts(document.querySelector("#donut_chart"), options)).render()
    }
</script>