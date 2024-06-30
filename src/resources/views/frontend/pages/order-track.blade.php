@extends('frontend.layouts.master')

@section('title','fatoho || Order track')

@section('main-content')
    
<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{route('home')}}">Trang chủ<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="javascript:void(0);">Kiểm tra đơn hàng</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->
	
<section class="tracking_box_area section_gap py-5">
    <div class="container">
        <div class="tracking_box_inner">
            <p>Hãy nhập mã đơn hàng và click vào nút "Kiểm tra đơn hàng" bên dưới để xem chi tiết tiến độ giao hàng. <br>
			<i>Nếu bạn không rõ về mã đơn hàng hãy kiểm tra e-mail tại thời điểm đặt hàng hoặc liên hệ với trung tâm chăm sóc khách hàng theo thông tin tại <a href="https://fatoho.com/blog-detail/ho-tro-247"><u>Hỗ trợ 24/7</u></a> để được hướng dẫn.</i></p>
            <form class="row tracking_form my-4" action="{{route('product.track.order')}}" method="post" novalidate="novalidate">
				@csrf
                <div class="col-md-8 form-group">
					@if (!isset($order_number))
                    <input type="text" class="form-control p-2"  name="order_number" placeholder="Nhập mã đơn hàng của bạn">
					@else
                    <input type="text" class="form-control p-2"  name="order_number" placeholder="Nhập mã đơn hàng của bạn" value="{{$order_number}}">
					@endif
                </div>
                <div class="col-md-8 form-group">
                    <button type="submit" value="submit" class="btn submit_btn">Kiểm tra đơn hàng</button>
                </div>
            </form>
        </div>
		
		@if (!empty($tracks))
		<div class="tracking_box_inner">
			<div id="tracking-pre"></div>
			<div id="tracking">
				<div class="tracking-list">
					@foreach($tracks as $track)
					<div class="tracking-item">
						<div class="tracking-icon status-intransit">
							<svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
							<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
							</svg>
						</div>
						<div class="tracking-date"><img src="/storage/photos/3/Icons/delivery.svg" class="img-responsive" alt="order-placed" /></div>
						<div class="tracking-content">{{$track->getOrderStatusName()}}<span>{{($track->updated_at != null) ? $track->updated_at->format('d/m/Y h:i:s A') : ''}}</span></div>
					</div>
					@endforeach
				
					@if (isset($pending_tracks))
					@foreach($pending_tracks as $pendingtrack)  
					<div class="tracking-item-pending">
						<div class="tracking-icon status-intransit">
							<svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
							<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
							</svg>
						</div>
					<div class="tracking-date"><img src="/storage/photos/3/Icons/delivery.svg" class="img-responsive" alt="order-placed" /></div>
					<div class="tracking-content">{{$pendingtrack->getOrderStatusName()}}</div>
					</div>
					@endforeach
					@endif
			  
			</div>
		  </div>
		</div>
		@endif {{-- @if (!empty($tracks)) --}}
		
    </div>
</section>



@endsection


@push('styles')
<style>
.cd__main{
    background: linear-gradient(to right, #8e9eab, #eef2f3) !important;
}
#tracking{
   background: #fff
}
.tracking-detail {
  padding: 3rem 0;
}
#tracking {
  margin-bottom: 1rem;
}
[class*="tracking-status-"] p {
  margin: 0;
  font-size: 1.1rem;
  color: #fff;
  text-transform: uppercase;
  text-align: center;
}
[class*="tracking-status-"] {
  padding: 1.6rem 0;
}
.tracking-list {
  border: 1px solid #e5e5e5;
}
.tracking-item {
  border-left: 4px solid #00ba0d;
  position: relative;
  padding: 2rem 1.5rem 0.5rem 2.5rem;
  font-size: 0.9rem;
  margin-left: 3rem;
  min-height: 5rem;
}
.tracking-item:last-child {
  padding-bottom: 4rem;
}
.tracking-item .tracking-date {
  margin-bottom: 0.5rem;
}
.tracking-item .tracking-date span {
  color: #888;
  font-size: 85%;
  padding-left: 0.4rem;
}
.tracking-item .tracking-content {
  padding: 0.5rem 0.8rem;
  background-color: #f4f4f4;
  border-radius: 0.5rem;
}
.tracking-item .tracking-content span {
  display: block;
  color: #767676;
  font-size: 13px;
}
.tracking-item .tracking-icon {
  position: absolute;
  left: -0.7rem;
  width: 1.1rem;
  height: 1.1rem;
  text-align: center;
  border-radius: 50%;
  font-size: 1.1rem;
  background-color: #fff;
  color: #fff;
}

.tracking-item-pending {
  border-left: 4px solid #d6d6d6;
  position: relative;
  padding: 2rem 1.5rem 0.5rem 2.5rem;
  font-size: 0.9rem;
  margin-left: 3rem;
  min-height: 5rem;
}
.tracking-item-pending:last-child {
  padding-bottom: 4rem;
}
.tracking-item-pending .tracking-date {
  margin-bottom: 0.5rem;
}
.tracking-item-pending .tracking-date span {
  color: #888;
  font-size: 85%;
  padding-left: 0.4rem;
}
.tracking-item-pending .tracking-content {
  padding: 0.5rem 0.8rem;
  background-color: #f4f4f4;
  border-radius: 0.5rem;
}
.tracking-item-pending .tracking-content span {
  display: block;
  color: #767676;
  font-size: 13px;
}
.tracking-item-pending .tracking-icon {
  line-height: 2.6rem;
  position: absolute;
  left: -0.7rem;
  width: 1.1rem;
  height: 1.1rem;
  text-align: center;
  border-radius: 50%;
  font-size: 1.1rem;
  color: #d6d6d6;
}
.tracking-item-pending .tracking-content {
  font-weight: 600;
  font-size: 17px;
}

.tracking-item .tracking-icon.status-current {
  width: 1.9rem;
  height: 1.9rem;
  left: -1.1rem;
}
.tracking-item .tracking-icon.status-intransit {
  color: #00ba0d;
  font-size: 0.6rem;
}
.tracking-item .tracking-icon.status-current {
  color: #00ba0d;
  font-size: 0.6rem;
}
@media (min-width: 992px) {
  .tracking-item {
    margin-left: 10rem;
  }
  .tracking-item .tracking-date {
    position: absolute;
    left: -10rem;
    width: 7.5rem;
    text-align: right;
  }
  .tracking-item .tracking-date span {
    display: block;
  }
  .tracking-item .tracking-content {
    padding: 0;
    background-color: transparent;
  }

  .tracking-item-pending {
    margin-left: 10rem;
  }
  .tracking-item-pending .tracking-date {
    position: absolute;
    left: -10rem;
    width: 7.5rem;
    text-align: right;
  }
  .tracking-item-pending .tracking-date span {
    display: block;
  }
  .tracking-item-pending .tracking-content {
    padding: 0;
    background-color: transparent;
  }
}

.tracking-item .tracking-content {
  font-weight: 600;
  font-size: 17px;
}

.blinker {
  border: 7px solid #e9f8ea;
  animation: blink 1s;
  animation-iteration-count: infinite;
}
@keyframes blink { 50% { border-color:#fff ; }  }

</style>
@endpush