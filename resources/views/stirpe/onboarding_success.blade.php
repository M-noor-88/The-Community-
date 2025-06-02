<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تم الدفع بنجاح</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white shadow-lg rounded-2xl p-6 text-center border border-gray-200">

            <!-- Success Icon -->
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Message -->
            <h2 class="text-2xl font-bold mb-2">تمت عملية الدفع بنجاح!</h2>
            <p class="text-gray-600 mb-4">
                شكرًا لمساهمتك في هذه المبادرة 🙏<br>
                لقد تم استلام تبرعك وتسجيله بنجاح.
            </p>

            <!-- Transaction ID -->
            @if(isset($transaction_id))
                <div class="bg-gray-100 text-right rounded-md p-3 mb-4">
                    <p class="text-sm text-gray-500">رقم العملية:</p>
                    <p class="text-lg font-medium text-gray-800">{{ $transaction_id }}</p>
                </div>
            @endif

        </div>
    </div>

</body>
</html>
