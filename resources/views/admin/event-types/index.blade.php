@extends('layouts.app')
@section('styles')
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">

@endsection
@section('content')
<div class="page-breadcrumb">
	<div class="row">
			<div class="col-5 align-self-center">
					<h4 class="page-title">Dashboard</h4>
					<div class="d-flex align-items-center">
							<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
											<li class="breadcrumb-item"><a href="#">Event Type</a></li>
											<li class="breadcrumb-item active" aria-current="page">All Event Type</li>
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
								<a href="{{route('admin.event-types.create')}}" class="btn btn-primary">Add New </a>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="zero_config" class="table table-striped table-bordered">
										<thead>
												<tr>
														<th>Name</th>
														<th>Slug</th>
														<th>Photo</th>
														<th>Action</th>
												</tr>
										</thead>
										<tbody>
												@forelse ($eventTypes as $eventType)
												<tr>
													<td>
                                {{ $eventType->name ?? '' }}
                            </td>
                            <td>
                                {{ $eventType->slug ?? '' }}
                            </td>
                            <td>
                                <img src="{{ $eventType->photo->thumbnail ?? '' }}" alt="event-type photo">
                            </td>
                            
														<td>
															<a href="{{route('admin.event-types.show', [$eventType->id])}}" class="btn btn-primary btn-sm">Show</a>
															<a href="{{route('admin.event-types.edit', [$eventType->id])}}" class="btn btn-warning btn-sm">Edit</a>
															
																<a href="" id="{{$eventType->id}}" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger delete-client btn-sm">Delete</a>
															
														</td>
												</tr>
												@empty
												<tr>
														<td colspan="10">No Event Type</td>
												</tr>
												@endforelse
										</tbody>
									</table>
								</div>
								<!-- sample modal content -->
								<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
										<div class="modal-dialog modal-sm">
												<div class="modal-content">
														<div class="modal-header">
																<h4 class="modal-title" id="mySmallModalLabel">Confirm Action</h4>
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														</div>
														<div class="modal-body">
															<form method="POST" id ="delete-form">
																@csrf
																@method('DELETE')
																<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
																<button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>	
															</form>
														</div>
												</div>
												<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

							</div>
						</div>	
			</div>
		
	</div>
	<!-- ============================================================== -->

</div>
@endsection

@section('scripts')

<!--This page plugins -->
<script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{asset('dist/js/pages/datatable/datatable-basic.init.js')}}"></script>

<script>
	const deleteClient = document.querySelectorAll('.delete-client');
	deleteClient.forEach(el =>{
    el.addEventListener('click', function(event){
			event.preventDefault();
			let url = "{{route('admin.event-types.destroy', ':client')}}" ;
			url = url.replace(":client", event.target.id) ;

			const deleteForm = document.querySelector('#delete-form');
			deleteForm.setAttribute('action', url);
			
    })
	})
	

</script>

@endsection