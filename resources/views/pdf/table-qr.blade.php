<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>QR Code - {{ $table->name }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #111827;
            text-align: center;
        }
        .print-area {
            padding-top: 60px;
            padding-bottom: 20px;
        }
        .card {
            margin: 0 auto;
            width: 500px;
            border: 8px solid #111827;
            border-radius: 40px;
            padding: 40px;
            background-color: #ffffff;
        }
        .header {
            border-bottom: 3px solid #f3f4f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-text {
            font-size: 42px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            color: #111827;
        }
        .subtitle {
            font-size: 16px;
            color: #6b7280;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 4px;
        }
        .table-name {
            font-size: 64px;
            font-weight: 900;
            color: #ffffff;
            background-color: #111827;
            display: inline-block;
            padding: 10px 40px;
            border-radius: 20px;
            margin: 0 0 30px 0;
        }
        .qr-wrapper {
            background-color: #ffffff;
            border: 4px solid #111827;
            padding: 20px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 30px;
        }
        .qr-image {
            width: 320px;
            height: 320px;
            display: block;
        }
        .instruction {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
            margin: 0 0 10px 0;
        }
        .sub-instruction {
            font-size: 16px;
            color: #4b5563;
            margin: 0;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="print-area">
        <div class="card">
            <div class="header">
                <h1 class="logo-text">MAAJU COFFEE</h1>
                <div class="subtitle">Premium Quality</div>
            </div>
            
            <div class="table-name">{{ $table->name }}</div>
            
            <div class="qr-wrapper">
                <img class="qr-image" src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
            </div>
            
            <p class="instruction">SCAN UNTUK MEMESAN</p>
            <p class="sub-instruction">Arahkan kamera HP Anda ke QR Code<br>Pesan dan bayar langsung dari meja Anda</p>
        </div>
    </div>
</body>
</html>
