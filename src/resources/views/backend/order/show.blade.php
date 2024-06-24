@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Order       
	<div class="row">
		<div class="col-md-12">
			@include('backend.layouts.notification')
		</div>
	</div>
  <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> In đơn hàng</a>
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>S.N.</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Quantity</th>
            <th>Ship</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$order->id}}</td>
            <td>{{@$order->vit_post_data->ORDER_NUMBER}}</td>
            <td>{{$order->first_name}} {{$order->last_name}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{number_format($order->inp_total_cart_ship,0)}} VNĐ</td>
            <td>{{number_format($order->total_amount,0)}} VNĐ</td>
            <td>
                @if($order->status=='new')
                  <span class="badge badge-primary">{{$order->status}}</span>
                @elseif($order->status=='process')
                  <span class="badge badge-warning">{{$order->status}}</span>
                @elseif($order->status=='delivered')
                  <span class="badge badge-success">{{$order->status}}</span>
                @else
                  <span class="badge badge-danger">{{$order->status}}</span>
                @endif
            </td>
            <td>
                <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                  @csrf
                  @method('delete')
                      <!--<button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>-->
                </form>
            </td>

        </tr>
      </tbody>
    </table>

	<table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>S.N.</th>
            <th>Name</th>
            <th>Quantity</th>
        </tr>
      </thead>
      <tbody>
		@foreach($carts as $cart)  
        <tr>
            <td>{{$cart->id}}</td>
            <td>{{@$cart->product->title}}</td>
            <td>{{$cart->quantity}}</td>
        </tr>
		@endforeach
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">ORDER INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Order Number</td>
                        <td> : {{$order->order_number}}</td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td> : {{$order->quantity}}</td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td> : {{$order->status}}</td>
                    </tr>
                    <tr>
                        <td>Shipping Charge</td>
                        <td> : {{number_format($order->inp_total_cart_ship,0)}} VNĐ</td>
                    </tr>
                    
                    <tr>
                        <td>Total Amount</td>
                        <td> :  {{number_format($order->total_amount,0)}} VNĐ</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td> : @if($order->payment_method=='cod') Giao Hàng Lấy Tiền @else Chuyển Khoản Ngân Hàng @endif</td>
                    </tr>
                    <tr>
                        <td>Payment Status</td>
                        <td> : @if($order->payment_status=='paid') Đã Thanh Toán @else Chưa Thanh Toán @endif</td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Full Name</td>
                        <td> : {{$order->first_name}} {{$order->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$order->email}}</td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td> : {{$order->phone}}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td> : {{$order->address2}}</td>
                    </tr>
              </table>
            </div>
			<div>
				<table class="table">
                    <tr>
                        <td>
							@if($order->payment_status=='unpaid')
								<a href="{{route('order.paid',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right">Xác nhận đã thanh toán</a>
							@endif
						</td>
                        <td>
							@if($order->status=='new')
								<a href="{{route('order.requestdelivery',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right">Gửi yêu cầu chuyển hàng (ViettelPost)</a>
							@endif
						</td>
                    </tr>
				</table>
			</div>
          </div>

      </div>
    </section>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
