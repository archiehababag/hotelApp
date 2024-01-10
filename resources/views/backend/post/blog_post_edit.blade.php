@extends('admin.admin_dashboard')
@section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Blog Post Page</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Blog Post</li>
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

								<form action="{{ route('blog.post.update') }}" method="post" class="row g-3" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $blog_post_edit->id }}">
                                    <div class="col-md-6">
										<label for="input7" class="form-label">Blog Category</label>
										<select name="blog_category_id" id="input7" class="form-select">
											<option selected="">Choose Category...</option>
											@foreach ($categories as $category)
                                                                                     
                                                <option value="{{ $category->id }}" {{ $category->id == $blog_post_edit->blog_category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>

											@endforeach
										</select>
									</div>
									<div class="col-md-6">
										<label for="input1" class="form-label">Post Title</label>
										<input name="post_title" type="text" class="form-control" id="input1" placeholder="Post Title" value="{{ $blog_post_edit->post_title }}">
									</div>
                                    <div class="col-md-12">
										<label for="input11" class="form-label">Short Description</label>
										<textarea name="short_description" class="form-control" id="input11" placeholder="Short Description ..." rows="3">{{ $blog_post_edit->short_description }}</textarea>
									</div>
									<div class="col-md-12">
                                        <label for="input11" class="form-label">Description</label>
                                        <textarea name="long_description" class="form-control" id="myeditorinstance" rows="3">{!! $blog_post_edit->long_description !!}</textarea>
                                    </div>
                                    <div class="col-md-6">
										<label for="input1" class="form-label">Post Image</label>
                                        <input class="form-control" type="file" name="post_image" id="image" />
									</div>
                                    <div class="col-md-6 mt-4">
										<label for="input1" class="form-label"></label>
                                        <img id="showImage" src="{{ asset($blog_post_edit->post_image) }}" alt="" class="rounded-circle p-1 bg-primary" width="80">
									</div>
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Submit</button>											
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

    {{-- <!-- Validation Script -->
    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    name: {
                        required : true,
                    }, 
                    position: {
                        required : true,
                    }, 
                    facebook: {
                        required : true,
                    },  
                    image: {
                        required : true,
                    },                   
                },
                messages :{
                    name: {
                        required : 'Please Enter Name',
                    }, 
                    position: {
                        required : 'Please Enter Position',
                    }, 
                    facebook: {
                        required : 'Please Enter Social Media Account',
                    },
                    image: {
                        required : 'Please Select Image',
                    },  
                },
                errorElement : 'span', 
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script> --}}

    <!-- Show Image Script -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    

@endsection