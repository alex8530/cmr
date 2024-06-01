<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
  <!-- Favicons -->
  <link href="{{ asset('template/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset('template/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

	<!--plugins-->
	<link href="{{asset('backend/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('backend/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('backend/assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('backend/assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('backend/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('backend/assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('backend/assets/css/icons.css')}}" rel="stylesheet">
	<title>Alexa</title>
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="d-flex align-items-center justify-content-center my-5">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card mb-0">
							<div class="card-body">
								<div class="p-4">
									<div class="mb-3 text-center">
										<img src="assets/images/logo-icon.png" width="60" alt="" />
									</div>
									<div class="mb-3 text-center">
										<img src="{{asset('template/assets/img/apple-touch-icon.png')}}" width="60" alt="">
									</div>
									<div class="text-center mb-4">
										<h5 class="">Alexa Admin</h5>
										<p class="mb-0">Please fill the below details to create your account</p>
									</div>
									<div class="form-body">
										<form  action="{{ route('admin.signup') }}"  method="POST"  class="row g-3">

                                            @csrf
					
											{{-- {{session()->invalidate();  }} --}}
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email Address</label>
												<input type="email" name="email"  class="form-control  @error('email') is-invalid @enderror" id="inputEmailAddress" value={{ old('email') }} >
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
											</div>
                                            
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Name</label>
												<input type="name" name="name"  class="form-control  @error('name') is-invalid @enderror" id="inputEmailAddress" value={{ old('name') }}  >
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
											</div>
                                            
       
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">User Name</label>
												<input type="username" name="username"  class="form-control  @error('username') is-invalid @enderror" id="inputEmailAddress" value={{ old('username') }}  >
                                                @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
											</div>

											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Phone</label>
												<input type="phone" name="phone"  class="form-control  @error('phone') is-invalid @enderror" id="inputEmailAddress" value={{ old('phone') }}  >
                                                @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
											</div>

											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Address</label>
												<input type="address" name="address"  class="form-control  @error('address') is-invalid @enderror" id="inputEmailAddress" value={{ old('address') }} >
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
											</div>


											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name = "password" class="form-control border-end-0  @error('password') is-invalid @enderror" id="inputChoosePassword"  placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                               
                                                </div>
												@error('password')
												<span class="text-danger">{{ $message }}</span>
											  @enderror
											</div>


                                            
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name = "password_confirmation" class="form-control border-end-0  @error('password_confirmation') is-invalid @enderror" id="inputChoosePassword"  placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                              
                                                </div>
												@error('password_confirmation')
												<span class="text-danger">{{ $message }}</span>
											  @enderror
											</div>
								 


								 
											<div class="col-12">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
													<label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms & Conditions</label>
												</div>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary">Sign up</button>
												</div>
											</div>
											<div class="col-12">
												<div class="text-center ">
													<p class="mb-0">Already have an account? <a href="{{ route('admin.login') }}">Sign in here</a></p>
												</div>
											</div>
										</form>
									</div>
									{{-- <div class="login-separater text-center mb-5"> <span>OR SIGN UP WITH EMAIL</span>
										<hr/>
									</div>
									<div class="list-inline contacts-social text-center">
										<a href="javascript:;" class="list-inline-item bg-facebook text-white border-0 rounded-3"><i class="bx bxl-facebook"></i></a>
										<a href="javascript:;" class="list-inline-item bg-twitter text-white border-0 rounded-3"><i class="bx bxl-twitter"></i></a>
										<a href="javascript:;" class="list-inline-item bg-google text-white border-0 rounded-3"><i class="bx bxl-google"></i></a>
										<a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i class="bx bxl-linkedin"></i></a>
									</div> --}}

								</div>
							</div>
						</div>
					</div>
				 </div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{asset('backend/assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="{{asset('backend/assets/js/app.js')}}"></script>
</body>

</html>