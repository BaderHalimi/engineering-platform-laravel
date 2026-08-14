<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ code: ['', '', '', '', '', ''], loading: false, resendLoading: false, resendCooldown: 0 }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التحقق من البريد الإلكتروني</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.local-fonts')

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: '#f5ad2a',
                        teal: '#526970',
                        mist: '#eef2f3',
                        ivory: '#f8f4ec',
                        slate: '#3d5057',
                    },
                    fontFamily: {
                        display: ['"DIN Next LT Arabic"', 'sans-serif'],
                        body: ['"DIN Next LT Arabic"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        * { font-family: var(--font-primary); }
        .font-display { font-family: var(--font-display); }

        body {
            background: #eef2f3;
        }

        .glass-card {
            background: rgba(248, 244, 236, 0.72);
            backdrop-filter: blur(24px) saturate(160%);
            -webkit-backdrop-filter: blur(24px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow:
                0 25px 50px -12px rgba(61, 80, 87, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.15) inset;
        }

        .field-input {
            background: rgba(255, 255, 255, 0.55);
            border: 1.5px solid rgba(82, 105, 112, 0.15);
            transition: all 0.35s cubic-bezier(.2,.8,.2,1);
        }
        .field-input:focus {
            background: rgba(255, 255, 255, 0.9);
            border-color: #f5ad2a;
            box-shadow: 0 0 0 4px rgba(245, 173, 42, 0.15), 0 8px 20px -6px rgba(245, 173, 42, 0.35);
            outline: none;
        }

        .glow-orange {
            box-shadow: 0 10px 30px -8px rgba(245, 173, 42, 0.55), 0 0 0 1px rgba(245, 173, 42, 0.3) inset;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f5ad2a 0%, #e89a15 100%);
            transition: all 0.3s cubic-bezier(.2,.8,.2,1);
        }
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px -10px rgba(245, 173, 42, 0.6);
        }
        .btn-primary:active:not(:disabled) { transform: translateY(0); }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.55);
            border: 1.5px solid rgba(82, 105, 112, 0.15);
            transition: all 0.3s cubic-bezier(.2,.8,.2,1);
        }
        .btn-ghost:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.85);
            border-color: rgba(82, 105, 112, 0.3);
        }
        .btn-ghost:disabled { opacity: 0.5; cursor: not-allowed; }

        .hero-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(60px);
            opacity: 0.55;
        }

        .float-1 { animation: float1 9s ease-in-out infinite; }
        .float-2 { animation: float2 11s ease-in-out infinite; }
        @keyframes float1 {
            0%, 100% { transform: translate(0,0) rotate(0deg); }
            50% { transform: translate(16px,-24px) rotate(6deg); }
        }
        @keyframes float2 {
            0%, 100% { transform: translate(0,0) rotate(0deg); }
            50% { transform: translate(-20px,18px) rotate(-5deg); }
        }

        .fade-up { animation: fadeUp 0.9s cubic-bezier(.22,1,.36,1) both; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-in { animation: cardIn 0.85s cubic-bezier(0.16, 1, 0.3, 1) both; }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(28px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        ::selection { background: rgba(245, 173, 42, 0.35); }

        .otp-box {
            transition: all 0.25s cubic-bezier(.2,.8,.2,1);
        }
        .otp-box:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: #f5ad2a;
            box-shadow: 0 0 0 4px rgba(245, 173, 42, 0.15), 0 8px 20px -6px rgba(245, 173, 42, 0.35);
            outline: none;
            transform: translateY(-2px);
        }
        .otp-box.filled {
            border-color: rgba(245, 173, 42, 0.5);
            background: rgba(255, 255, 255, 0.75);
        }

        @keyframes shake {
            10%, 90% { transform: translateX(-1px); }
            20%, 80% { transform: translateX(2px); }
            30%, 50%, 70% { transform: translateX(-4px); }
            40%, 60% { transform: translateX(4px); }
        }
        .shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }

        .envelope-ring {
            animation: envelopePulse 2.8s ease-in-out infinite;
        }
        @keyframes envelopePulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245, 173, 42, 0.35); }
            50% { box-shadow: 0 0 0 14px rgba(245, 173, 42, 0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center overflow-x-hidden relative px-4 py-10">

    <!-- زخارف خلفية -->
    <div class="hero-orb float-1" style="width:380px;height:380px;background:#f5ad2a;top:-100px;right:-120px;opacity:0.22;"></div>
    <div class="hero-orb float-2" style="width:340px;height:340px;background:#526970;bottom:-90px;left:-110px;opacity:0.20;"></div>

    <div class="w-full max-w-md relative z-10 card-in">

        <!-- شعار -->
        <div class="flex flex-col items-center mb-7 fade-up">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center glow-orange mb-3" style="background:#f5ad2a;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L20 7V17L12 22L4 17V7L12 2Z" stroke="#3d5057" stroke-width="1.8" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" fill="#3d5057"/>
                </svg>
            </div>
            <h2 class="font-display text-xl font-semibold" style="color:#3d5057;">أوراق</h2>
        </div>

        <div class="glass-card rounded-[2rem] p-6 sm:p-9">

            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 rounded-2xl flex items-center justify-center envelope-ring" style="background:rgba(245, 173, 42, 0.15);">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#f5ad2a" stroke-width="1.8">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 7l9 6 9-6"/>
                    </svg>
                </div>

                <h1 class="font-display text-2xl sm:text-3xl font-semibold mt-6 mb-2" style="color:#3d5057;">
                    تحقّق من بريدك الإلكتروني
                </h1>

                <p class="text-sm leading-6" style="color:#526970;">
                    أرسلنا رمز تحقّق مكوّناً من 6 أرقام إلى
                </p>

                <p class="font-semibold text-sm mt-1" style="color:#3d5057;">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <!-- رسالة النجاح / الخطأ -->
            <div
                id="message"
                x-cloak
                x-show="false"
                class="mb-6 rounded-2xl px-4 py-3 text-sm text-center font-medium">
            </div>

            <form id="verifyForm">
                @csrf

                <div class="flex justify-center gap-2 sm:gap-3" dir="ltr" id="otpGroup">
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="otp-box field-input w-11 h-14 sm:w-13 sm:h-16 rounded-2xl text-center text-2xl font-semibold otp-input"
                        style="color:#3d5057;">
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="otp-box field-input w-11 h-14 sm:w-13 sm:h-16 rounded-2xl text-center text-2xl font-semibold otp-input"
                        style="color:#3d5057;">
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="otp-box field-input w-11 h-14 sm:w-13 sm:h-16 rounded-2xl text-center text-2xl font-semibold otp-input"
                        style="color:#3d5057;">
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="otp-box field-input w-11 h-14 sm:w-13 sm:h-16 rounded-2xl text-center text-2xl font-semibold otp-input"
                        style="color:#3d5057;">
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="otp-box field-input w-11 h-14 sm:w-13 sm:h-16 rounded-2xl text-center text-2xl font-semibold otp-input"
                        style="color:#3d5057;">
                    <input type="text" inputmode="numeric" maxlength="1"
                        class="otp-box field-input w-11 h-14 sm:w-13 sm:h-16 rounded-2xl text-center text-2xl font-semibold otp-input"
                        style="color:#3d5057;">
                </div>

                <input type="hidden" id="otp" name="otp" autocomplete="one-time-code">

                <button
                    type="submit"
                    id="verifyBtn"
                    class="btn-primary w-full text-white py-3.5 rounded-2xl font-semibold text-sm mt-8">
                    <span id="verifyBtnText">تأكيد البريد الإلكتروني</span>
                </button>
            </form>

            <button
                id="resend"
                type="button"
                class="btn-ghost w-full py-3.5 rounded-2xl font-medium text-sm mt-3"
                style="color:#3d5057;">
                <span id="resendText">إعادة إرسال الرمز</span>
            </button>

            <p class="text-center text-sm mt-6" style="color:#526970;">
                لم يصلك البريد؟ تحقّق من مجلد الرسائل غير المرغوب فيها
            </p>
        </div>

        <a
            href="/logout"
            class="block mt-6 text-center text-sm font-medium hover:opacity-70 transition-opacity"
            style="color:#c0392b;">
            تسجيل الخروج
        </a>
    </div>

    <script>
        // ==== تنقل تلقائي بين خانات الرمز ====
        const inputs = Array.from(document.querySelectorAll('.otp-input'));
        const hiddenOtp = document.getElementById('otp');
        const otpGroup = document.getElementById('otpGroup');

        function updateHiddenValue() {
            hiddenOtp.value = inputs.map(i => i.value).join('');
        }

        inputs.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                const val = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = val;
                if (val) {
                    input.classList.add('filled');
                    if (idx < inputs.length - 1) inputs[idx + 1].focus();
                } else {
                    input.classList.remove('filled');
                }
                updateHiddenValue();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && idx > 0) {
                    inputs[idx - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                pasted.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                        inputs[i].classList.add('filled');
                    }
                });
                updateHiddenValue();
                const next = inputs[Math.min(pasted.length, inputs.length - 1)];
                if (next) next.focus();
            });
        });

        inputs[0].focus();

        // ==== منطق النموذج ====
        const form = document.getElementById('verifyForm');
        const resend = document.getElementById('resend');
        const message = document.getElementById('message');
        const verifyBtn = document.getElementById('verifyBtn');
        const verifyBtnText = document.getElementById('verifyBtnText');
        const resendText = document.getElementById('resendText');

        function showMessage(text, type) {
            message.style.display = 'block';
            message.className = "mb-6 rounded-2xl px-4 py-3 text-sm text-center font-medium";
            if (type === "success") {
                message.style.background = "rgba(34, 197, 94, 0.12)";
                message.style.color = "#15803d";
            } else {
                message.style.background = "rgba(220, 38, 38, 0.1)";
                message.style.color = "#c0392b";
                otpGroup.classList.add('shake');
                setTimeout(() => otpGroup.classList.remove('shake'), 500);
            }
            message.innerHTML = text;
        }

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            if (hiddenOtp.value.length !== 6) {
                showMessage("الرجاء إدخال الرمز المكوّن من 6 أرقام كاملاً", "error");
                return;
            }

            verifyBtn.disabled = true;
            verifyBtnText.textContent = "جارٍ التحقق...";

            try {
                const response = await fetch("{{ route('verification.verify') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        otp: hiddenOtp.value
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showMessage(data.message, "success");
                    verifyBtnText.textContent = "تم التحقق ✓";
                    setTimeout(() => {
                        location.href = data.redirect;
                    }, 1000);
                } else {
                    showMessage(data.message, "error");
                    verifyBtn.disabled = false;
                    verifyBtnText.textContent = "تأكيد البريد الإلكتروني";
                }
            } catch (err) {
                showMessage("حدث خطأ ما، الرجاء المحاولة مرة أخرى", "error");
                verifyBtn.disabled = false;
                verifyBtnText.textContent = "تأكيد البريد الإلكتروني";
            }
        });

        let cooldownInterval;
        function startCooldown(seconds) {
            let remaining = seconds;
            resend.disabled = true;
            clearInterval(cooldownInterval);
            cooldownInterval = setInterval(() => {
                resendText.textContent = `إعادة الإرسال بعد ${remaining} ثانية`;
                remaining--;
                if (remaining < 0) {
                    clearInterval(cooldownInterval);
                    resend.disabled = false;
                    resendText.textContent = "إعادة إرسال الرمز";
                }
            }, 1000);
        }

        resend.addEventListener("click", async () => {
            resend.disabled = true;
            const originalText = resendText.textContent;
            resendText.textContent = "جارٍ الإرسال...";

            try {
                const response = await fetch("{{ route('verification.resend') }}", {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });

                const data = await response.json();
                showMessage(data.message, data.success ? "success" : "error");

                if (data.success) {
                    startCooldown(60);
                } else {
                    resend.disabled = false;
                    resendText.textContent = originalText;
                }
            } catch (err) {
                showMessage("تعذّر إرسال الرمز، الرجاء المحاولة لاحقاً", "error");
                resend.disabled = false;
                resendText.textContent = originalText;
            }
        });
    </script>
</body>
</html>
