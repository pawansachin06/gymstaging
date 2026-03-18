<x-front-layout>
    <section class="container my-4">
        <div class="mb-4 px-3 py-4 text-center rounded-3 border border-light bg-white shadow">
            <h1 class="h4 fw-bold">Verify Login Attempt</h1>
            <p class="mb-0 fw-medium">
                Please enter the OTP sent to your email.
            </p>
        </div>
    </section>

    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="px-4 py-4 rounded-3 border border-light bg-white shadow">
                    <form method="post" action="{{ route('login-otp-email-verify') }}" data-js="form">
                        <div class="mb-3">
                            <input type="text" name="otp" autofocus placeholder="******" minlength="6" maxlength="6" required class="form-control form-control-lg text-center" />
                        </div>
                        <div>
                            <div data-js="form-msg" class="alert alert-primary d-none mb-2 px-2 py-1 small fw-medium"></div>
                            <button data-js="form-btn" type="submit" class="mb-3 btn btn-dark w-100 fw-medium">
                                <span data-js="loader" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                                <span role="status" class="d-inline-block mx-2">Verify</span>
                            </button>
                        </div>
                    </form>
                    <form method="post" action="{{ route('login-otp-email-resend') }}" data-js="form">
                        <button data-js="form-btn" type="submit" class="btn btn-outline-dark w-100 fw-medium">
                            <span data-js="loader" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                            <span role="status" class="d-inline-block mx-2">Resend OTP</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-front-layout>