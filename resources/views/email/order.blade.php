<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body>
    <table width="700px">
        <tr><td>&nbsp;</td></tr>
        <tr><td><img src="{{ asset('user/images/home/logo.png') }}" alt=""></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Hello {{ $name }},</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thank you for shoping with us. Your order details as below:-</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Order No: {{ $order_id }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
                <table width="95%" cellspacing="5" cellpadding="5" bgcolor="#f7f4f4">
                    <tr bgcolor="#cccccc">
                        <td>Product Name</td>
                        <td>Product Code</td>
                        <td>Size</td>
                        <td>Color</td>
                        <td>Quantity</td>
                        <td>Unit Price</td>
                    </tr>
                    @foreach($productDetails['orders'] as $product)
                        <tr>

                            <td>{{ $product['product_name'] }}</td>
                            <td>{{ $product['product_code'] }}</td>
                            <td>{{ $product['product_size'] }}</td>
                            <td>{{ $product['product_color'] }}</td>
                            <td>{{ $product['product_qty'] }}</td>
                            <td>{{ $product['product_price'] }}</td>
                        </tr>
                        @endforeach
                    <tr>
                        <td colspan="5" align="right">Shipping Charges</td>
                        <td>{{ $productDetails['shipping_charge'] }}</td>
                    </tr>

                    <tr>
                        <td colspan="5" align="right">Coupon Discount</td>
                        <td>{{ $productDetails['coupon_amount'] }}</td>
                    </tr>

                    <tr>
                        <td colspan="5" align="right">Grand Total</td>
                        <td>Tk {{ $productDetails['grand_total'] }}</td>
                    </tr>
                </table>
            </td></tr>

        <tr><td>
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <table>
                                <tr><td><strong>Bill to :-</strong></td></tr>
                                <tr><td>{{ $usersDetails['name'] }}</td></tr>
                                <tr><td>{{ $usersDetails['address'] }}</td></tr>
                                <tr><td>{{ $usersDetails['city'] }}</td></tr>
                                <tr><td>{{ $usersDetails['state'] }}</td></tr>
                                <tr><td>{{ $usersDetails['country'] }}</td></tr>
                                <tr><td>{{ $usersDetails['pincode'] }}</td></tr>
                                <tr><td>{{ $usersDetails['mobile'] }}</td></tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table>
                                <tr><td><strong>Shipping to :-</strong></td></tr>
                                <tr><td>{{ $usersDetails['name'] }}</td></tr>
                                <tr><td>{{ $usersDetails['address'] }}</td></tr>
                                <tr><td>{{ $usersDetails['city'] }}</td></tr>
                                <tr><td>{{ $usersDetails['state'] }}</td></tr>
                                <tr><td>{{ $usersDetails['country'] }}</td></tr>
                                <tr><td>{{ $usersDetails['pincode'] }}</td></tr>
                                <tr><td>{{ $usersDetails['mobile'] }}</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>For any problem , you can contact us at <a href="mailto:aminurrashid126@gmail.com">sendMail</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Regards, <br>Team E-com</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>