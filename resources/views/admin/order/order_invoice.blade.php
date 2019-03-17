<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Invoice</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style type="text/css">
        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">Order # {{ $orderdetails->id }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        {{ $userDetails->name }}<br>
                        {{ $userDetails->address }}<br>
                        {{ $userDetails->city }}<br>
                        {{ $userDetails->state }}<br>
                        {{ $userDetails->country }}<br>
                        {{ $userDetails->pincode }}<br>
                        {{ $userDetails->mobile }}<br>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Shipped To:</strong><br>
                        {{ $orderdetails->name }}<br>
                        {{ $orderdetails->address }}<br>
                        {{ $orderdetails->city }}<br>
                        {{ $orderdetails->state }}<br>
                        {{ $orderdetails->country }}<br>
                        {{ $orderdetails->pincode }}<br>
                        {{ $orderdetails->mobile }}<br>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        {{ $orderdetails->payment_method }}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{ \Carbon\Carbon::parse($orderdetails->created_at)->diffForHumans() }}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="overflow-x: hidden;">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td><strong>Code</strong></td>
                                <td class="text-center"><strong>Name</strong></td>
                                <td class="text-center"><strong>Color</strong></td>
                                <td class="text-center"><strong>Size</strong></td>
                                <td class="text-center"><strong>Price</strong></td>
                                <td class="text-center"><strong>Qty</strong></td>
                                <td class="text-right"><strong>Total</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                            <?php $subtotal = 0; ?>
                            @foreach ($orderdetails->orders as $pro)
                                <tr>
                                    <td><strong>{{$pro->product_code}}</strong></td>
                                    <td class="text-center">{{$pro->product_name}}</td>
                                    <td class="text-center">{{$pro->product_color}}</td>
                                    <td class="text-center">{{$pro->product_size}}</td>
                                    <td class="text-center">Tk {{$pro->product_price}}</td>
                                    <td class="text-center">{{$pro->product_qty}}</td>
                                    <td class="text-right">Tk {{$pro->product_price * $pro->product_qty }}</td>
                                </tr>
                                <?php $subtotal = $subtotal + ($pro->product_price * $pro->product_qty); ?>
                            @endforeach

                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                <td class="thick-line text-right">Tk {{ $subtotal }}</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Shipping Charge (+)</strong></td>
                                <td class="no-line text-right">Tk {{ $orderdetails->shipping_charge }} </td>
                            </tr>

                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Coupon Amount (-)</strong></td>
                                <td class="no-line text-right">Tk {{ $orderdetails->coupon_amount }} </td>
                            </tr>

                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Grand Total</strong></td>
                                <td class="no-line text-right">Tk {{ $orderdetails->grand_total }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>