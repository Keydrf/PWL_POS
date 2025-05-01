<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 20px 25px 20px 25px;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 4px;
            vertical-align: top;
        }
        th {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .border-bottom-header {
            border-bottom: 1px solid #000;
        }
        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid #000;
        }
        img.logo {
            height: 80px;
        }
    </style>
</head>
<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('polinema-bw.jpeg'))) }}" class="logo">
            </td>
            <td width="85%" class="text-center">
                <div style="font-weight: bold;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                <div style="font-size: 13pt; font-weight: bold;">POLITEKNIK NEGERI MALANG</div>
                <div>Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                <div>Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</div>
                <div>Laman: www.polinema.ac.id</div>
            </td>
        </tr>
    </table>

    <h3 class="text-center" style="margin-top: 10px;">LAPORAN DATA KATEGORI</h3>

    <table class="border-all" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="20%">Kode Kategori</th>
                <th width="50%">Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $k)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $k->kategori_kode }}</td>
                <td>{{ $k->kategori_nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
