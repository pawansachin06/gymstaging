<x-front-layout>
    <section class="container my-4">
        <div class="px-3 py-4 text-center rounded-3 border border-light bg-white shadow">
            <h1 class="h4 fw-bold">Account Info</h1>
            <p class="mb-0 fw-medium">
                View your GymSelect discount code & update your account info.
            </p>
        </div>
    </section>
    <section class="container my-4">
        <div class="px-3 py-4 text-center rounded-3 bg-dark text-white">
            <p class="mb-3 fw-semibold">
                Your GymSelect 20% discount code: <span class="text-info fw-bold">GSM20</span>
            </p>
            <a href="{{ url('products') }}" class="btn btn-info fw-medium">
                <span>Shop Business</span>
            </a>
        </div>
    </section>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <form method="POST" action="{{ route('user.updateprofile') }}" id="account_form" enctype="multipart/form-data" onsubmit="return validateForm();">
                    <input type="hidden" name="type" value="{{ $type }}" />
                    @csrf
                    <div class="form-group mb-3">
                        <label>Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name', $user->name ?? '') }}" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', $user->email ?? '') }}" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Change password</label>
                        <input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="New password" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="off" class="form-control" placeholder="Confirm New Password" />
                        <div class="field_error small fw-medium text-danger"></div>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" name="email_2fa" type="checkbox" role="switch" id="email-2fa-switch"
                            @checked($user->email_2fa_enabled_at) />
                        <label class="form-check-label user-select-none" for="email-2fa-switch">Enable Two Factor Authentication</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-dark w-100 fw-medium">
                            <span>Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-front-layout>