<?php
$current_date = date('Y-m-d');
?>
<!doctype html>
<html lang="en">
	<head> 
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Sign Up - CourseHub</title>		
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
	</head>
	<body class="bg-light">
		<div class="container">
			<main>
				<div class="py-5 text-center">
					<img class="d-block mx-auto mb-4" src="assets/brand/coursehub-logo.svg" alt="CourseHub Logo" width="72" height="57" />
					<h1 class="h2">Create Account</h1>
					<p class="lead text-body-secondary">
						Join CourseHub today to start your learning journey.
					</p>
				</div>
				<div class="row g-5 justify-content-center">
					<div class="col-lg-6">
						<h2 class="h4 mb-3">Account Details</h2>						
						<div id="general-alert-message" class="mb-3" style="display: none;"></div>

						<form id="signupForm" class="needs-validation" novalidate>
							<div class="row g-3">
								<div class="col-sm-6">
									<label for="firstName" class="form-label">First name</label>
									<input type="text" class="form-control" id="firstName" name="firstName" required />
									<div class="invalid-feedback">
										Valid first name is required.
									</div>
								</div>
								<div class="col-sm-6">
									<label for="lastName" class="form-label">Last name <span class="text-body-secondary">(Optional)</span></label>
									<input type="text" class="form-control" id="lastName" name="lastName" />
								</div>
								<div class="col-12">
									<label for="email" class="form-label">Email</label>
									<input type="email" class="form-control" id="email" name="email" required />
									<div class="invalid-feedback" id="email-feedback">
										Please enter a valid email address.
									</div>
								</div>
								<div class="col-md-6">
									<label for="gender" class="form-label">Gender</label>
									<select class="form-select" id="gender" name="gender" required>
										<option value="" selected disabled>Choose...</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="other">Other</option>
									</select>
									<div class="invalid-feedback">
										Please select your gender.
									</div>
								</div>
								<div class="col-md-6">
									<label for="birthdate" class="form-label">Date of Birth</label>
									<input type="date" class="form-control" id="birthdate" name="birthdate" required max="<?php echo $current_date; ?>" />
									<div class="invalid-feedback">
										Please select your date of birth.
									</div>
								</div>
								<div class="col-md-6">
									<label for="state" class="form-label">State</label>
									<select class="form-select" id="state" name="state" required>
										<option value="" selected disabled>Choose...</option>
										<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
										<option value="Andhra Pradesh">Andhra Pradesh</option>
										<option value="Arunachal Pradesh">Arunachal Pradesh</option>
										<option value="Assam">Assam</option>
										<option value="Bihar">Bihar</option>
										<option value="Chandigarh">Chandigarh</option>
										<option value="Chhattisgarh">Chhattisgarh</option>
										<option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
										<option value="Delhi">Delhi</option>
										<option value="Goa">Goa</option>
										<option value="Gujarat">Gujarat</option>
										<option value="Haryana">Haryana</option>
										<option value="Himachal Pradesh">Himachal Pradesh</option>
										<option value="Jammu and Kashmir">Jammu and Kashmir</option>
										<option value="Jharkhand">Jharkhand</option>
										<option value="Karnataka">Karnataka</option>
										<option value="Kerala">Kerala</option>
										<option value="Ladakh">Ladakh</option>
										<option value="Lakshadweep">Lakshadweep</option>
										<option value="Madhya Pradesh">Madhya Pradesh</option>
										<option value="Maharashtra">Maharashtra</option>
										<option value="Manipur">Manipur</option>
										<option value="Meghalaya">Meghalaya</option>
										<option value="Mizoram">Mizoram</option>
										<option value="Nagaland">Nagaland</option>
										<option value="Odisha">Odisha</option>
										<option value="Puducherry">Puducherry</option>
										<option value="Punjab">Punjab</option>
										<option value="Rajasthan">Rajasthan</option>
										<option value="Sikkim">Sikkim</option>
										<option value="Tamil Nadu">Tamil Nadu</option>
										<option value="Telangana">Telangana</option>
										<option value="Tripura">Tripura</option>
										<option value="Uttar Pradesh">Uttar Pradesh</option>
										<option value="Uttarakhand">Uttarakhand</option>
										<option value="West Bengal">West Bengal</option>
									</select>
									<div class="invalid-feedback">
										Please provide a valid state.
									</div>
								</div>
								<div class="col-md-6">
									<label for="pincode" class="form-label">Pincode</label>
									<input type="text" class="form-control" id="pincode" name="pincode" required pattern="^[1-9]\d{5}$" maxlength="6" />
									<div class="invalid-feedback">Please provide a valid 6-digit pincode (must not start with 0).</div>
								</div>
								<div class="col-12">
									<label for="password" class="form-label">Password</label>
									<input type="password" class="form-control" id="password" name="password" required />
									<div class="invalid-feedback">
										Please enter a password.
									</div>
								</div>
							</div>
							<hr class="my-4" />
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="terms" name="terms" required />
								<label class="form-check-label" for="terms">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a> of CourseHub</label>
								<div class="invalid-feedback">
									You must agree before submitting.
								</div>
							</div>
							<hr class="my-4" />
							<div class="d-grid gap-3">
								<button class="w-100 btn btn-primary rounded-pill" type="submit" id="submitBtn">
									Create Account
								</button>
								<p class="text-center mb-0">Already have an account? <a href="login.php">Log in</a></p>
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

				const form = document.getElementById('signupForm');
				const generalAlertMessage = document.getElementById('general-alert-message');
				const emailInput = document.getElementById('email');
				const emailFeedback = document.getElementById('email-feedback');
				const submitBtn = document.getElementById('submitBtn');

				function resetCustomErrors() {
					emailInput.classList.remove('is-invalid');
					emailFeedback.textContent = 'Please enter a valid email address.';
					generalAlertMessage.style.display = 'none';
					generalAlertMessage.innerHTML = '';
				}

				form.addEventListener('submit', function (event) {
					event.preventDefault();
					event.stopPropagation();
										
					resetCustomErrors();

					if (!form.checkValidity()) {
						form.classList.add('was-validated');
						return;
					}

					form.classList.add('was-validated');
					
					const formData = new FormData(form);
					
					submitBtn.disabled = true;
					submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...';

					
					fetch('process_signup.php', {
						method: 'POST',
						body: formData
					})
					.then(response => {
						if (!response.ok) {
							return response.json().then(err => { throw new Error(err.message || 'An unknown error occurred on the server.') });
						}
						return response.json();
					})
					.then(data => {
						if (data.success) {
							generalAlertMessage.classList.remove('alert-danger');
							generalAlertMessage.classList.add('alert-success');
							generalAlertMessage.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>' + data.message;
							generalAlertMessage.style.display = 'block';
							form.reset();
							form.classList.remove('was-validated');

							setTimeout(() => {
								window.location.href = 'login.php';
							}, 3000);
						} else {
							throw new Error(data.message || 'Signup failed.');
						}
					})
					.catch(error => {
						const errorMessage = error.message;

						if (errorMessage.includes("email already exists")) {
							emailInput.classList.add('is-invalid');
							emailFeedback.textContent = 'An account with this email already exists. Please log in.';
							form.classList.add('was-validated'); 
						} else {
							generalAlertMessage.classList.remove('alert-success');
							generalAlertMessage.classList.add('alert-danger');
							generalAlertMessage.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + errorMessage;
							generalAlertMessage.style.display = 'block';
						}
					})
					.finally(() => {
						submitBtn.disabled = false;
						submitBtn.innerHTML = 'Create Account';
					});

				}, false);
			})();
		</script>
	</body>
</html>