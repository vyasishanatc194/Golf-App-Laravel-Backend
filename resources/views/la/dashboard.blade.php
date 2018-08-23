@extends('la.layouts.app')

@section('htmlheader_title') Dashboard @endsection
@section('contentheader_title') Dashboard @endsection
@section('contentheader_description') Organisation Overview @endsection

@section('main-content')
<div class="row">
	<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-primary bg-gradient text-center">
								<div class="card-body p-4">
									<!-- Accepts .invisible: Makes the items. Use this only when you want to have an animation called on it later -->
									<div class="tile-left">
										<i class="batch-icon batch-icon-user-alt batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">1,359</div>
										<div class="tile-description">Customers Online</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-secondary bg-gradient text-center">
								<div class="card-body p-4">
									<div class="tile-left">
										<i class="batch-icon batch-icon-tag-alt-2 batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">$7,349.90</div>
										<div class="tile-description">Today's Sales</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-primary bg-gradient text-center">
								<div class="card-body p-4">
									<div class="tile-left">
										<i class="batch-icon batch-icon-list batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">26</div>
										<div class="tile-description">Open Tickets</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-3 mb-5">
							<div class="card card-tile card-xs bg-secondary bg-gradient text-center">
								<div class="card-body p-4">
									<div class="tile-left">
										<i class="batch-icon batch-icon-star batch-icon-xxl"></i>
									</div>
									<div class="tile-right">
										<div class="tile-number">476</div>
										<div class="tile-description">New Orders</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-lg-6 col-xl-8 mb-5">
							<div class="card">
								<div class="card-header">
									Sales Overview
									<div class="header-btn-block">
										<span class="data-range dropdown">
											<a href="#" class="btn btn-primary dropdown-toggle" id="navbar-dropdown-sales-overview-header-button" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
												<i class="batch-icon batch-icon-calendar"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-dropdown-sales-overview-header-button">
												<a class="dropdown-item" href="today">Today</a>
												<a class="dropdown-item" href="week">This Week</a>
												<a class="dropdown-item" href="month">This Month</a>
												<a class="dropdown-item active" href="year">This Year</a>
											</div>
										</span>
									</div>
								</div>
								<div class="card-body">
									<div class="card-chart" data-chart-color-1="#07a7e3" data-chart-color-2="#32dac3" data-chart-legend-1="Sales ($)" data-chart-legend-2="Orders" data-chart-height="281">
										<canvas id="sales-overview"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6 col-xl-4 mb-5">
							<div class="card card-md">
								<div class="card-header">
									Traffic Sources
									<div class="header-btn-block">
										<span class="data-range dropdown">
											<a href="#" class="btn btn-primary dropdown-toggle" id="navbar-dropdown-traffic-sources-header-button" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
												<i class="batch-icon batch-icon-calendar"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right"  aria-labelledby="navbar-dropdown-traffic-sources-header-button">
												<a class="dropdown-item" href="today">Today</a>
												<a class="dropdown-item" href="week">This Week</a>
												<a class="dropdown-item" href="month">This Month</a>
												<a class="dropdown-item active" href="year">This Year</a>
											</div>
										</span>
									</div>
								</div>
								<div class="card-body text-center">
									<p class="text-left">Your top 5 traffic sources</p>
									<div class="card-chart" data-chart-color-1="#07a7e3" data-chart-color-2="#32dac3" data-chart-color-3="#4f5b60" data-chart-color-4="#FCCF31" data-chart-color-5="#f43a59">
										<canvas id="traffic-source"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-lg-4 mb-5">
							<div class="card card-sm bg-info">
								<div class="card-body">
									<div class="mb-4 clearfix">
										<div class="float-left text-warning text-left">
											<i class="fa fa-twitter batch-icon-xxl"></i>
										</div>
										<div class="float-right text-right">
											<h6 class="m-0">Twitter Followers</h6>
										</div>
									</div>
									<div class="text-right clearfix">
										<div class="display-4">65,452</div>
										<div class="m-0">+72 Today</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-4 mb-5">
							<div class="card card-sm">
								<div class="card-body">
									<div class="mb-4 clearfix">
										<div class="float-left text-warning text-left">
											<i class="batch-icon batch-icon-star batch-icon-xxl"></i>
										</div>
										<div class="float-right text-right">
											<h6 class="m-0">Reviews</h6>
										</div>
									</div>
									<div class="text-right clearfix">
										<div class="display-4">7,842</div>
										<div class="m-0">
											<a href="#">Read More</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-lg-4 mb-5">
							<div class="card card-sm bg-danger">
								<div class="card-body">
									<div class="mb-4 clearfix">
										<div class="float-left text-left">
											<i class="batch-icon batch-icon-reply batch-icon-xxl"></i>
										</div>
										<div class="float-right text-right">
											<h6 class="m-0">Products Returned</h6>
										</div>
									</div>
									<div class="text-right clearfix">
										<div class="display-4">231</div>
										<div class="m-0">-4% Today</div>
									</div>
								</div>
							</div>
						</div>
					</div>

@endsection
