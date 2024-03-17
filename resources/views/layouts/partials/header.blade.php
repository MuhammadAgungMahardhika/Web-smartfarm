<header class='mb-3'>
    <nav class="navbar navbar-expand navbar-light ">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    {{-- datetime --}}
                    <li class="nav-item dropdown mx-3 mb-0  mt-4">
                        <span id="dateTime">

                        </span>
                    </li>

                    {{-- languange --}}
                    {{-- <li class="nav-item dropdown mx-3 mb-0  mt-4">
                        <span id="lang">
                            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                                EN
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-lang"
                                        onclick="toggleLang()">
                                    <label class="form-check-label"></label>
                                </div>
                                ID
                            </div>
                        </span>
                    </li> --}}
                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                <p class="mb-0 text-sm text-success">Online</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ Auth::user()->profile_photo_url }}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ strtok(Auth::user()->name, ' ') }}!</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                    class="icon-mid bi bi-person me-2"></i> My
                                Profile</a></li>
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <li>
                                <a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                    {{ __('API Tokens') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit(); localStorage.clear();">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
{{-- Clock --}}
<script>
    new DateAndTime();
    setInterval("DateAndTime()", 1000);

    function DateAndTime() {
        var dt = new Date();
        var Hours = dt.getHours();
        var Min = dt.getMinutes();
        var Sec = dt.getSeconds();
        var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
            "November", "Desember"
        ];

        // ingatkan ketika jam  12 untuk input data harian
        if (Hours === 12 && Min === 0 && Sec === 0) {
            const message = "Dont forget to submit daily input before 5 PM today."
            sendNotificationAlertToFarmer(message);
        } else if (Hours === 10 && Min === 47 && Sec === 10) {
            const message = "Your daily cage data input is pending. Kindly ensure it's completed before 5 PM today."
            sendNotificationAlertToFarmer(message);
        }

        if (Min < 10) {
            Min === "0" + Min;
        }
        if (Sec < 10) {
            Sec === "0" + Sec;
        }

        var suffix = " AM";
        if (Hours >= 12) {
            suffix = " PM";
            Hours = Hours - 12;
        }
        if (Hours === 0) {
            Hours = 12;
        }
        document.getElementById("dateTime").innerHTML =
            days[dt.getDay()] +
            ", " +
            dt.getDate() +
            " " +
            months[dt.getMonth()] +
            " " +
            dt.getFullYear() + "," + Hours + ":" + Min + ":" + Sec + ":" + suffix;

    }

    function sendNotificationAlertToFarmer(message) {
        let data = {
            message: message
        }
        $.ajax({
            type: "POST",
            url: `/data-kandang/send-peternak-notification`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                console.log(response);
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }
</script>
