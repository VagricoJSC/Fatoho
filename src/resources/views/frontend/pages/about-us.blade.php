@extends('frontend.layouts.master')

@section('title','fatoho || Giới Thiệu')

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="/">Trang chủ<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="/about-us">Về chúng tôi</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<!-- About Us -->
<section class="about-us">
	<div class="container">
		<div class="row" style="text-align: justify;">
			@php
				$settings=DB::table('settings')->first();
			@endphp
			{!! $settings->description !!}
			
		</div>
	</div>
</section>
<!-- End About Us -->


<!-- Start Shop Services Area -->
@include('frontend.layouts._serviceTitle')
<!-- End Shop Services Area -->

@endsection