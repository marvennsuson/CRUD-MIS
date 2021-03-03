@extends('layouts.users')

@section('header')
Verify Email
@endsection
@section('content')

<div class="row">
    <div class="card">
        <div class="card-header card-header-text card-header-primary">
          <div class="card-text">
            <h4 class="card-title">Verify Email First</h4>
          </div>
        </div>
        <div class="card-body">
            <h5>Please verify your email first to enable key functions to your account.</h5>
            <br>
        <form action="{{route('users.verify')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Resend email</button>
                @if (Session::has('status'))
                    <p class="text-success">{{Session::get('status')}}</p>
                @endif
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection