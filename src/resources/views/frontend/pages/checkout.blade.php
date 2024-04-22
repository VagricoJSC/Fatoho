@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <form class="form" method="POST" action="{{route('cart.order')}}">
            @csrf
            <div class="row">

                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h2>Địa chỉ giao hàng trước đây :</h2>
                        <div class="address-list">
                            @foreach($orders as $k => $i)
                            <div class="item-address">
                                <div class="lable"><span>Họ & Tên : </span>{{$i->first_name}} {{$i->last_name}}</div>
                                <div class="lable"><span>Email : </span>{{$i->email}}</div>
                                <div class="lable"><span>Số Điện Thoại : </span>{{$i->phone}}</div>
                                <div class="lable"><span>Địa Chỉ : </span>{{$i->address1}}</div>
                                <input type="hidden" class="h_first_name" value="{{$i->first_name}}">
                                <input type="hidden" class="h_last_name" value="{{$i->last_name}}">
                                <input type="hidden" class="h_email" value="{{$i->email}}">
                                <input type="hidden" class="h_phone" value="{{$i->phone}}">
                                <input type="hidden" class="h_address1" value="{{$i->address1}}">
                                <input type="hidden" class="h_country" value="{{$i->country}}">
                                <input type="hidden" class="h_address2" value="{{$i->address2}}">
                                <input type="hidden" class="h_post_code" value="{{$i->post_code}}">
                            </div>
                            @endforeach

                        </div>
                        <div class="row mb-5">
                            <div class="pagenigation-custome">
                                {{$orders->appends($_GET)->links()}}
                            </div>
                        </div>
                        <h2>Thông tin giao hàng</h2>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Họ: <span>*</span></label>
                                    <input type="text" name="first_name" placeholder="" required value="{{old('first_name')}}" value="{{old('first_name')}}">
                                    @error('first_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tên: <span>*</span></label>
                                    <input type="text" name="last_name" placeholder="" required value="{{old('lat_name')}}">
                                    @error('last_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Email <span>*</span></label>
                                    <input type="email" name="email" placeholder="" required value="{{old('email')}}">
                                    @error('email')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Số Điện Thoại <span>*</span></label>
                                    <input type="number" name="phone" placeholder="" required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Quốc Gia<span>*</span></label>
                                    <select name="country" id="country">
                                        @foreach($countries as $code => $name)
                                        <option value="{{ $code }}" @if($code == 'VN') selected @endif>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Địa chỉ 1<span>*</span></label>
                                    <input type="text" name="address1" placeholder="" required value="{{old('address1')}}">
                                    @error('address1')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Địa chỉ 2</label>
                                    <input type="text" name="address2" placeholder="" value="{{old('address2')}}">
                                    @error('address2')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Code Vùng</label>
                                    <input type="text" name="post_code" placeholder="" value="{{old('post_code')}}">
                                    @error('post_code')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <!--/ End Form -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>Tổng Đơn Hàng</h2>
                            <div class="content">
                                <ul>
                                    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Tổng phụ của giỏ hàng<span>${{number_format(Helper::totalCartPrice(),2)}}</span></li>
                                    <li class="shipping">
                                        <label>Phí ship<span class="required">*</span></label>
                                        @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                        <select name="shipping" class="nice-select" required>
                                            <!-- <option value="">Select your address</option> -->
                                            @foreach(Helper::shipping() as $shipping)
                                            <option value="{{$shipping->id}}" class="shippingOption" data-price="{{$shipping->price}}">{{$shipping->type}}: ${{$shipping->price}}</option>
                                            @endforeach
                                        </select>
                                        @error('shipping')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                        @else
                                        <span>Miễn phí</span>
                                        @endif
                                    </li>

                                    @if(session('coupon'))
                                    <li class="coupon_price" data-price="{{session('coupon')['value']}}">You Save<span>${{number_format(session('coupon')['value'],2)}}</span></li>
                                    @endif
                                    @php
                                    $total_amount=Helper::totalCartPrice();
                                    if(session('coupon')){
                                    $total_amount=$total_amount-session('coupon')['value'];
                                    }
                                    @endphp
                                    @if(session('coupon'))
                                    <li class="last" id="order_total_price">Tổng<span>${{number_format($total_amount,2)}}</span></li>
                                    @else
                                    <li class="last" id="order_total_price">Tổng<span>${{number_format($total_amount,2)}}</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>Thanh toán</h2>
                            <div class="content">
                                <div class="checkbox">
                                    {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                    <form-group>
                                        <input name="payment_method" type="radio" value="cod" class="group-checkbox-payment" onclick="showPrice(false)" checked> <label> Thanh toán khi giao hàng</label><br>
                                        <input name="payment_method" type="radio" value="paypal" class="group-checkbox-payment" onclick="showPrice(true)"> <label> Thanh toán chuyển khoản </label>
                                    </form-group>

                                </div>
                                <div class="info-banking">
                                    {!! $data->bank !!}
                                </div>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Payment Method Widget -->
                        <!-- <div class="single-widget payement">
                            <div class="content">
                                <img src="{{('backend/img/payment-method.png')}}" alt="#">
                            </div>
                        </div> -->
                        <!--/ End Payment Method Widget -->
                        <!-- Button Widget -->
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <button type="submit" class="btn">Hoàn tất</button>
                                </div>
                            </div>
                        </div>
                        <!--/ End Button Widget -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/ End Checkout -->

<!-- Start Shop Services Area  -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Miễn phí giao hàng</h4>
                    <p>Đơn hàng trên 10.000.000 vnđ</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Miễn phí trả hàng</h4>
                    <p>Đơn hàng dưới 30 ngày</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Thanh toán an toàn</h4>
                    <p>100% Thông qua tài khoản công ty</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Giá tốt nhất</h4>
                    <p>Đảm bảo giá cả cạnh tranh thị trường</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services -->

<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>Newsletter</h4>
                        <p> Đăng ký email để nhận ngay mã khuyến mãi <span>10%</span> off</p>
                        <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                            <input name="EMAIL" placeholder="Email của bạn" required="" type="email">
                            <button class="btn">Subscribe</button>
                        </form>
                    </div>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->
@endsection
@push('styles')
<style>
    li.shipping {
        display: inline-flex;
        width: 100%;
        font-size: 14px;
    }

    li.shipping .input-group-icon {
        width: 100%;
        margin-left: 10px;
    }

    .input-group-icon .icon {
        position: absolute;
        left: 20px;
        top: 0;
        line-height: 40px;
        z-index: 3;
    }

    .form-select {
        height: 30px;
        width: 100%;
    }

    .form-select .nice-select {
        border: none;
        border-radius: 0px;
        height: 40px;
        background: #f6f6f6 !important;
        padding-left: 45px;
        padding-right: 40px;
        width: 100%;
    }

    .list li {
        margin-bottom: 0 !important;
    }

    .list li:hover {
        background: #F7941D !important;
        color: white !important;
    }

    .form-select .nice-select::after {
        top: 14px;
    }
</style>
@endpush
@push('scripts')
<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.item-address').on("click", function() {
            $('.item-address').removeClass('active');
            $(this).addClass('active');;
            $('input[name="first_name"]').val($(this).children('.h_first_name').val());
            $('input[name="last_name"]').val($(this).children('.h_last_name').val());
            $('input[name="email"]').val($(this).children('.h_email').val());
            $('input[name="phone"]').val($(this).children('.h_phone').val());
            $('input[name="address1"]').val($(this).children('.h_address1').val());
            $('input[name="address2"]').val($(this).children('.h_address2').val());
            $('input[name="post_code"]').val($(this).children('.h_post_code').val());
            $('#country').val($(this).children('.h_country').val()).niceSelect('update');
            $('#country').niceSelect('update');
        });
        $("select.select2").select2();
    });
    $('select.nice-select').niceSelect();
</script>
<script>
    function showPrice(prs) {
        if (prs) {
            $('.info-banking').addClass('active');
        } else {
            $('.info-banking').removeClass('active');
        }
    }

    function showMe(box) {
        var checkbox = document.getElementById('shipping').style.display;
        // alert(checkbox);
        var vis = 'none';
        if (checkbox == "none") {
            vis = 'block';
        }
        if (checkbox == "block") {
            vis = "none";
        }
        document.getElementById(box).style.display = vis;
    }
</script>
<script>
    $(document).ready(function() {
        $('.shipping select[name=shipping]').change(function() {
            let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
            let subtotal = parseFloat($('.order_subtotal').data('price'));
            let coupon = parseFloat($('.coupon_price').data('price')) || 0;
            // alert(coupon);
            $('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
        });

    });
</script>

@endpush