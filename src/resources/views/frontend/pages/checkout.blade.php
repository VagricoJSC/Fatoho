@extends('frontend.layouts.master')

@section('title','Thanh toán')

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0)">Thanh toán</a></li>
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
        <form class="form" method="POST" id="form_create" action="{{route('cart.order')}}">
            @csrf
            <div class="row">
				
                <div class="col-lg-7 col-12">
                    <div class="checkout-form">
						@if(count($orders) > 0) :
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
						@endif
                        <h2>Thông tin giao hàng</h2>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Họ: <span>*</span></label>
                                    <input type="text" name="first_name" class="val_fname" placeholder="" required value="{{old('first_name')}}" value="{{old('first_name')}}">
                                    @error('first_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tên: <span>*</span></label>
                                    <input type="text" name="last_name" class="val_lname" placeholder="" required value="{{old('lat_name')}}">
                                    @error('last_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Email <span>*</span></label>
                                    <input type="email" name="email" class="val_email" placeholder="" required value="{{old('email')}}">
                                    @error('email')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Số Điện Thoại <span>*</span></label>
                                    <input type="number" class="val_phone" name="phone" placeholder="" required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Quốc Gia<span>*</span></label>
                                    <select name="country" id="country">
                                        @foreach($countries as $code => $name)
                                        <option value="{{ $code }}" @if($code == 'VN') selected @endif>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tỉnh Thành<span>*</span></label>
                                    <select name="province" id="province">
                                        <option value="">Chọn Tỉnh Thành</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Quận Huyện<span>*</span></label>
                                    <select name="district" id="district">
                                        <option value="">Chọn Quận Huyện</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Phường Xã<span>*</span></label>
                                    <select name="wards" id="wards">
                                        <option value="">Chọn Phường Xã</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Số nhà / Tên đường / Xóm / Ấp<span>*</span></label>
                                    <input type="text" name="address1" placeholder="" id="address1" required value="{{old('address1')}}">
                                    <input type="hidden" name="address2" placeholder="" id="address2">
                                    @error('address1')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Địa chỉ 2</label>
                                    <input type="text" name="address2" placeholder="" value="{{old('address2')}}">
                                    @error('address2')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div> -->
                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Code Vùng</label>
                                    <input type="text" name="post_code" placeholder="" value="{{old('post_code')}}">
                                    @error('post_code')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div> -->

                        </div>
                        <!--/ End Form -->
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>Tổng Đơn Hàng</h2>
                            <div class="content">
                                <ul>
                                    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Tổng Tiền Sản Phẩm : <span>{{number_format(Helper::totalCartPrice(),0)}} VNĐ</span></li>
                                    <!-- <li class="shipping">Phí Ship : <span class="price_ship"> 0 VNĐ</span></li> -->
                                    <li class="shipping">
                                        <label>Phương Thức Giao Hàng<span class="required">*</span></label>
                                        <select name="shipping_vt" id="shipping_vt" class="nice-select">
                                            <option value="">Chọn Phương Thức Giao Hàng</option>
                                        </select>
                                    </li>
                                    @php
                                    $total_amount=Helper::totalCartPrice();
                                    @endphp
                                    <li class="last" id="order_total_price">Tổng Đơn Hàng : <span class="total_cart">{{number_format($total_amount,0)}} VNĐ</span></li>
									<input type="hidden" class="inp_total_cart" name="inp_total_cart" value="{{$total_amount}}" />
									<input type="hidden" class="inp_total_cart_ship"  name="inp_total_cart_ship" value="0" />
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
                                        <input name="payment_method" type="radio" value="bank" class="group-checkbox-payment" onclick="showPrice(true)"> <label> Thanh toán chuyển khoản </label>
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
                                    <button type="button" class="btn update_shipping">Hoàn tất</button>
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
                    <p>Đơn hàng trên 10.000.000 VNĐ</p>
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
<meta name="csrf-token" content="{{ csrf_token() }}">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
        const provincesApiUrl = "/viettel/listProvince";
        const districtsApiUrl = "/viettel/listDistrict?id=";
        const wardsApiUrl = "/viettel/listWards?id=";
		
        const checkPriceApiUrl = "/viettel/priceAllNlp";
        let provinces = [];
        let districts = [];
        let wards = [];
        let ptvc = [];
        let get_token = "{{$token}}";

        function formatVND(amount) {
            return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }
		function formatVNDPercent(amount) {
            return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }

        function checkUpdatePhiVanChuyen() {
            let val_province = $('#province').val();
            let val_district = $('#district').val();
            let val_ward = $('#wards').val();
            let val_address1 = $('#address1').val();
            if (!val_province) {
                return;
            }
            if (!val_district) {
                return;
            }
            if (!val_ward) {
                return;
            }
			// Trường này không ảnh hưởng giá thành vì vậy không cần phải đợi nhập xong mới tính giá
            //if (!val_address1) {
            //    return;
            //}
            let address_2 = val_address1 + ' ' + wards[val_ward] + ' ' + districts[val_district] + ' ' + provinces[val_province];
            $('#address2').val(address_2);
            $.ajax({
                url: checkPriceApiUrl, // URL of the API endpoint
                method: 'POST', // HTTP method
                contentType: 'application/json', // Set the content type to JSON
                data: JSON.stringify({ // Convert the JavaScript object to a JSON string
                    "SENDER_ADDRESS": "",
                    "RECEIVER_ADDRESS": $('#address2').val(),
                    "RECEIVER_PROVINCE": 1,
                    "PRODUCT_TYPE": "HH",
                    "PRODUCT_WEIGHT": "{{Helper::totalCartWEIGHT()}}",
                    "PRODUCT_PRICE": '{{$total_amount}}',
                    "MONEY_COLLECTION": "",
                    "PRODUCT_LENGTH": 0,
                    "PRODUCT_WIDTH": 0,
                    "PRODUCT_HEIGHT": 0,
                    "TYPE": 1
                }),
                headers: {
                    'Token': get_token,
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    // Handle the response from the server
                    console.log("Login successful:", response);
                    if (response && response.result) {
                        $('#shipping_vt').empty();
                        $('#shipping_vt').append(new Option("Chọn Phương Thức Giao Hàng", ""));
                        response.result.RESULT.forEach(function(ptgh) {
                            ptvc[ptgh.MA_DV_CHINH] = ptgh.GIA_CUOC;
                            $('#shipping_vt').append(new Option(ptgh.TEN_DICHVU + '( '+ptgh.THOI_GIAN+' ) : ' + formatVNDPercent(ptgh.GIA_CUOC), ptgh.MA_DV_CHINH));
                        });
                        $('#shipping_vt').niceSelect('update');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any errors that occur
                    console.log("Login failed:", textStatus, errorThrown);
                }
            });
        }
		$('#shipping_vt').on('change', function(){
			let val = $(this).val();
			let val_ship = ptvc[val];
			val_ship = val_ship;
			
			if (val) {
				let val_totoal = $('.inp_total_cart').val();
				$('.inp_total_cart_ship').val(val_ship);
				$('.total_cart').html(formatVND(parseInt(val_ship) + parseInt(val_totoal)));
				
			} else {
				let val_totoal = $('.inp_total_cart').val();
				$('.inp_total_cart_ship').val(0);
				$('.total_cart').html(formatVND(parseInt(val_totoal)));
			}
		});
        $('.update_shipping').on('click', function() {
            let val_province = $('#province').val();
            let val_district = $('#district').val();
            let val_ward = $('#wards').val();
            let val_address1 = $('#address1').val();
            let val_shipping = $('#shipping_vt').val();
			let val_fname = $('.val_fname').val();
			let val_lname = $('.val_lname').val();
			let val_email = $('.val_email').val();
			let val_phone = $('.val_phone').val();
			if (!val_fname) {
                swal('error', "Vui lòng nhập họ.", 'error').then(function() {});
                return;
            }
			if (!val_lname) {
                swal('error', "Vui lòng nhập tên.", 'error').then(function() {});
                return;
            }
			if (!val_email) {
                swal('error', "Vui lòng nhập email.", 'error').then(function() {});
                return;
            }
			if (!val_phone) {
                swal('error', "Vui lòng nhập phone.", 'error').then(function() {});
                return;
            }

            if (!val_province) {
                swal('error', "Vui lòng chọn tỉnh trước khi cập nhật phí vận chuyển.", 'error').then(function() {});
                return;
            }
            if (!val_district) {
                swal('error', "Vui lòng chọn quận/huyện trước khi cập nhật phí vận chuyển.", 'error').then(function() {});
                return;
            }
            if (!val_ward) {
                swal('error', "Vui lòng chọn phường xã trước khi cập nhật phí vận chuyển.", 'error').then(function() {});
                return;
            }
            if (!val_address1) {
                swal('error', "Vui lòng nhập địa chỉ nhà trước khi cập nhật phí vận chuyển.", 'error').then(function() {});
                return;
            }
            if (!val_shipping) {
                swal('error', "Vui lòng chọn phương thức giao hàng trước khi xác nhận.", 'error').then(function() {});
                return;
            }
            let address_2 = val_address1 + ' ' + wards[val_ward] + ' ' + districts[val_district] + ' ' + provinces[val_province];
            $('#address2').val(address_2);
			$('#form_create').submit();

        });
        $('.shipping select[name=shipping]').change(function() {
            let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
            let subtotal = parseFloat($('.order_subtotal').data('price'));
            let coupon = parseFloat($('.coupon_price').data('price')) || 0;
            // alert(coupon);
            $('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
        });

        $.ajax({
            url: provincesApiUrl,
            method: 'GET',
			headers: {
				'Access-Control-Allow-Origin': '*'
			},
            success: function(data) {
                $('#province').empty();
                $('#province').append(new Option("Chọn Tỉnh Thành", ""));
                data.result.data.forEach(function(province) {
                    provinces[province.PROVINCE_ID] = province.PROVINCE_NAME;
                    $('#province').append(new Option(province.PROVINCE_NAME, province.PROVINCE_ID));
                });
                $('#province').niceSelect('update');
            },
            error: function(error) {
                console.log('Error fetching provinces:', error);
            }
        });


        $('#province').on('change', function() {
            if ($(this).val()) {
                $.ajax({
                    url: districtsApiUrl + $(this).val(),
                    method: 'GET',
                    success: function(data) {
                        $('#district').empty();
                        $('#district').append(new Option("Chọn Quận Huyện", ""));
                        data.result.data.forEach(function(district) {
                            districts[district.DISTRICT_ID] = district.DISTRICT_NAME;
                            $('#district').append(new Option(district.DISTRICT_NAME, district.DISTRICT_ID));
                        });
                        $('#district').niceSelect('update');
                    },
                    error: function(error) {
                        console.log('Error fetching provinces:', error);
                    }
                });
            }
            checkUpdatePhiVanChuyen();
        });

        $('#district').on('change', function() {
            if ($(this).val()) {
                $.ajax({
                    url: wardsApiUrl + $(this).val(),
                    method: 'GET',
                    success: function(data) {
                        $('#wards').empty();
                        $('#wards').append(new Option("Chọn Phường Xã", ""));
                        data.result.data.forEach(function(district) {
                            wards[district.WARDS_ID] = district.WARDS_NAME;
                            $('#wards').append(new Option(district.WARDS_NAME, district.WARDS_ID));
                        });
                        $('#wards').niceSelect('update');
                    },
                    error: function(error) {
                        console.log('Error fetching provinces:', error);
                    }
                });
            }
            checkUpdatePhiVanChuyen();
        });
        $('#wards').on('change', function() {
            checkUpdatePhiVanChuyen();
        });
        $('#address1').on('change', function() {
            checkUpdatePhiVanChuyen();
        });

    });
</script>

@endpush