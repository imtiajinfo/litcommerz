@php
    $setting = Helper::setting();
    $ship = $invoice->is_shipping == 1
        ? json_decode($invoice->shipping_info->shipping_info)
        : json_decode($invoice->shipping_info->user_info);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #000; margin:0; padding:0; }
        .invoice-container { max-width:950px; margin:20px auto; padding:0 30px 30px 30px; }
        .logo { max-width:100px; }
        .header-table { width:100%; margin-bottom: 10px; } /* Reduced margin */
        .invoice-title { font-weight:700; font-size:24px; margin:0; }
        .info-block { font-size:13px; line-height:1.2; } /* Reduced line height */
        .support { font-size:13px; font-weight:600; color:#444; }
        .table { width:100%; border-collapse: collapse; margin-bottom:5px; } /* Reduced margin */
        .table th, .table td { padding: 4px 10px; border:1px solid #dee2e6; text-align:center; font-size:13px; line-height:1.2; } /* Reduced padding and line height */
        .table th { background:#f7f7f7; font-weight:600; }
        .totals-table { font-size:13px; border: 1px solid #ddd;; width:100%; max-width:340px; margin-left:auto; }
        .totals-table td {
              border: none;
              padding: 3px 10px;
              line-height: 1.2;
          }
          .subtotal-row td {
              background: #f4f6f8ff;
          }
        .totals-table tr.total-row { background:#f0f8ff; font-weight:700; }
        .print-button { background:#525755; border:none; color:white; padding:10px 32px; font-size:15px; cursor:pointer; }
        @media print { .no-print { display:none !important; } }
    </style>
</head>
<body>
    <div class="invoice-container">

        @if(@$type != 'pdf')
            <div class="no-print" style="margin-bottom:10px;">
                <button class="print-button" onclick="window.print()">Print</button>
                <a class="print-button" href="/orders">Order List</a>
            </div>
        @endif

        <table class="header-table">
            <tr>
                <td style="width:33%; vertical-align:middle; text-align:left;">
                    @php $logoPath = public_path('frontend/logo/' . $setting->logo); @endphp
                    @if(file_exists($logoPath))
                        <img src="data:image/{{ pathinfo($logoPath, PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents($logoPath)) }}" class="logo" />
                    @else
                        <img src="https://placehold.co/100x110?text=Logo" class="logo" />
                    @endif
                </td>
                <td style="width:33%; vertical-align:middle; text-align:center;">
                    <h1 class="invoice-title">Buy Price PDF</h1>
                </td>
                <td style="width:33%; vertical-align:middle; text-align:right;">
                </td>
            </tr>
        </table>

        <table class="header-table">
            <tr>
                <td style="width:33%; vertical-align:top; text-align:left;">
                    <div class="info-block"><strong>Date:</strong> {{date('M d, Y',strtotime($invoice->created_at))}}</div>
                    <div class="info-block"><strong>Invoice No:</strong> #{{$invoice->id}}</div>
                    <div class="info-block"><strong>Customer ID:</strong> {{$invoice->user_id}}</div>
                </td>
                <td style="width:34%;"></td>
                <td style="width:33%; vertical-align:top; text-align:right;">
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:55%; text-align:left;">Product Name</th>
                    <th style="width:15%">Unit Price</th>
                    <th style="width:10%">Qty</th>
                    <th style="width:15%">Total</th>
                </tr>
            </thead>
            <tbody>
              @php $subTotal = 0; @endphp
                @foreach ($products as $key => $item)
                    @php
                        $unitPrice = $item->buy_price;
                        $totalPrice = $unitPrice * $item->quantity;
                        $subTotal += $totalPrice;
                    @endphp
                    <tr>
                        <td>{{$key+1}}</td>
                        <td style="text-align:left;">
                            {{ $item->product_name }}
                            @if(@$item->short_name)
                                ({{ $item->weight ?? '1' }}{{ $item->short_name }})
                            @endif
                        </td>
                        <td>{{number_format($unitPrice, 0)}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{number_format($totalPrice, 0)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table style="width:100%; margin-top:20px;">
            <tr>
                <td style="width:50%; vertical-align:top;">
                    <div class="info-block">{{$invoice->note}}</div>
                </td>
                <td style="width:50%; vertical-align:top;">
                    <table class="totals-table">
                        <tr class="subtotal-row">
                            <td style="text-align:left;">Subtotal:</td>
                            <td style="text-align:right;">{{number_format($subTotal , 0)}}</td>
                        </tr>
                        <tr class="subtotal-row">
                            <td style="text-align:left;">Coupon Discount:</td>
                            <td style="text-align:right;">{{number_format($invoice->coupon, 0)}}</td>
                        </tr>
                        <tr class="subtotal-row">
                            <td style="text-align:left;">Shipping:</td>
                            <td style="text-align:right;">{{number_format($invoice->shipping_amount, 0)}}</td>
                        </tr>
                        @if ($invoice->points_used > 0)
                        <tr class="subtotal-row">
                            <td style="text-align:left;">Points Used:</td>
                            <td style="text-align:right;">{{number_format($invoice->points_used, 0)}}</td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td style="text-align:left;">Total(Yen):</td>
                            <td style="text-align:right;">{{number_format($subTotal + $invoice->shipping_amount - $invoice->coupon - $invoice->points_used, 0)}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    @if(@$type != 'pdf')
        <script>window.print();</script>
    @endif
</body>
</html>