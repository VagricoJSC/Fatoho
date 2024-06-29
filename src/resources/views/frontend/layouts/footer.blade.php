
	<!-- Start Footer Area -->
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12" style="text-align: justify;">
						<!-- Single Widget -->
						@php
							$settings=DB::table('settings')->first();
						@endphp
						{!! $settings->footer_description !!}
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Thông Tin</h4>
							<ul>
								<li><a href="{{route('about-us')}}">Về chúng tôi</a></li>
								<li><a href="/blog-detail/dieu-khoan-va-dieu-kien">Điều khoản và điều kiện</a></li>
								<li><a href="{{route('contact')}}">Liên hệ</a></li>
								<li><a href="/blog-detail/ho-tro-247">Hỗ trợ 24/7</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Dịch vụ khách hàng</h4>
							<ul>
								<li><a href="/blog-detail/chinh-sach-bao-mat">Chính sách bảo mật</a></li>
								<li><a href="/blog-detail/payment-type">Chính sách thanh toán</a></li>
								<li><a href="/blog-detail/tracking">Chính sách vận chuyển và kiểm tra hàng</a></li>
								<li><a href="/blog-detail/tra-hang">Chính bảo hành và đổi trả</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Liên Hệ</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>{{$settings->corp_name}}</li>
									<li>{{$settings->address}}</li>
									<li>{{$settings->email}}</li>
									<li>{{$settings->phone}}</li>
									<li>&nbsp;</li>
									<li>Giấy chứng nhận đăng ký doanh nghiệp số {{$settings->corp_num}} do {{$settings->corp_reg_place}} 
									cấp lần đầu tiên vào ngày {{$settings->corp_reg_date != null ? DateTime::createFromFormat('Y-m-d', $settings->corp_reg_date)->format('d/m/Y') : ''}}</li>
								</ul>
							</div>
							<div class="sharethis-inline-follow-buttons st-inline-follow-buttons st-#{action_pos}  st-animated" 
							id="st-1">
							<a href="{{$settings->facebook}}" target="_blank"  class="st-btn st-last" data-network="twitter"  >
							  <i class="fa fa-facebook"></i>
							</a>
							<a href="{{$settings->youtube}}" target="_blank"  class="st-btn st-last" data-network="twitter" >
							  <i class="fa fa-youtube-play"></i>
							</a>
							<a href="{{$settings->instagram}}" target="_blank" class="st-btn st-last" data-network="twitter" >
							  <i class="fa fa-instagram"></i>
							</a>
							
							</div>
							<style>
							.sharethis-inline-follow-buttons{
								display: flex;
								justify-content: flex-start;
								align-items: center;
								gap: 10px;
								margin-top : 15px
							}
							.sharethis-inline-follow-buttons .st-btn {
								width: 30px;
								height: 30px;
								border: 1px solid #ccc;
								border-radius: 5px;
								display: flex;
								justify-content: center;
								align-items: center;
							padding: 5px;}
							.sharethis-inline-follow-buttons .st-btn i{
								font-size: 18px;
								color: #fff;
								line-height: 14px;
							}
							</style>
							<!-- End Single Widget -->
							
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © {{date('Y')}} <a href="#" target="_blank">Vagrico JSC</a>  -  All Rights Reserved.</p>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
 
	<!-- Jquery -->
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<!-- <script src="{{asset('frontend/js/colors.js')}}"></script> -->
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/js/easing.js')}}"></script>

	<!-- Active JS -->
	<script src="{{asset('frontend/js/active.js')}}"></script>

	
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>