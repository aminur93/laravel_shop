<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <style type="text/css" media="all">
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 18cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(/admin/img/dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="./admin/img/logo.png">
    </div>
    <h1>INVOICE {{ $orderdetails->id }}</h1>
    <div id="project" class="clearfix">
        <div><span>Order Id</span> {{ $orderdetails->id }}</div>
        <div><span>Order Date</span> {{ $orderdetails->created_at }}</div>
        <div><span>Order Amount</span> {{ $orderdetails->grand_total }}</div>
        <div><span>Status</span> {{ $orderdetails->order_status }}</div>
        <div><span>Payment Method</span> {{ $orderdetails->payment_method }}</div>
    </div>
    <div id="project" style="float: right;">
        <div><strong>Shipping Address</strong></div>
        <div><span>Name</span> {{ $orderdetails->name }}</div>
        <div><span>Address</span> {{ $orderdetails->address }}</div>
        <div><span>City</span> {{ $orderdetails->city }}</div>
        <div><span>State</span> {{ $orderdetails->state }} </div>
        <div><span>Pincode</span> {{ $orderdetails->pincode }}</div>
        <div><span>Country</span> {{ $orderdetails->country }}</div>
        <div><span>Mobile</span> {{ $orderdetails->mobile }}</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th>Product Code</th>
            <th>Size</th>
            <th>Color</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $subtotal = 0; ?>
        @foreach ($orderdetails->orders as $pro)
        <tr>
            <td>{{$pro->product_code}}</td>
            <td>{{$pro->product_size}}</td>
            <td>{{$pro->product_color}}</td>
            <td>Tk {{$pro->product_price}}</td>
            <td>{{$pro->product_qty}}</td>
            <td>Tk {{$pro->product_price * $pro->product_qty }}</td>
        </tr>
        <?php $subtotal = $subtotal + ($pro->product_price * $pro->product_qty); ?>
        @endforeach
        <tr>
            <td colspan="5">SUBTOTAL</td>
            <td class="total">Tk {{ $subtotal }}</td>
        </tr>
        <tr>
            <td colspan="5">Shipping Charge (+)</td>
            <td class="total">Tk {{ $orderdetails->shipping_charge }}</td>
        </tr>

        <tr>
            <td colspan="5">Coupon Amount (-)</td>
            <td class="total">Tk {{ $orderdetails->coupon_amount }}</td>
        </tr>

        <tr>
            <td colspan="5" class="grand total">GRAND TOTAL</td>
            <td class="grand total">Tk {{ $orderdetails->grand_total }}</td>
        </tr>
        </tbody>
    </table>
    <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div>
</main>
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>