<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: my-courses.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
	<head> 
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Sign In - CourseHub</title>		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
	</head>
	<body class="bg-light">
		<div class="container">
			<main>
				<div class="py-5 text-center">
					<img class="d-block mx-auto mb-4" src="assets/brand/coursehub-logo.svg" alt="CourseHub Logo" width="72" height="57" />
					<h1 class="h2">Sign In</h1>
					<p class="lead text-body-secondary">
						Welcome back! Please sign in to continue.
					</p>
				</div>
				<div class="row g-5 justify-content-center">
					<div class="col-lg-6">
						<h2 class="h4 mb-3">Sign In</h2>						
						<div id="general-alert-message" class="mb-3" style="display: none;"></div>
						
						<form id="loginForm" class="needs-validation" novalidate>
							<div class="row g-3">
								<div class="col-12">
									<label for="email" class="form-label">Email</label>
									<input type="email" class="form-control" id="email" name="email" required />
									<div class="invalid-feedback" id="email-feedback">
										Please enter a valid email address.
									</div>
								</div>
								<div class="col-12">
									<label for="password" class="form-label">Password</label>
									<input type="password" class="form-control" id="password" name="password" required />
									<div class="invalid-feedback" id="password-feedback">
										Please enter your password.
									</div>
								</div>
							</div>
							<hr class="my-4" />
							<div class="d-grid gap-3">
								<button class="w-100 btn btn-primary rounded-pill" type="submit" id="submitBtn">
									Sign In
								</button>
								<p class="text-center mb-0">Don't have an account? <a href="signup.php">Sign up</a></p>
							</div>
						</form>
					</div>
				</div>
			</main>
			<footer class="my-5 text-body-secondary text-center small">
				<p class="mb-1">&copy; 2025 CourseHub</p>
			</footer>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
		
		<script>
			(function () {
				'use strict';

				const form = document.getElementById('loginForm');
				const generalAlertMessage = document.getElementById('general-alert-message');
				const submitBtn = document.getElementById('submitBtn');
				
				const emailInput = document.getElementById('email');
				const passwordInput = document.getElementById('password');
				const emailFeedback = document.getElementById('email-feedback');
				const passwordFeedback = document.getElementById('password-feedback');


				function resetAlert() {
					generalAlertMessage.style.display = 'none';
					generalAlertMessage.innerHTML = '';
					generalAlertMessage.classList.remove('alert', 'alert-danger', 'alert-success');
				}
				
				function resetFieldErrors() {
					emailInput.classList.remove('is-invalid');
					passwordInput.classList.remove('is-invalid');
					emailFeedback.textContent = 'Please enter a valid email address.';
					passwordFeedback.textContent = 'Please enter your password.';
				}


				form.addEventListener('submit', function (event) {
					event.preventDefault();
					event.stopPropagation();
					
					resetAlert();
					resetFieldErrors();

					if (!form.checkValidity()) {
						form.classList.add('was-validated');
						return;
					}

					form.classList.add('was-validated');
					
					const formData = new FormData(form);
					
					submitBtn.disabled = true;
					submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing In...';

					
					fetch('process_login.php', {
						method: 'POST',
						body: formData
					})
					.then(response => {
						if (!response.ok) {
							return response.json().then(err => { throw new Error(err.message || 'A server error occurred during login.') });
						}
						return response.json();
					})
					.then(data => {
						if (data.success) {
							generalAlertMessage.classList.add('alert', 'alert-success');
							generalAlertMessage.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>' + data.message;
							generalAlertMessage.style.display = 'block';
							form.reset();
							form.classList.remove('was-validated');
							resetFieldErrors();

							setTimeout(() => {
								window.location.href = 'my-courses.php';
							}, 1500);
							
						} else {
							throw new Error(data.message || 'Login failed.');
						}
					})
					.catch(error => {
						generalAlertMessage.classList.add('alert', 'alert-danger');
						generalAlertMessage.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + error.message;
						generalAlertMessage.style.display = 'block';

						form.classList.remove('was-validated');
						resetFieldErrors();
					})
					.finally(() => {
						submitBtn.disabled = false;
						submitBtn.innerHTML = 'Sign In';
					});

				}, false);
			})();
		</script>
	</body>
</html>