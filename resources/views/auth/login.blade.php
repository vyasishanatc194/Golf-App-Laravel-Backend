@extends('la.layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="right-column sisu">
                <div class="row mx-0">
                    <div class="col-md-7 order-md-2 signin-right-column px-5 bg-dark">
                        <a class="signin-logo d-sm-block display-4" href="#">
                            <b>{{ LAConfigs::getByKey('sitename_part1') }} </b>{{ LAConfigs::getByKey('sitename_part2') }}
                        </a>
                        <h1 class="display-4">Sign In To get Started</h1>
                        <p class="lead mb-5">
                            Big data latte SpaceTeam unicorn cortado hacker physical computing paradigm.
                        </p>
                    </div>
                    <div class="col-md-5 order-md-1 signin-left-column bg-white px-5">
                        <a class="signin-logo d-sm-none d-md-block display-4 text-center" href="#">
                            <b>{{ LAConfigs::getByKey('sitename_part1') }} </b>{{ LAConfigs::getByKey('sitename_part2') }}
                        </a>
        

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ url('/login') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group has-feedback">
								<label for="exampleInputEmail1">Email</label>
								<input type="email" class="form-control"  name="email" aria-describedby="emailHelp" placeholder="Enter email">
							</div>
							<div class="form-group has-feedback">
								<label for="exampleInputPassword1">Password</label>
								<input type="password" class="form-control" name="password" placeholder="Password">
							</div>
							<div class="custom-control custom-checkbox mb-3">
								<input type="checkbox" class="custom-control-input" name="remember" id="keep-signed-in">
								<label class="custom-control-label"   for="keep-signed-in">Remember Me</label>
							</div>
							<button type="submit" class="btn btn-primary btn-block">
								<i class="batch-icon batch-icon-key"></i>
								Sign In
							</button>
							<hr>
							<p class="text-center">
                                I forgot my password <a href="{{ url('/password/reset') }}">Click here</a>
								<!-- Don't Have An Account? <a href="{{ url('/register') }}">Sign Up here</a> -->
							</p>
                        </form>
                        @include('auth.partials.social_login')
                    </div>
                </div>    
            </div>
        </div>
    </div>

    @include('la.layouts.partials.scripts_auth')

    <script>

    </script>
</body>

@endsection
