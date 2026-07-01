<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <div class="text-center">

            <div class="mx-auto w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center">
                ✉️
            </div>

            <h1 class="mt-6 text-2xl font-bold text-gray-900">
                Verify Your Email
            </h1>

            <p class="mt-3 text-gray-500">
                We've sent a verification code to
            </p>

            <p class="font-semibold text-gray-800 mt-1">
                {{ auth()->user()->email }}
            </p>

        </div>

        <div
            id="message"
            class="hidden mt-5 rounded-lg px-4 py-3 text-sm">
        </div>

        <form id="verifyForm" class="mt-8">

            @csrf

            <input
                id="otp"
                name="otp"
                maxlength="6"
                autocomplete="one-time-code"
                placeholder="123456"
                class="w-full rounded-xl border border-gray-300 py-4 text-center text-3xl tracking-[0.4em] focus:border-orange-500 focus:ring-orange-500">

            <button
                class="mt-6 w-full rounded-xl bg-orange-500 py-3 font-semibold text-white hover:bg-orange-600 transition">

                Verify Email

            </button>

        </form>

        <button
            id="resend"
            class="mt-4 w-full rounded-xl border border-gray-300 py-3 hover:bg-gray-100">

            Resend Code

        </button>

        <a
            href="/logout"
            class="block mt-6 text-center text-red-500">

            Logout

        </a>

    </div>

</div>

<script>

const form = document.getElementById('verifyForm');
const resend = document.getElementById('resend');
const message = document.getElementById('message');

function show(text,color){

    message.className =
        "mt-5 rounded-lg px-4 py-3 text-sm";

    if(color==="green"){
        message.classList.add("bg-green-100","text-green-700");
    }else{
        message.classList.add("bg-red-100","text-red-700");
    }

    message.innerHTML=text;
}

form.addEventListener("submit",async(e)=>{

    e.preventDefault();

    const response = await fetch("{{ route('verification.verify') }}",{

        method:"POST",

        headers:{
            "Content-Type":"application/json",
            "Accept":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },

        body:JSON.stringify({

            otp:document.getElementById("otp").value

        })

    });

    const data = await response.json();

    if(data.success){

        show(data.message,"green");

        setTimeout(()=>{

            location.href=data.redirect;

        },1000);

    }else{

        show(data.message,"red");

    }

});

resend.addEventListener("click",async()=>{

    const response = await fetch("{{ route('verification.resend') }}",{

        method:"POST",

        headers:{
            "Accept":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        }

    });

    const data = await response.json();

    show(data.message,data.success?"green":"red");

});

</script>
