<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>شكوى رسمية</title>

    <style>
        @font-face {
            font-family: 'Amiri';
            src: url('{{ storage_path('fonts/Amiri-Regular.ttf') }}') format('truetype');
        }

        body {
            font-family: 'Amiri', sans-serif;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
            padding: 40px;
            margin: 0;
            background-color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .footer {
            margin-top: 40px;
        }

        strong {
            color: #333;
        }
    </style>
</head>

<body>
    <h2>كتاب شكوى رسمي</h2>
    <p>السادة محافظة دمشق المحترمون،</p>
    <p>نقدم لكم هذه الشكوى من السيد: <strong>{{ $data['name'] }}</strong></p>
    <p>عنوان الشكوى: <strong>{{ $data['complaint_title'] }}</strong></p>
    <p>وصف الشكوى: <strong>{{ $data['complaint_description'] }}</strong></p>
    <p> العنوان: <strong>{{ $data['complaint_location'] }}</strong></p>


    @if ($data['image_url'] != 'null')
        <p style="text-align: center;">الصورة المرفقة:</p>
        <div style="text-align: center">
            <img src="{{ $data['image_url'] }}" alt="صورة الشكوى"
                style="width: 370px; height: 200px; display: block; margin: 0 auto;">
        </div>
    @endif

    <div class="footer">
        <p>يرجى التفضل بالاطلاع والموافقة،</p>
        <p><strong>The-Community</strong></p>
        <p><strong>رقم مقدم الشكوى :</strong> {{ $data['phone'] }}</p>

    </div>
</body>
</html>
