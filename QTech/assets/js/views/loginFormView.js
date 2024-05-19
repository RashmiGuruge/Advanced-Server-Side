var app = app || {};

// Define Backbone view for login form view
app.views.LoginFormView = Backbone.View.extend({

	el: ".container",

	render: function () {
		// Get the template for the login page
		var template = _.template($("#loginpage_template").html());
		// Render the template with model attributes to the element
		this.$el.html(template(this.model.attributes));
		// Log message indicating the login template is rendered
		console.log("login template");
	},

	// Define events and their corresponding functions
	events: {
		"click #login_button": "do_login",
		"click #signup_button": "do_register",
		"click #forget-password": "forget_password",
		"click #forgetPasswordChange": "forgetPasswordChange",
	},

	// Function to handle forget password event
	forget_password: function (e) {

		// Prevent default action and stop event propagation
		e.preventDefault();
		e.stopPropagation();

		// Log message indicating forget password action
		console.log("Forget Password");

		// Show the forget password modal
		$("#forgetPasswordModel").modal("show");
	},

	// Function to handle forget password change event
	forgetPasswordChange: function () {
		// Log message indicating forget password change action
		console.log("forgetPasswordChange");

		// Retrieve input values
		var $username = $("input#username").val();
		var $newPassword = $("input#newPassword").val();
		var $confirmPassword = $("input#confirmPassword").val();

		// Check if new password and confirm password match
		if ($newPassword !== $confirmPassword) {
			// Display error message if passwords do not match
			new Noty({
				type: "error",
				text: "New password and confirm password do not match",
				timeout: 2000,
			}).show();
		} else {
			// Prepare user password data
			var userPass = {
				username: $username,
				newpassword: $newPassword,
				confirmpassword: $confirmPassword,
			};

			// Define the URL for password change
			var url = this.model.url + "forget_password";

			// Send AJAX request to change password
			$.ajax({
				url: url,
				type: "POST",
				data: userPass,
				success: (response) => {
					// Handle success response
					console.log("response", response);
					if (response.status === true) {
						// Display success message if password changed successfully
						new Noty({
							type: "success",
							text: "Password successfully changed",
							timeout: 2000,
						}).show();
						$("#forgetPasswordModel").modal("hide");
					} else if (response.status === false) {
						// Display error message if username or email is incorrect
						new Noty({
							type: "error",
							text: "Incorrect username or email ",
							timeout: 2000,
						}).show();
					}
				},
				error: function (response) {
					// Handle error response
					console.error("Error:", response);
					new Noty({
						type: "error",
						text: "Failed to update password. Please try again.",
						timeout: 2000,
					}).show();
				},
			});
		}
		// Clear input fields
		$("input#username").val("");
		$("input#newPassword").val("");
		$("input#confirmPassword").val("");
	},

	// Function to handle login event
	do_login: function (e) {

		// Prevent default action and stop event propagation
		e.preventDefault();
		e.stopPropagation();

		// Validate login form
		var validateForm = validateLoginForm();
		if (!validateForm) {
			// Display error message if form is not valid
			new Noty({
				type: "error",
				text: "Please Enter the Credential",
				timeout: 2000,
			}).show();
			$("#error_mes_log").html("Please fill the form");
		} else {

			// Set model attributes with validated form data
			this.model.set(validateForm);

			// Define the URL for login
			var url = this.model.url + "login";
			console.log("url: ", url);

			// Send AJAX request to login
			this.model.save(this.model.attributes, {
				url: url,
				success: function (model, response) {
					new Noty({
						type: "success",
						text: "Login successful",
						timeout: 2000,
					}).show();
					$("#logout").show();
					localStorage.setItem("user", JSON.stringify(model));
					console.log("Login Done");
					window.location.href = "http://localhost/QTech/index.php/user/#login_page/home";
				},
				error: function (model, xhr) {
					if ((xhr.statsu = 400)) {
						$("#error_mes_log").html("Username or Password Incorrect");
						new Noty({
							type: "error",
							text: "Username or Password Incorrect",
							timeout: 2000,
						}).show();
					}
				},
			});
			console.log("Details have been filled");
		}
		console.log("click login");
	},

	// Function to handle register event
	do_register: function (e) {

		// Prevent default action and stop event propagation
		e.preventDefault();
		e.stopPropagation();

		// Validate register form
		var validateForm = validateRegisterForm();
		if (!validateForm) {
			// Display error message if form is not valid
			$("#error_mes_sign").html("Please fill the form");
		} else {

			console.log("validateForm: ");

			// Set model attributes with validated form data
			this.model.set(validateForm);

			// Define the URL for registration
			var url = this.model.url + "register";

			// Send AJAX request to register
			this.model.save(this.model.attributes, {
				url: url,
				success: function (model, response) {
					new Noty({
						type: "success",
						text: "Registration successful",
						timeout: 2000,
					}).show();
					console.log("Registration Done");
					app.appRouter.navigate("#", { trigger: true, replace: true });
				},
				error: function (model, xhr) {
					if (xhr.status === 409) {
						$("#error_mes_sign").html(xhr.responseJSON.data);
						new Noty({
							type: "error",
							text: "Username or Email already exists",
							timeout: 2000,
						}).show();
					} else {
						$("#error_mes_sign").html();
					}
				},
			});

			console.log("details are filled");
			console.log("validateForm: ", validateForm);
		}

		// Clear input fields
		$("#regUsername").val("");
		$("#regPassword").val("");
		$("#regOccupation").val("");
		$("#regName").val("");
		$("#regEmail").val("");
		
	},
});
