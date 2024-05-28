@extends('frontend.layouts.master')
@section('title','FATOHO || Liên Hệ')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Trang chủ<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Liên hệ</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									@php
										$settings=DB::table('settings')->first();
									@endphp
									<h4>Thông tin</h4>
									<h3>Gửi tin nhắn</h3>
									<!--  @auth @else<span style="font-size:12px;" class="text-danger">[Bạn cần đăng nhập trước]</span>@endauth -->
								</div>
								<form class="form-contact form contact_form" method="post" action="{{route('contact.store')}}" id="contactForm" novalidate="novalidate">
									@csrf
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Họ và tên<span>*</span></label>
												<input name="name" id="name" type="text" value="{{Auth()->user() ? Auth()->user()->name : ''}}" placeholder="Ghi đầy đủ họ tên">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Tiêu đề<span>*</span></label>
												<input name="subject" type="text" id="subject" placeholder="Tiêu đề yêu cầu">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Email<span>*</span></label>
												<input name="email" type="email" id="email" value="{{Auth()->user() ? Auth()->user()->email : ''}}"  placeholder="example@gmail.com">
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Số điện thoại<span>*</span></label>
												<input id="phone" name="phone" type="number"  placeholder="+84 977xxx999">
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>Nội dung<span>*</span></label>
												<textarea name="message" id="message" cols="30" rows="9" placeholder="Nhập nội dung bạn muốn gửi đến chúng tôi"></textarea>
											</div>
										</div>
										<!-- <div class="col-12">
											<div class="form-group">
												<div class="g-recaptcha" data-sitekey="6LfdOtwpAAAAALqHCXkjftjR_KvLr8ATWTPDa9JX"></div>
											</div>
										</div>-->
										
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">Gửi</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">Liên hệ ngay (24/7):</h4>
									<ul>
										<li>{{@$settings->phone}}</li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:{{@$settings->email}}">{{@$settings->email}}</a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-location-arrow"></i>
									<h4 class="title">Địa chỉ:</h4>
									<ul>
										<li>{{@$settings->address}}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
	<!-- Map Section -->
	<div class="map-section">
		<div id="myMap">
			<iframe src="{{@$settings->map_location}}" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
	</div>
	<!--/ End Map Section -->
	
	<!--================Contact Success  =================-->
	
	<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-success">Cảm ơn!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-success">Tin nhắn của bạn đã được gửi đi...</p>
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Modals error -->
	<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-warning">Xin lỗi!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-warning">Có lỗi xảy ra khi bạn gửi tin nhắn. Vui lòng gọi vào số hotline (24/7)</p>
			</div>
		  </div>
		</div>
	</div>
@endsection

@push('styles')
<style>
	.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
	}
</style>
@endpush
@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush