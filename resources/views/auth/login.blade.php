@extends('layouts.auth')
@section('content')
    <div class="container">
        <div class="row">
            <meta name="csrf-token"  content="{{ csrf_token() }}" />
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form method="POST" id="login_form" action="{{ route('login') }}" novalidate data-url="{{ route('login') }}" >
            @csrf
                <div class="card card-login">
                <div class="card-header card-header-rose text-center">
                    <h4 class="card-title">Login</h4>
                    <div class="social-line">
                        <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                          <i class="fa fa-facebook-square"></i>
                        </a>
                        <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                          <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                          <i class="fa fa-google-plus"></i>
                        </a>
                      </div>
                </div>
                <div class="card-body ">
                   
                    
                    @error('message')
                        <span id="password-error" class="password text-center" style="margin-left:54px;font-size: .8rem;color: #f44336;" for="email">{{ $message }}</span>
                    @enderror
                    <span class="bmd-form-group @error('email') {{'is-filled has-danger is-focused'}} @enderror ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">email</i>
                        </span>
                        </div>
                        <input email="true" name="email" id="email" type="email" class="form-control" value="{{ old('email') }}" placeholder="Email..." required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <span id="email-error" class="error" style="margin-left:54px;font-size: .8rem;color: #f44336;" for="email">{{ $message }}</span>
                    @enderror
                   
                    
                    
                    </span>
                    <span class="bmd-form-group @error('password') {{'is-filled has-danger is-focused'}} @enderror">
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">lock_outline</i>
                        </span>
                        </div>
                        <input min="6" type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password..." required autocomplete="current-password">
                      
                    </div>
                    @error('password')
                        <span id="password-error" class="password" style="margin-left:54px;font-size: .8rem;color: #f44336;" for="email">{{ $message }}</span>
                    @enderror
                    </span>
                </div>
                <div class="card-footer justify-content-center">
                    <div>
                        <button type="submit" class="btn btn-link text-rose m-0">Login</button>
                        <br><br>
                        {{-- <a href="{{route('register')}}" class="d-block text-center p-0 text-info">Create Account</a> --}}
                        <a href="{{route('forgot-password')}}" class="d-block text-center pb-5"><small>Forgot Password?</small></a>
                    </div>
                </div>
                
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection

