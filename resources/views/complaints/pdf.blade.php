<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>شكوى رسمية</title>

    <style>
        @font-face {
            font-family: 'Amiri';
            src: url('{{ storage_path("fonts/Amiri-Regular.ttf") }}') format('truetype');
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

    <p>نقدم لكم هذه الشكوى من السيد: <strong>{{ $complaint->user->name }}</strong></p>
    <p>نوع الشكوى: <strong>{{ $complaint->category->name }}</strong></p>
    <p>عنوان الشكوى: <strong>{{ $complaint->title }}</strong></p>
    <p>وصف الشكوى: <strong>{{ $complaint->description }}</strong></p>
    <p> العنوان: <strong>{{ $complaint->location->name }}</strong></p>



    @if($complaint->image)
    <p style="text-align: center;">الصورة المرفقة:</p>
    <div style="text-align: center">
    <img src="{{ $complaint->image->image_url }}" alt="صورة الشكوى" style="width: 370px; height: 200px; display: block; margin: 0 auto;">
</div>
@endif
    <div class="footer">
        <p>يرجى التفضل بالاطلاع والموافقة،</p>
        <p><strong>The-Community</strong></p>
    </div>

</body>
</html>
