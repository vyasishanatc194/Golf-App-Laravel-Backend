@extends('la.layouts.auth')

@section('htmlheader_title')
    Password reset
@endsection

@section('content')
<body>
    <div class="container-fluid">
		<div class="row">
			<div class="right-column sisu">
				<div class="row mx-0">
					<div class="col-md-7 order-md-2 signin-right-column px-5 bg-dark">
						<a class="signin-logo d-sm-block display-4" href="{{ url('/home') }}">
                        <b>{{ LAConfigs::getByKey('sitename_part1') }} </b>{{ LAConfigs::getByKey('sitename_part2') }}
						</a>
						<h1 class="display-4">Password Reset Request</h1>
						<p class="lead mb-5">
							Responsive driven intuitive actionable insight hacker driven personas SpaceTeam.
						</p>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

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
					<div class="col-md-5 order-md-1 signin-left-column bg-white px-5">
						<br><br>
						<a class="signin-logo d-sm-none d-md-block text-center display-4" href="{{ url('/home') }}">
                        <b>{{ LAConfigs::getByKey('sitename_part1') }} </b>{{ LAConfigs::getByKey('sitename_part2') }}
						</a>
						<form action="{{ url('/password/email') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p>We'll send the password reset link to your email.</p>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter email">
							</div>
							<button type="submit" class="btn btn-primary btn-block">
								<i class="batch-icon batch-icon-mail"></i>
								Send Password Reset Link
							</button>
							<hr>
							<p class="text-center">
								Did You Remember Your Password? <a href="{{ url('/login') }}">Sign In</a>
							</p>
							<!-- <p class="text-center">
								Don't Have An Account? <a href="{{ url('/register') }}">Sign Up here</a>
							</p> -->
						</form>
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
