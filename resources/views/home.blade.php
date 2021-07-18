@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @if (session('status') == 'two-factor-authentication-enabled')
            <div class="col-md-12 alert alert-success mt-5" role="alert">
                Two factor authentication has been enabled.
            </div>
        @endif


        @if(auth()->user()->two_factor_secret)
            <form method="POST" action="/user/two-factor-authentication">
                @csrf
                <input type="hidden" name="_method" value="delete" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! auth()->user()->twoFactorQrCodeSvg()  !!}
                        </div>

                        <div class="col-md-12">
                            <h3>Recovery Codes:</h3>

                            <ul>
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                                    <li>{{ $code }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <button class="btn btn-primary mt-3">DISABLE</button>
                    </div>
                </div>
            </form>
        @else
            <form method="POST" action="/user/two-factor-authentication">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <button class="btn btn-primary">Enable</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
