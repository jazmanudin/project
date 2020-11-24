<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <style>
        @page {
            size: 58mm 100mm
        }

        /* output size */
        /* body.receipt .sheet {
            width: 58mm;
            height: 100mm
        } */

        /* sheet size */
        /* @media print {
            body.receipt {
                width: 58mm
            }
        } */

        h3 {
            font-weight: bold;
            font-size: 15pt;
            text-align: center;
        }

        p {
            font-weight: bold;
            font-size: 12pt;
            text-align: center;
        }

        .judul {
            border-collapse: collapse;
            font-size: 12px;
            min-width: 100%;
            font-family: Roboto, HelveticaNeue, Arial, sans-serif;

        }

        .judul th {
            font-weight: bold;
            padding: 2px;
            text-align: left;
            font-size: 14px;
        }

        .datatable3 {
            border: 2px solid #D6DDE6;
            border-collapse: collapse;
            font-size: 12px;
            min-width: 100%;
            font-family: Roboto, HelveticaNeue, Arial, sans-serif;

        }

        .datatable3 th {
            border: 2px solid #828282;
            font-weight: bold;
            padding: 5px;
            text-align: left;
            font-size: 14px;
        }

        .datatable3 td {
            border: 1px solid #000000;
            padding: 3px 3px;

        }
    </style>
</head>

<body class="receipt">
    <section class="sheet padding-10mm">
        <table class="datatable3">
            <thead>
                <tr>
                    <th style="width: 12%;background-color:#0085cd;color:white;text-align:center" colspan="3">GOOIT</th>
                </tr>
                <tr>
                    <th style="width: 30%;">No Faktur</th>
                    <th style="width: 5%;">:</th>
                    <th>Fak-12-200-21</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>:</th>
                    <th>Fak-12-200-21</th>
                </tr>
            </thead>
            <tbody style="background-color: #a6cdd8;">

            </tbody>
        </table>
    </section>
</body>

<script type="text/javascript">
    setTimeout(function() {
        window.print();
    }, 500);
    window.onfocus = function() {
        setTimeout(function() {
            window.close();
        }, 500);
    }
</script>