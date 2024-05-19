var app = app || {};
app.views = {};
app.routers = {};
app.models = {};
app.collections = {};


// Validation function for login form
function validateLoginForm() {
	var user = {
		username: $("input#inputUsername").val(),  // Get username input value
		password: $("input#inputPassword").val(),  // Get password input value
	};
	// Check if username or password is empty
	if (!user.username || !user.password) {
		return false; // Return false if either username or password is empty
	}
	return user; // Return user object if validation passes
}


// Validation function for registration form
function validateRegisterForm() {
	var user = {
		username: $("input#regUsername").val(),       // Get username input value
		password: $("input#regPassword").val(),       // Get password input value
		occupation: $("select#regOccupation").val(),  // Get occupation input value
		name: $("input#regName").val(),               // Get name input value
		email: $("input#regEmail").val(),             // Get email input value
	};

	// Check if any of the required fields are empty
	if (
		!user.username ||
		!user.password ||
		!user.occupation ||
		!user.name ||
		!user.email
	) {
		return false;  // Return false if any required field is empty
	}
	return user;   // Return user object if validation passes
}


// Validation function for updating user profile form
function validateUpdateUserProfileForm() {
	var userImg = {
		userimage: $("input#upload_image_input")[0].files[0],  // Get uploaded image file
	};
	return userImg;
}


// Validation function for changing password form
function validateChangePasswordForm() {
	var userPass = {
		oldpassword: $("input#oldPassword").val(),         // Get old password input value
		newpassword: $("input#newPassword").val(),         // Get new password input value
		confirmpassword: $("input#confirmPassword").val(), // Get confirm password input value
	};
	if (userPass.newpassword !== userPass.confirmpassword) {
		return false;
	}
	// Check if new password matches confirm password and none of the fields are empty
	if (
		!userPass.oldpassword ||
		!userPass.newpassword ||
		!userPass.confirmpassword
	) {
		return false;
	}

	return userPass;
}


// Validation function for answer form
function validateAnswerForm() {

	var answer = {	
		// Get answer input value and replace newline characters with <br>
		answer: $("textarea#inputQuestionDetails").val().replace(/\n/g, "<br>"),  
		// Get uploaded image file
		answerimage: $("input#answerImageUpload")[0].files[0],
		// Get selected rate value
		rate: $("select#questionrate").val(),
		// Get current date and time in ISO format
		answeraddeddate: new Date().toISOString().slice(0, 19).replace("T", " "),
	};

	// Check if answer field is empty
	if (!answer.answer) {
		return false;
	}

	return answer;
}


// Validation function for search form
function validateSearchForm() {
	var search = {
		search: $("input#searchHome").val(),  // Get search input value
	};

	// Check if search field is empty
	if (!search.search) {
		return false;
	}

	return search;
}


// Validation function for editing user details form
function validateEditUserDetailsAddForm() {

	var editUser = {
		username: $("input#editusername").val(),       // Get username input value
		name: $("input#editname").val(),               // Get name input value
		email: $("input#editemail").val(),             // Get email input value
		occupation: $("select#editOccupation").val(),  // Get occupation input value
	};

	// Check if any of the required fields are empty
	if (
		!editUser.username ||
		!editUser.name ||
		!editUser.email ||
		!editUser.occupation
	) {
		return false;
	}

	return editUser;
}


// Validation function for question addition form
function validateQuestionAddForm() {

	var question = {
		title: $("input#inputQuestionTitle").val(),           // Get question title input value
		question: $("textarea#inputQuestionDetails").val().replace(/\n/g, "<br>"),     // Get question details input value and replace newline characters with <br>
		expectationQ: $("textarea#inputQuestionExpectation")
			.val()
			.replace(/\n/g, "<br>"),       
		questionimage: $("input#imageUpload")[0].files[0], // Get uploaded image file
		category: $("select#questionCategory").val(),      // Get selected category value
		tags: $("input#inputQuestionTags").val(),          // Get tags input value
		qaddeddate: new Date().toISOString().slice(0, 19).replace("T", " "),       // Get current date and time in ISO format
	};

	console.log("question: " + question);

	// Check if 'question' or 'expectationQ' has at least 20 characters
	if (!question.question || question.question.length < 20) {
		return false;
	}

	if (!question.expectationQ || question.expectationQ.length < 20) {
		return false;
	}

	var tagsArray = question.tags.split(",").filter((tag) => tag.trim() !== ""); // Remove empty tags
	if (tagsArray.length > 5) {
		return false; // Return false if more than 5 tags
	}

	if (!question.title || !question.category) {
		return false;
	}

	return question;
}

// Document ready function
$(document).ready(function () {
	app.appRouter = new app.routers.AppRouter();  // Initialize app router
	$(function () {
		Backbone.history.start();     // Start Backbone history
	});
});
