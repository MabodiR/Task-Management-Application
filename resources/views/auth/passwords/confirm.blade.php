@extends('layouts.auth')

@section('content')
<div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="containers">
                            <div class="row justify-content-centers">
                                <div class="col-md-8s">
                                    <div class="card">
                                        <div class="card-header">{{ __('Confirm Password') }}</div>

                                        <div class="card-body">
                                            {{ __('Please confirm your password before continuing.') }}

                                            <form method="POST" action="{{ route('password.confirm') }}">
                                                @csrf

                                                <div class="row mb-3">
                                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-md-8 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Confirm Password') }}
                                                        </button>

                                                        @if (Route::has('password.request'))
                                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                                {{ __('Forgot Your Password?') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                 </div>
        </div>
    </div>
</div>
@endsection
