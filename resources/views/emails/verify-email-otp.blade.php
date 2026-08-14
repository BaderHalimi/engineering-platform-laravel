<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحقق من بريدك الإلكتروني</title>
    <style>
        /* التنسيقات العامة الآمنة للبريد الإلكتروني */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #eef2f3; font-family: 'DIN Next LT Arabic', Tahoma, Arial, sans-serif; }

        /* تنسيق محاكاة الـ Blur والـ Premium Theme الخاص بك */
        .email-bg {
            background: #eef2f3 linear-gradient(135deg, #fffcf6 0%, #eef2f3 100%);
            padding: 40px 20px;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            max-width: 420px;
            margin: 0 auto;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px -15px rgba(61, 80, 87, 0.1);
        }
        h2 {
            color: #3d5057;
            font-size: 24px;
            font-weight: 700;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        p {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin-top: 0;
            margin-bottom: 25px;
        }
        .otp-box {
            font-size: 38px;
            font-weight: 800;
            color: #f5ad2a;
            letter-spacing: 12px;
            padding: 20px;
            background-color: #fcf8f2;
            border-radius: 16px;
            border: 2px dashed #f5ad2a;
            margin-bottom: 25px;
            display: block;
            text-align: center;
        }
        .info-text {
            font-weight: 600;
            color: #3d5057;
            font-size: 15px;
            margin-bottom: 8px;
        }
        .timer-container {
            display: inline-block;
            background-color: #fef2f2;
            padding: 6px 14px;
            border-radius: 30px;
            margin-top: 5px;
        }
        .timer-text {
            font-size: 13px;
            color: #ef4444;
            font-weight: 600;
            vertical-align: middle;
            display: inline-block;
        }
        .icon-svg {
            display: inline-block;
            vertical-align: middle;
            fill: currentColor;
        }
    </style>
</head>
<body>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" class="email-bg">

                <div class="card">

                    <div style="color: #3d5057;">
                        <svg class="icon-svg" width="48" height="48" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.5 1.1 2.5 2.5S13.4 12 12 12s-2.5-1.1-2.5-2.5S10.6 7 12 7zm0 10c-2.1 0-4.2-1.05-5-2.73C7.03 12.78 10.32 12 12 12s4.97.78 5 2.27C16.2 15.95 14.1 17 12 17z"/>
                        </svg>
                    </div>

                    <h2>تحقّق من بريدك</h2>
                    <p>استخدم هذا الرمز لإتمام العملية بأمان</p>

                    <div class="otp-box">
                        {{ $otp }}
                    </div>

                    <p class="info-text">رمز تأكيد البريد الإلكتروني الخاص بك</p>

                    <div class="timer-container">
                        <svg class="icon-svg" width="14" height="14" viewBox="0 0 24 24" style="color: #ef4444; margin-left: 4px;" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/>
                        </svg>
                        <span class="timer-text">الرمز صالح لمدة 10 دقائق فقط</span>
                    </div>

                </div>

            </td>
        </tr>
    </table>

</body>
</html>
