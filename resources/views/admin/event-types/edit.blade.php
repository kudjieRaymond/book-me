@extends('layouts.app')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/select2/dist/css/select2.min.css')}}">

@endsection
@section('content')
<div class="page-breadcrumb">
	<div class="row">
			<div class="col-5 align-self-center">
					<h4 class="page-title">Dashboard</h4>
					<div class="d-flex align-items-center">
							<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
											<li class="breadcrumb-item"><a href="#">Event Types</a></li>
											<li class="breadcrumb-item active" aria-current="page">Event Type</li>
									</ol>
							</nav>
					</div>
			</div>
	</div>
</div>
<div class="container-fluid">
	<!-- ============================================================== -->
	<!-- Datatable -->
	<!-- ============================================================== -->
	<div class="row">

	</div>
	<div class="row">
			<div class="col-12">
					<div class="card">
							
							<div class="card-body">
								<form action="{{route('admin.event-types.update', [$eventType->id])}}" method="POST" enctype="multipart/form-data">
									@csrf
									@method('PUT')
									<div class="form-group">
										<label>Name <span>*</span></label>	
										<input type="text" value="{{ old('name', isset($eventType) ? $eventType->name : '') }}" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" required title="Enter Name">
											@error('name')
											<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
											</span>
											@enderror
									</div>
								
									<div class="form-group">
										<label>slug </label>	
										<input type="text" value="{{old('slug' , isset($eventType) ? $eventType->slug : '')}}" class="form-control form-control-lg @error('slug') is-invalid @enderror" name="slug"   title="Enter slug">
											@error('slug')
											<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
											</span>
											@enderror
									</div>
									
									<div class="form-group">
										<label>Photo </label>	
										<input type="file"  class="form-control form-control-lg @error('phone') is-invalid @enderror" name="photo"   title="Select Photo">
											@error('phone')
											<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
											</span>
											@enderror
									</div>
									
									<button type="submit" class="btn btn-primary">SAVE</button>
								</form>
							</div>
						</div>	
			</div>
		
	</div>
	<!-- ============================================================== -->

</div>
@endsection
@section('scripts')

<script src="{{asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('dist/js/pages/forms/select2/select2.init.js')}}"></script>

@endsection