@extends('la.layouts.auth')

@section('htmlheader_title')
    Register
@endsection

@section('content')
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="right-column sisu">
				<div class="row mx-0">
					<div class="col-md-7 order-md-2 signin-right-column px-5 bg-dark">
						<a class="signin-logo d-sm-block display-4" href="{{ url('/home') }}" >
                            <b>{{ LAConfigs::getByKey('sitename_part1') }} </b>{{ LAConfigs::getByKey('sitename_part2') }}
						</a>
						<h1 class="display-4">Sign Up For An Account Today</h1>
						<p class="lead mb-5">
							Big data latte SpaceTeam unicorn cortado hacker physical computing paradigm.
						</p>
					</div>
					<div class="col-md-5 order-md-1 signin-left-column bg-white px-5">
						<a class="signin-logo d-sm-none d-md-block text-center display-4" href="{{ url('/home') }}">
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
                        <form action="{{ url('/register') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group has-feedback">
                                <label for="name">Full name</label>
                                <input type="text" class="form-control" placeholder="Full name" name="name" value="{{ old('name') }}"/>
                            </div>
                            <div class="form-group has-feedback">
								<label for="email">Email address</label>
								<input type="email" class="form-control" placeholder="Enter email" name="email" value="{{ old('email') }}">
							</div>
							<div class="form-group has-feedback">
								<label for="password_confirmation">Password</label>
								<input type="password" class="form-control" placeholder="Password" name="password_confirmation" value="{{ old('password_confirmation') }}">
							</div>
							<div class="form-group has-feedback">
								<label for="exampleInputPassword2">Confirm Password</label>
								<input type="password" class="form-control"  placeholder="Password" name="name" value="{{ old('name') }}">
							</div>
							<div class="custom-control custom-checkbox mb-3">
								<input type="checkbox" class="custom-control-input" >
								<label class="custom-control-label" for="newsletter-signup">I agree to the terms</label>
							</div>
							<button type="submit" class="btn btn-primary btn-block">
								<i class="batch-icon batch-icon-quill"></i>
								Sign Up
							</button>
							<hr>
							<p class="text-center">
								Already Have An Account? <a href="{{ url('/login') }}" >Sign In here</a>
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
