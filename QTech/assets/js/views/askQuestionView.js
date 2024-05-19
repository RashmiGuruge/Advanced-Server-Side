var app = app || {};

// Define Backbone view for adding a question
app.views.AddQuestionView = Backbone.View.extend({

	el: ".container",

	render: function () {

		// Log message indicating rendering of the add question view
		console.log("rendering add question view");

		// Get the template for adding a question
		template = _.template($("#add_question_template").html());

		// Log model attributes for debugging
		console.log("model attributes:", this.model.attributes);

		// Render the template with model attributes to the element
		this.$el.html(template(this.model.attributes));

		// Create and render the navigation bar view
		app.navView = new app.views.NavBarView({ model: app.user });
		app.navView.render();

	},

	// Events and their corresponding handler methods
	events: {
		"click #submit_question": "submitquestion",
		"click #homesearch": "home_search",
	},

	// Handler method for submitting a question
	submitquestion: function (e) {

		e.preventDefault();
		e.stopPropagation();

		// Validate the question form
		var validateQuestionForm = validateQuestionAddForm();

		// If form is not valid, show error message
		if (!validateQuestionForm) {
			new Noty({
				type: "error",
				text: "Please check if the requirements are satisfied or not",
				timeout: 2000,
			}).show();
		} else {
			// If form is valid, proceed to submit the question
			var formData = new FormData();
			var imageFile = $("#imageUpload")[0].files[0];
			formData.append("image", imageFile);

			$.ajax({
				url: this.model.url + "ask_question_image",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: (response) => {
					console.log("Image uploaded successfully:", response);
					validateQuestionForm.questionimage = response.imagePath; // Assuming the server returns the image path
					this.model.set(validateQuestionForm);
					var url = this.model.urlAskQuestion + "addquestion";
					console.log("url", url);
					this.model.save(this.model.attributes, {
						url: url,
						success: (model, response) => {
							console.log("success", model, response);
							new Noty({
								type: "success",
								text: "Question added successfully",
								timeout: 2000,
							}).show();

							// Update user's ask question count in local storage
							$userJson = JSON.parse(localStorage.getItem("user"));
							console.log("userJson: ", $userJson);
							$userJson["askquestioncnt"] =
								parseInt($userJson["askquestioncnt"]) + 1;

							localStorage.setItem("user", JSON.stringify($userJson));

							// Reset form fields after successful submission
							$("#inputQuestionTitle").val("");
							$("#inputQuestionDetails").val("");
							$("#inputQuestionExpectation").val("");
							$("#inputQuestionTags").val("");
							$("#questionCategory").val("");
							$("#imageUpload").val("");
						},
						error: (model, response) => {
							console.log("error", model, response);
							new Noty({
								type: "error",
								text: "Error adding question",
								timeout: 2000,
							}).show();
						},
					});
				},
				error: (xhr, status, error) => {
					console.error("Error uploading image:", error);
					new Noty({
						type: "error",
						text: "Error uploading image",
						timeout: 2000,
					}).show();
				},
			});
		}
	},

	// Handler method for searching from the home view
	home_search: function (e) {

		e.preventDefault();
		e.stopPropagation();

		// Validate the search form
		var validateAnswer = validateSearchForm();

		// Get the search word
		var searchWord = $("#searchHome").val();

		// Check if search word is not empty
		if (searchWord != "") {
			console.log("searching");

			// Create user model
			app.user = new app.models.User(userJson);
			console.log("user: " + app.user);

			// Create and render the home view
			app.homeView = new app.views.homeView({
				collection: new app.collections.QuestionCollection(),
			});

			// Construct the URL for fetching search questions
			var url =
				app.homeView.collection.url + "displaySearchQuestions/" + searchWord;
			console.log("url: " + url);

			app.homeView.collection.fetch({
				reset: true,
				url: url,
				success: function (collection, response) {
					console.log("response: " + response);
					app.homeView.render();
				},
				error: function (model, xhr, options) {
					if (xhr.status == 404) {
						app.homeView.render();
					}
				},
			});
		} else {
			app.user = new app.models.User(userJson);
			console.log("user: " + app.user);
			app.homeView = new app.views.homeView({
				collection: new app.collections.QuestionCollection(),
			});

			var url = app.homeView.collection.url + "displayAllQuestions";
			app.homeView.collection.fetch({
				reset: true,
				url: url,
				success: function (collection, response) {
					console.log("response: " + response);
					app.homeView.render();
				},
				error: function (model, xhr, options) {
					if (xhr.status == 404) {
						app.homeView.render();
					}
				},
			});
		}
	},
});
