@extends('layouts.app')
@section('styles')

@endsection
@section('content')
<div class="page-breadcrumb">
	<div class="row">
			<div class="col-5 align-self-center">
					<h4 class="page-title">Dashboard</h4>
					<div class="d-flex align-items-center">
							<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
											<li class="breadcrumb-item"><a href="#">Locations</a></li>
											<li class="breadcrumb-item active" aria-current="page">Show Location</li>
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
								<a href="{{url()->previous()}}" class="btn btn-default">Back To List</a>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="zero_config" class="table table-striped table-bordered">
										
										<tbody>
											
												<tr>
													<td>
                                Name
                            </td>
													<td>
                                {{ $location->name ?? '' }}
														</td>
												</tr>
												<tr>
													<td>
														Slug
													</td>
													 <td>
                                {{ $location->slug ?? '' }}
                            </td>
												</tr>
                       
                        
												<tr>
													<td>Photo</td>
													<td>
                                <img src="{{ $location->photo->thumbnail ?? '' }}" alt="location photo">
                            </td>
												</tr>    
                        
										</tbody>
									</table>
								</div>
								
							</div>
						</div>	
			</div>
		
	</div>
	<!-- ============================================================== -->

</div>
@endsection
