var app = app || {};

// Define Backbone view for answering questions
app.views.AnswerQuestionView = Backbone.View.extend({

	// Set the element where this view will be rendered
	el: ".container",

	// Render method to render the view
	render: function () {
		console.log("rendering answer question view");
		console.log("app.attribute: ", this.model.attributes);  // Log the model attributes for debugging
		template = _.template($("#answer-question-template").html()); // Get the template for answer question view
		this.$el.html(template(this.model.attributes)); // Render the template with model attributes and set HTML content

		// Render the navigation bar
		app.navView = new app.views.NavBarView({ model: app.user });
		app.navView.render();

		// Iterate through each answer model and render the answer view
		this.collection.each(function (answer) {
			var answerView = new app.views.AnswerView({ model: answer });
			answerView.render();
		});
	},


	// Define event bindings for this view
	events: {
		"click #submit_answer": "submitAnswer",
		"click #up-qviewcount": "upQuestionView",
		"click #down-qviewcount": "downQuestionView",
		"click #remove-bookmark": "removeBookmark",
		"click #add-bookmark": "addBookmark",
	},


	// Function to add bookmark
	addBookmark: function () {
		console.log("addBookmark");

		// Get the current URL
		var currentUrl = window.location.href;

		// Extract the question ID from the URL
		var lastPart = currentUrl.substring(currentUrl.lastIndexOf("/") + 1);
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);

		console.log("questionid form web: " + $questionid);

		// Get user ID from local storage
		$userJson = JSON.parse(localStorage.getItem("user"));
		$userid = $userJson["user_id"];

		console.log("userid: ", $userid);

		// Get the bookmark icon element
		var $bookmarkIcon = $("#add-bookmark");

		console.log("questionid: ", $questionid);
		console.log("userid: ", $userid);

		// Create bookmark object with question ID and user ID
		var rBookmark = {
			questionid: $questionid,
			userid: $userid,
		};

		// Define URL for adding bookmark
		var url = this.model.url + "add_bookmark";

		// Initialize count variable
		count = 0;
		console.log("count: " + count);
		if (count == 0) {
			console.log("count 62: " + count);
			let notificationShowing = false;

			// Send AJAX request to add bookmark
			$.ajax({
				url: url,
				type: "POST",
				data: rBookmark,
				success: (response) => {
					// Reset bookmark data and update UI
					rBookmark["questionid"] = "";
					rBookmark["userid"] = "";
					console.log("questionid: " + rBookmark["questionid"]);
					console.log("bookmark add");
					$bookmarkIcon.removeClass("fa-regular").addClass("fa-solid"); // Change icon to solid
					$bookmarkIcon.attr("id", "remove-bookmark");
					if (!notificationShowing) {
						// Show success notification
						new Noty({
							type: "success",
							text: "Bookmark add",
							timeout: 2000,
							callbacks: {
								afterClose: function () {
									notificationShowing = false; // Reset the flag after the notification is closed
								},
							},
						}).show();
						notificationShowing = true; // Set the flag to true when the notification is shown
					}
					count++;
					console.log("count 81: " + count);
				},
				error: (xhr, status, error) => {
					// Show error notification
					console.error("Error adding bookmark:", error);
					new Noty({
						type: "error",
						text: "Error adding bookmark",
						timeout: 2000,
					}).show();
				},
			});
		}
	},


	// Function to remove bookmark
	removeBookmark: function () {
		console.log("removeBook");

		var currentUrl = window.location.href;

		var lastPart = currentUrl.substring(currentUrl.lastIndexOf("/") + 1);
		var $questionid = parseInt(lastPart.match(/\d+$/)[0]);

		console.log("questionid form web: " + $questionid);

		$userJson = JSON.parse(localStorage.getItem("user"));
		$userid = $userJson["user_id"];

		var $bookmarkIcon = $("#remove-bookmark");

		console.log("questionid: ", $questionid);
		console.log("userid: ", $userid);

		var rBookmark = {
			questionid: $questionid,
			userid: $userid,
		};

		var url = this.model.url + "remove_bookmark";

		if ($questionid != "" && $questionid != null) {
			app.user.fetch({
				url: url,
				type: "POST",
				data: rBookmark,
				success: (response) => {
					rBookmark["questionid"] = "";
					rBookmark["userid"] = "";
					console.log("bookmark removed");
					$bookmarkIcon.removeClass("fa-solid").addClass("fa-regular"); // Change icon to regular
					$bookmarkIcon.attr("id", "add-bookmark");
					new Noty({
						type: "warning",
						text: "Bookmark removed",
						timeout: 2000,
					}).show();
				},
				error: (xhr, status, error) => {
					console.error("Error removing bookmark:", error);
					new Noty({
						type: "error",
						text: "Error removing bookmark",
						timeout: 2000,
					}).show();
				},
			});
		}
	},


	// Function to handle upvoting of question view
	upQuestionView: function () {
		if ($(this).data("clicked")) {
			console.log("Button already clicked.");
			return;
		}

		userJson = JSON.parse(localStorage.getItem("user"));

		$questionid = this.model.attributes.questionid;

		var url = this.model.url + "upvote/" + $questionid;

		if ($questionid != "" && $questionid != null) {
			app.user.fetch({
				url: url,
				type: "GET",
				success: (response) => {
					console.log("upvoted");

					var currentViewStatus = parseInt($("#question-view-count").text());
					$("#question-view-count").text(currentViewStatus + 1);

					this.$el
						.find("#up-qviewcount")
						.data("clicked", true)
						.css("pointer-events", "none");
				},
				error: (xhr, status, error) => {
					console.error("Error upvoting:", error);
					new Noty({
						type: "error",
						text: "Error upvoting",
						timeout: 2000,
					}).show();
				},
			});
		} else {
			new Noty({
				type: "error",
				text: "Error in upvoting",
				timeout: 2000,
			}).show();
		}
	},


	// Function to handle downvoting of question view
	downQuestionView: function () {
		console.log("downQuestionView");

		if ($(this).data("clicked")) {
			console.log("Button already clicked.");
			return;
		}

		userJson = JSON.parse(localStorage.getItem("user"));

		$questionid = this.model.attributes.questionid;

		var url = this.model.url + "downvote/" + $questionid;

		if ($questionid != "" && $questionid != null) {
			app.user.fetch({
				url: url,
				type: "GET",
				success: (response) => {
					console.log("downvote");

					var currentViewStatus = parseInt($("#question-view-count").text());
					$("#question-view-count").text(currentViewStatus - 1);

					this.$el
						.find("#down-qviewcount")
						.data("clicked", true)
						.css("pointer-events", "none");
				},
				error: (xhr, status, error) => {
					console.error("Error downvote:", error);
					new Noty({
						type: "error",
						text: "Error downvote",
						timeout: 2000,
					}).show();
				},
			});
		} else {
			new Noty({
				type: "error",
				text: "Error in downvot",
				timeout: 2000,
			}).show();
		}
	},


	// Function to submit an answer
	submitAnswer: function (e) {
		e.preventDefault();
		e.stopPropagation();

		console.log("submitting answer");

		var validateAnswer = validateAnswerForm();

		if (validateAnswer) {
			console.log("answer is valid");
			var formData = new FormData();
			var imageFIle = $("#answerImageUpload")[0].files[0];
			formData.append("image", imageFIle);
			console.log(this.model.urlAns);

			$.ajax({
				url: this.model.urlAns + "ans_image",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: (response) => {
					console.log("image uploaded", response);
					validateAnswer.answerimage = response.imagePath;
					this.model.set(validateAnswer);

					$questionid = this.model.attributes.questionid;
					console.log("questionid: ", $questionid);

					console.log("model asda: ", this.model.attributes);
					var url = this.model.urlAns + "add_answer";
					this.model.save(this.model.attributes, {
						url: url,
						success: (model, response) => {
							console.log("answer submitted");
							new Noty({
								type: "success",
								text: "Answer submitted successfully",
								timeout: 2000,
							}).show();

							$userJson = JSON.parse(localStorage.getItem("user"));
							console.log("userJson: ", $userJson);
							$userJson["answerquestioncnt"] =
								parseInt($userJson["answerquestioncnt"]) + 1;

							localStorage.setItem("user", JSON.stringify($userJson));

							this.collection.add(model);
							console.log("model: ", model);
							// Create and render a new view for the added answer
							var newAnswerView = new app.views.AnswerView({ model: model });
							newAnswerView.render();
						},
						error: (model, response) => {
							console.log("error in submitting answer");
							new Noty({
								type: "error",
								text: "Error in submitting answer",
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

			$("#inputQuestionDetails").val("");
			$("#answerImageUpload").val("");
			$("#questionrate").val("");
		} else {
			setTimeout(function () {
				new Noty({
					type: "error",
					text: "Please check if the requirements are satisfied or not",
					timeout: 2000,
				}).show();
				console.log("answer is not valid");
			}, 1500);
		}
	},
	
});
