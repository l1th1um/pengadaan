 <html>
    <head>
        <style>
            html * { font-family: Arial; font-size: 14px}
            .address { line-height: 0.4em; }
            .paragraph { text-align: justify }
            div.centered  { text-align: center; }
            div.centered table {  margin: 0 auto; text-align: left; }
            table.item { width: 600px; border-collapse: collapse; }
            table.item td, table.item th{ border : 1px solid #000000;padding: 0 10px; line-height: 30px; }
            table.item thead tr td { text-align: center }
            .right { text-align: right }
            .center { text-align: center }
        </style>
    </head>
    <body>
        <p style="text-align: right">
            Serpong, {{ $data->purchase_order->letter_date }}
        </p>
        <table>
            <tr>
                <td width="80px">Nomor</td>
                <td style="width: 50px;text-align: center">:</td>
                <td>{{ $data->purchase_order->letter_no }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td style="text-align: center">:</td>
                <td>Surat Pesanan</td>
            </tr>
        </table>
        <p style="margin-top: 30px;" class="address">
            Kepada Yth.
        </p>
        <p class="address"><strong>{{$data->company_name}}</strong></p>
        <p class="address"><strong>{{$data->address}}</strong></p>

        @if (! empty($data->phone))
            <p class="address">Telp. {{$data->phone}}</p>
        @endif

        @if (! empty($data->fax))
            <p class="address">Fax. {{$data->fax}}</p>
        @endif

        <p style="margin-top: 30px;">
            Dengan hormat,
        </p>

        <p style="margin-top: 30px;" class="paragraph">
            Sesuai dengan penawaran harga dari {{$data->company_name}} No. {{$data->offering_letter_no}} tanggal {{localeDate($data->offering_letter_date)}}, mohon untuk pengiriman barang dibawah ini:
        </p>
        <div class="centered">
            <table class="item">
                <thead>
                    <tr>
                        <th width="50px">No.</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga Satuan (Rp.)</th>
                        <th>Total (Rp.)</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    $total = 0;
                ?>
                @foreach($data->procurement_item as $row)
                    <tr>
                        <td style="text-align: center">{{$i}}</td>
                        <td>{{ $row->item_name }}</td>
                        <td class="center">{{ $row->amount." ". $row->unit}}</td>
                        <td class="right">{{ number_format($row->unit_price) }}</td>
                        <td class="right">{{ number_format($row->unit_price * $row->amount) }}</td>
                    </tr>
                    <?php
                        $i++;
                        $total += $row->unit_price * $row->amount;
                    ?>
                @endforeach
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Jumlah</strong></td>
                        <td class="right">{{ number_format($total) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>PPN 10%</strong></td>
                        <td class="right">{{ number_format($total * 0.1)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Total</strong></td>
                        <td class="right"><strong>{{ number_format($total + ($total * 0.1))}}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p style="margin-top: 30px;" class="paragraph">
            Terbilang : <strong>{{ terbilang($total + ($total * 0.1)) }} rupiah</strong>
        </p>
        <p style="margin-top: 30px;" class="paragraph">
            {!! $data->purchase_order->additional_info !!}
        </p>
        <p style="margin-top: 30px;" class="paragraph">
            Demikian atas perhatian dan kerjasamanya kami ucapkan terima kasih.
        </p>
        <table style="width: 600px;margin-top: 40px">
            <tr>
                <td style="border-top : 1px solid #000000;border-bottom : 1px solid #000000;width:40%" rowspan="2">
                    <ul>
                        <li>Mohon untuk ditandatangani dan difax kembali ke (021) 7560549</li>
                        <li>Kwitansi penagihan ditujukan kepada :
                            <ul>
                                <li><strong>Bidang Teknologi Proses dan Katalisis</strong></li>
                                <li><strong>NPWP : 00.397.688.3-411.000</strong></li>
                            </ul>
                        </li>
                    </ul>
                </td>
                <td style="border-top : 1px solid #000000;border-bottom : 1px solid #000000;width:30%;text-align: center">
                    <strong>Pejabat Pengadaan Bidang Teknologi Proses dan Katalisis T.A 2015,</strong>
                </td>
                <td style="border-top : 1px solid #000000;border-bottom : 1px solid #000000;width:30%;text-align: center">
                    <strong>{{ $data->company_name  }}</strong>
                    <p>Menyetujui,</p>
                </td>
            </tr>
            <tr>
                <td style="height: 150px;vertical-align: bottom;border-bottom : 1px solid #000000;text-align: center">
                    <p class="address"><strong><u>Nandang Sutiana</u></strong></p>
                    <p class="address"><strong>NIP. 19771118200911101</strong></p>
                </td>
                <td style="height: 150px;vertical-align: bottom;border-bottom : 1px solid #000000;;text-align: center">
                    <p class="address"><strong><u>{{ $data->contact_person }}</u></strong></p>
                    <p class="address">&nbsp;</p>
                </td>
            </tr>
        </table>
    </body>
</html>