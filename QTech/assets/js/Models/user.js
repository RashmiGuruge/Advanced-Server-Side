var app = app || {};

// Define a Backbone model for a user
app.models.User = Backbone.Model.extend({

	// Set the base URL for the model's RESTful API endpoint
	urlRoot: "/QTech/index.php/api/User/",

	// Define default attributes for the model
	defaults: {
		name: "",
		email: "",
		username: "",
		password: "",
		user_id: null,
		occupation: "",
		premium: false,
		userimage: "",
		answerquestioncnt: null,
		askquestioncnt: null,
	},

	// URL for the model's API endpoint, which will be used for fetch, save, etc.
	url: "/QTech/index.php/api/User/",

	// Additional URLs for handling specific user-related actions
	urlAskQuestion: "/QTech/index.php/api/Question/",    // URL for asking questions
	urlAnswerQuestion: "/QTech/index.php/api/Answer/",   // URL for answering questions
});
