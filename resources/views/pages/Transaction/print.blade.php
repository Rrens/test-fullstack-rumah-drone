<html moznomarginboxes mozdisallowselectionprint>

<head>
    <title>myPos - Print Nota</title>
    <style type="text/css">
        html {
            font-family: "Verdana, Arial";
        }

        .content {
            width: 80mm;
            font-size: 12px;
            padding: 5px;
        }

        .title {
            text-align: center;
            font-size: 13px;
            padding-bottom: 5px;
            border-bottom: 1px dashed;
        }

        .head {
            margin-top: 5px;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid;
        }

        table {
            width: 100%;
            font-size: 12px
        }

        .thanks {
            margin-top: 10px;
            padding-top: 10px;
            text-align: center;
            border-top: 1px dashed;
        }

        @media print {
            @page {
                width: 80mm;
                margin: 0mm;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="content">
        <div class="title">
            <b>YukStore</b>
            <br>
            Jl.Makmur Sudimogo Gg.II
        </div>

        <div class="head">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 200px">
                        {{ $data->date }}
                    </td>
                    <td>Cashier</td>
                    <td style="text-align:center; width:10px">:</td>
                    <td style="text-align:right;">
                        {{ $data->user[0]->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ $data->invoice }}
                    </td>
                    <td>Customer</td>
                    <td style="text-align:center;">:</td>
                    <td style="text-align:right;">
                        {{ empty($data->customer) == null ? 'Umum' : $data->customer }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="transaction">
            <table class="transaction-table" cellspacing="0" cellpadding="0">

                @foreach ($data_detail as $item)
                    <tr>
                        <td style="width: 165px">{{ $item->item[0]->name }}</td>
                        <td>{{ $item->jual }}</td>
                        <td style="text-align:right; width:60px">{{ format_rupiah($item->price) }}</td>
                        <td style="text-align:right; width:60px">
                            {{ format_rupiah(($item->price - $item->discount_item) * $item->jual) }}
                        </td>
                    </tr>
                @endforeach


                <tr>
                    <td colspan="4" style="border-bottom: 1px dashed; padding: 5px 0;"></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align: right; padding: 5px 0;">Sub Total</td>
                    <td style="text-align: right; padding: 5px 0;">
                        {{ format_rupiah($data->total_price) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align: right; padding: 5px 0;">Service. Sale</td>
                    <td style="text-align: right; padding: 5px 0;">
                        {{ format_rupiah($data->service) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="border-top: 1px dashed; text-align:right; padding: 5px 0">Grand Total</td>
                    <td style="border-top: 1px dashed; text-align:right; padding: 5px 0">
                        {{ format_rupiah($data->final_price) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="border-top: 1px dashed; text-align:right; padding: 5px 0">Cash</td>
                    <td style="border-top: 1px dashed; text-align:right; padding: 5px 0">
                        {{ format_rupiah($data->cash) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align:right;">Change</td>
                    <td style="text-align:right;">
                        {{ format_rupiah($data->remaining) }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="thanks">
            --- Thank You ---
            <br>
            RUMAH DRONE
        </div>
    </div>
</body>

</html>
