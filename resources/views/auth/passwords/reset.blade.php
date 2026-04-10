<x-front-layout>
    <section class="container my-4">
        <x-ui.page-header
            class="mb-4"
            title="Reset password"
            subtitle="Please enter the new password."
        />
    </section>
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="px-4 py-4 rounded-3 border border-light bg-white shadow">
                    <form action="{{ route('auth.password.reset') }}" method="post" data-js="form">
                        <div class="mb-3">
                            <label for="item-email">Email</label>
                            <input id="item-email" type="email" name="email" placeholder="john@example.com" value="{{ $email }}" required class="form-control" />
                            <input type="hidden" name="token" value="{{ $token }}" />
                            <input type="hidden" name="ajax" value="1" />
                        </div>
                        <div class="mb-3">
                            <label for="item-password">Password</label>
                            <input id="item-password" type="password" name="password" required autofocus autocomplete="new-password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="item-password_confirmation">Confirm Password</label>
                            <input id="item-password_confirmation" type="password" name="password_confirmation" required class="form-control" />
                        </div>
                        <div data-js="form-msg" class="alert alert-primary d-none mb-2 px-2 py-1 small fw-medium"></div>
                        <div>
                            <div data-js="form-msg" class="alert alert-primary d-none mb-2 px-2 py-1 small fw-medium"></div>
                            <button data-js="form-btn" type="submit" class="btn btn-dark w-100 fw-medium">
                                <span data-js="loader" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                                <span role="status" class="d-inline-block mx-2">Reset Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>