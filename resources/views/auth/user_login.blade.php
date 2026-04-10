<x-front-layout>
    <section class="container my-4">
        <x-ui.page-header
            class="mb-4"
            title="{{ $type }} Login"
        />
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <div class="px-4 py-4 rounded-3 border border-light bg-white shadow">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="/login?v=1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="password"/>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="item-remember" class="form-check-input" />
                                <label for="item-remember" class="form-check-label user-select-none">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="mb-2 btn btn-gradient-dark w-100 fw-medium rounded-pill">
                            <span>Login</span>
                        </button>
                        <a href="{{ $joinLink }}" class="mb-2 btn btn-gradient w-100 fw-medium rounded-pill">
                            <span>Join</span>
                        </a>
                        <p class="mb-0 text-center">
                            <a href="{{ route('auth.password.reset') }}" class="link-dark">
                                Forgot password?
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-front-layout>