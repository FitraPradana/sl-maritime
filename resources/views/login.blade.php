<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>SLM - Login</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}template_hrsm/assets/img/favicon.png">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/font-awesome.min.css">

		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/style.css">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="{{ asset('/') }}template_hrsm/assets/js/html5shiv.min.js"></script>
			<script src="{{ asset('/') }}template_hrsm/assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body class="account-page">

		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				{{-- <a href="job-list.html" class="btn btn-primary apply-btn">Apply Job</a> --}}
				<div class="container">

					<!-- Account Logo -->
					<div class="account-logo">
						{{-- <a href="#"><img src="{{ asset('/') }}template_hrsm/assets/img/logo2.png" alt="Dreamguy's Technologies"></a> --}}
					</div>
					<!-- /Account Logo -->

					<div class="account-box">
						<div class="account-wrapper">
							<h3 class="account-title">Login</h3>
							<p class="account-subtitle">Access to our dashboard</p>

							<!-- Account Form -->
							<form id="login-form" action="{{ route('cpanel_login_proses') }}" method="POST">
                                @csrf
								<div class="form-group">
									<label>Email Address</label>
									<input class="form-control" type="email" name="email">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col">
											<label>Password</label>
										</div>
										<div class="col-auto">
											{{-- <a class="text-muted" href="forgot-password.html">
												Forgot password?
											</a> --}}
										</div>
									</div>
									<input class="form-control" type="password" name="password">
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" type="submit">Login</button>
								</div>
								<div class="account-footer">
									{{-- <p>Don't have an account yet? <a href="register.html">Register</a></p> --}}
								</div>
							</form>
							<!-- /Account Form -->

						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
        <script src="{{ asset('/') }}template_hrsm/assets/js/jquery-3.5.1.min.js"></script>

		<!-- Bootstrap Core JS -->
        <script src="{{ asset('/') }}template_hrsm/assets/js/popper.min.js"></script>
        <script src="{{ asset('/') }}template_hrsm/assets/js/bootstrap.min.js"></script>

		<!-- Custom JS -->
		<script src="{{ asset('/') }}template_hrsm/assets/js/app.js"></script>

        <script type="text/javascript">
            $(function () {

                $(document).on("submit", "#login-form", function() {
                  var e = this;

                  $(this).find("[type='submit']").html("Login...");

                  $.ajax({
                      url: $(this).attr('action'),
                      data: $(this).serialize(),
                      type: "POST",
                      dataType: 'json',
                      success: function (data) {

                        $(e).find("[type='submit']").html("Login");

                        if (data.status) {
                            window.location = data.redirect;
                        }else{
                            $(".alert").remove();
                            $.each(data.errors, function (key, val) {
                                $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: ""+val+".",
                                });
                            });

                        }

                      }
                  });

                  return false;
              });

            });
        </script>

    </body>
</html>
