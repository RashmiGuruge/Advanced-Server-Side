var app = app || {};

// Define a Backbone model for a question
app.models.Questions = Backbone.Model.extend({

	// Set the base URL for the model's RESTful API endpoint
	urlRoot: "/QTech/index.php/api/Question/",

	// Define default attributes for the model
	defaults: {
		question: null,
		user_id: null,
		title: null,
		question: null,
		questionimage: null,
		category: null,
		tags: null,
		rate: null,
		answerrate: null,
		is_bookmark: null,
		viewstatus: null,
		qaddeddate: null,
		answeraddeddate: null,
	},

	// URL for the model's API endpoint, which will be used for fetch, save, etc.
	url: "/QTech/index.php/api/Question/",

	// Additional URL for handling answers related to this question
	urlAns: "/QTech/index.php/api/Answer/",

});

// Define a Backbone collection for questions
app.collections.QuestionCollection = Backbone.Collection.extend({
	// Specify the model that the collection contains
	model: app.models.Questions,
	// Set the base URL for the collection's RESTful API endpoint
	url: "/QTech/index.php/api/Question/",
});
