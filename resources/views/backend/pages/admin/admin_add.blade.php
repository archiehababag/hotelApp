@extends('admin.admin_dashboard')
@section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Admin User Page</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Admin User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
							<div class="card-body p-4">

								<form action="{{ route('admin.store') }}" method="post" class="row g-3">
                                    @csrf
                                    
									<div class="col-md-6">
										<label for="input1" class="form-label">Admin Name</label>
										<input name="name" type="text" class="form-control">
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">Admin Email</label>
										<input name="email" type="email" class="form-control">
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">Admin Phone</label>
										<input name="phone" type="text" class="form-control">
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">Admin Address</label>
										<input name="address" type="text" class="form-control">
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">Admin Password</label>
										<input name="password" type="password" class="form-control">
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">Role Name</label>
										<select name="roles" class="form-select mb-3" aria-label="Default select example">
                                            <option selected="">Select Role</option>
                                            @foreach ($roles as $role)
                                                
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>

                                            @endforeach
                                            
                                        </select>
									</div>
                                    
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Save</button>											
										</div>
									</div>
								</form>

							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection