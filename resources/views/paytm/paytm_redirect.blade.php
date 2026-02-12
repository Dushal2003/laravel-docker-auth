<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redirecting to Paytm...</title>
</head>
<body>
    <p>Redirecting to Paytm gateway, please wait...</p>
    <form method="post" action="{{ $paytmTxnUrl }}" name="paytm_form">
        @foreach($params as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <input type="hidden" name="CHECKSUMHASH" value="{{ $checksum }}">
    </form>
    <script type="text/javascript">document.paytm_form.submit();</script>
</body>
</html>
