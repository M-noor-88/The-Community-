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
    <p>نقدم لكم هذه الشكوى من السيد/ة: <strong>{{ $data['name'] }}</strong></p>
    <p>عنوان الشكوى: <strong>{{ $data['complaint_title'] }}</strong></p>
    <p>وصف الشكوى: <strong>{{ $data['complaint_description'] }}</strong></p>
    <p> العنوان: <strong>{{ $data['complaint_location'] }}</strong></p>

    @if (!empty($data['complaintImages']) && $data['complaintImages']->isNotEmpty())
    <table width="100%" cellpadding="10" cellspacing="0">
        @foreach ($data['complaintImages']->chunk(2) as $chunk)
            <tr>
                @foreach ($chunk as $index => $image)
                    <td align="center" valign="top" style="border: 1px solid #ccc;">
                        <img src="{{ $image->image_url }}" alt="Achievement Image" style="width:350px height: auto; max-height: 200px; margin-bottom: 5px;">
                        <div style="font-size: 14px; margin-top: 5px;">صورة رقم {{ $loop->parent->iteration * 2 - 1 + $loop->iteration -1 }}</div>
                    </td>
                @endforeach
                @if ($chunk->count() < 2)
                    <td></td> {{-- Empty cell for alignment if odd number --}}
                @endif
            </tr>
        @endforeach
    </table>
@endif



    <div class="footer">
        <p>يرجى التفضل بالاطلاع وإجراء الحل الأنسب</p>
        <p><strong>The-Community</strong></p>
        <p><strong>رقم مقدم الشكوى :</strong> {{ $data['phone'] }}</p>

    </div>
</body>

</html>
