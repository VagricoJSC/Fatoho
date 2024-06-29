@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Post</h5>
	<div class="row">
		<div class="col-md-12">
			@include('backend.layouts.notification')
		</div>
	</div>
	
    <div class="card-body">
    <form method="post" action="{{route('settings.update')}}">
        @csrf 
        {{-- @method('PATCH') --}}
        {{-- {{dd($data)}} --}}
        <div class="form-group">
          <label for="short_des" class="col-form-label">Short Description <span class="text-danger">*</span></label>
          <textarea class="form-control" id="quote" name="short_des">{{$data->short_des}}</textarea>
          @error('short_des')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
          <textarea class="form-control" id="description" name="description">{{$data->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

		<div class="form-group">
          <label for="bank" class="col-form-label">Footer description <span class="text-danger">*</span></label>
          <textarea class="form-control" id="footer_description" name="footer_description">{{$data->footer_description}}</textarea>
          @error('footer_description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="bank" class="col-form-label">Info Banking Order <span class="text-danger">*</span></label>
          <textarea class="form-control" id="bank" name="bank">{{$data->bank}}</textarea>
          @error('bank')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span>
          <input id="thumbnail1" class="form-control" type="text" name="logo" value="{{$data->logo}}">
        </div>
        <div id="holder1" style="margin-top:15px;max-height:100px;"></div>

          @error('logo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$data->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>

          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="address" required value="{{$data->address}}">
          @error('address')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" required value="{{$data->email}}">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="phone" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="phone" required value="{{$data->phone}}">
          @error('phone')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>   
<div class="form-group">
          <label for="facebook" class="col-form-label">Facebook<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="facebook" required value="{{$data->facebook}}">
          @error('facebook')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> 
<div class="form-group">
          <label for="youtube" class="col-form-label">Youtube<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="youtube" required value="{{$data->youtube}}">
          @error('youtube')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> 
<div class="form-group">
          <label for="instagram" class="col-form-label">Instagram<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="instagram" required value="{{$data->instagram}}">
          @error('instagram')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> 		
	<div class="form-group">
          <label for="phone" class="col-form-label">Loaction Map <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="map_location" required value="{{$data->map_location}}">
          @error('map_location')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image');
    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Write short Quote.....",
          tabsize: 2,
          height: 100
      });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    $(document).ready(function() {
      $('#bank').summernote({
        placeholder: "Write detail bank.....",
          tabsize: 2,
          height: 150
      });
    });
	$(document).ready(function() {
      $('#footer_description').summernote({
        placeholder: "Write detail .....",
          tabsize: 2,
          height: 150
      });
    });
</script>
@endpush