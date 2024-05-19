var app = app || {};

// Define Backbone view for user view
app.views.UserView = Backbone.View.extend({
	el: ".container",

	render: function () {
		// Log message indicating user view is being rendered
		console.log("userView render");

		// Get the template for the user view
		template = _.template($("#user_template").html());

		// Log message indicating rendering view with user's username
		console.log("render view: " + app.user.attributes.username);

		// Render the template with user attributes to the element
		this.$el.html(template(app.user.attributes));

		// Create and render navbar view with user model
		app.navView = new app.views.NavBarView({ model: app.user });
		app.navView.render();
	},

	// Define events and their corresponding functions
	events: {
		"click #edit_userdetails_btn": "editUserDetails",
		"click #edit_userpassword_btn": "changePassword",
		"click #edit_userchangedp_btn": "chooseProfilePic",
		"change #upload_image_input": "uploadImage",
		"click #submitPasswordChange": "submitPasswordChange",
	},

	// Function to handle submitting password change
	submitPasswordChange: function () {
		// Log message indicating password change submission
		console.log("submitPasswordChange");

		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));
		var user_id = userJson["user_id"];

		// Retrieve input values
		$oldPassword = $("input#oldPassword").val();
		$newPassword = $("input#newPassword").val();
		$confirmPassword = $("input#confirmPassword").val();

		// Check if new password and confirm password match
		if ($newPassword != $confirmPassword) {
			// Display error message if passwords do not match
			new Noty({
				type: "error",
				text: "New password and confirm password do not match",
				timeout: 2000,
			}).show();
		} else {
			// Prepare user password data
			var userPass = {
				user_id: user_id,
				oldpassword: $("input#oldPassword").val(),
				newpassword: $("input#newPassword").val(),
				confirmpassword: $("input#confirmPassword").val(),
			};

			// Define the URL for password change
			var url = this.model.url + "change_password";

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
							text: "Password changed successfully",
							timeout: 2000,
						}).show();
						$("#passwordModal").modal("hide");
					} else if (response.status === false) {
						// Display error message if old password is incorrect
						new Noty({
							type: "error",
							text: "Old password is incorrect",
							timeout: 2000,
						}).show();
					}
				},
				error: function (response) {
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
		$("input#oldPassword").val("");
		$("input#newPassword").val(""), $("input#confirmPassword").val("");
	},

	// Function to handle changing password
	changePassword: function () {
		// Log message indicating password change action
		console.log("changePassword");
		$("#passwordModal").modal("show");
	},

	// Function to handle choosing profile picture
	chooseProfilePic: function () {
		// Log message indicating choosing profile picture action
		console.log("chooseProfilePic");
		$("#upload_image_input").click();
	},

	// Function to handle uploading profile picture
	uploadImage: function () {
		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));
		var user_id = userJson["user_id"];
		console.log("user_id", user_id);
		console.log("uploadImage");

		// Get form data for updating user profile
		var validateUpdateUserProfile = validateUpdateUserProfileForm();
		validateUpdateUserProfile["user_id"] = user_id;
		console.log(
			"validateUpdateUserProfile",
			validateUpdateUserProfile.userimage,
			validateUpdateUserProfile.user_id
		);

		// Check if form data is valid
		if (validateUpdateUserProfile) {
			console.log(
				"validateUpdateUserProfile is valid",
				validateUpdateUserProfile
			);

			// Prepare form data for image upload
			var formData = new FormData();
			var imageFile = $("#upload_image_input")[0].files[0];
			formData.append("image", imageFile);
			formData.append("user_id", user_id);

			console.log("formData", formData.image);

			// Define the URL for updating user image
			var url = this.model.url + "edit_user_image";
			console.log("url", url);
			console.log("formData", formData);

			// Send AJAX request to update user image
			$.ajax({
				url: url,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: (response) => {
					console.log("response", response);
					validateUpdateUserProfile.userimage = response.imagePath;

					console.log(
						"validateUpdateUserProfile",
						validateUpdateUserProfile.userimage
					);
					this.model.set(validateUpdateUserProfile);

					$updateImage = this.model.attributes.userimage;
					console.log("$updateImage", $updateImage);

					// Define the URL for uploading user image
					var url = this.model.url + "upload_image";
					console.log("attriibuetes", this.model.attributes);

					// Save the updated model to the server
					this.model.save(this.model.attributes, {
						url: url,
						success: (model, response) => {
							console.log("success");
							console.log("model", model);
							console.log("response", response);

							// Update localStorage with the updated user image
							userJson["userimage"] = $updateImage;
							localStorage.setItem("user", JSON.stringify(userJson));

							// Display success message
							new Noty({
								type: "success",
								text: "Profile picture updated successfully",
								timeout: 2000,
							}).show();

							// Reload the page
							window.location.reload();
						},
						error: (model, response) => {
							console.error("Error:", response);
							new Noty({
								type: "error",
								text: "Failed to update profile picture. Please try again.",
								timeout: 2000,
							}).show();
						},
					});
				},
				error: function (response) {
					console.error("Error:", response);
					new Noty({
						type: "error",
						text: "Failed to update profile picture. Please try again.",
						timeout: 2000,
					}).show();
				},
			});
		}
	},

	// Function to handle editing user details
	editUserDetails: function () {
		// Retrieve user details from localStorage
		var userJson = JSON.parse(localStorage.getItem("user"));
		console.log("userJson", userJson);
		console.log("userJson", userJson["user_id"]);
		console.log("editUserDetails");

		var $editButton = this.$("#edit_userdetails_btn");

		// Toggle button text between "Edit User Details" and "Update Details"
		if ($editButton.text() === "Edit User Details") {
			$editButton.text("Update Details");

			// Enable input fields
			this.$("input").prop("disabled", false);
			this.$("select").prop("disabled", false);
		} else {
			// Change button text back to "Edit User Details"
			$editButton.text("Edit User Details");

			// Disable input fields
			this.$("input").prop("disabled", true);
			this.$("select").prop("disabled", true);

			// Get the updated user details from the input fields
			var validateEditUserDetailsForm = validateEditUserDetailsAddForm();
			validateEditUserDetailsForm["user_id"] = userJson["user_id"];

			if (validateEditUserDetailsForm) {
				console.log(
					"editUserDetailsForm is valid",
					validateEditUserDetailsForm
				);

				// Update model with edited details
				this.model.set(validateEditUserDetailsForm);

				// Define the URL for updating user details
				var url = this.model.url + "edit_user";
				console.log("url", url);
				console.log("this.model.attributes", this.model.attributes);

				// Save the updated model to the server
				this.model.save(this.model.attributes, {
					url: url,
					success: (model, response) => {
						console.log("success");
						console.log("model", model);
						console.log("response", response);

						// Update localStorage with the updated model
						localStorage.setItem("user", JSON.stringify(model));

						// Navigate to user home page
						app.appRouter.navigate("home/user/" + userJson["user_id"], {
							trigger: true,
						});
					},
					error: (model, response) => {
						console.error("Error:", response);
						new Noty({
							type: "error",
							text: "Failed to update user details. Please try again.",
							timeout: 2000,
						}).show();
					},
				});
			} else {
				// Display error message if form data is invalid
				new Noty({
					type: "error",
					text: "Please check if the requirements are satisfied or not",
					timeout: 2000,
				}).show();
			}
		}
	},
});
