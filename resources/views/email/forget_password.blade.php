<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password Email</title>
</head>
<body>
<table>
    <tr>
        <td>Dear {{ $name }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            Your Password has been successfully Update.<br>
            Your Password information is as below:
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Email : {{ $email }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>New Password : {{ $password }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        Thanks & Regards<br>
        E-com Website
    </tr>
</table>
</body>
</html>