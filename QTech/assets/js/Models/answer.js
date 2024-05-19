var app = app || {};

// Define a Backbone model for an answer
app.models.Answers = Backbone.Model.extend({

	// Set the base URL for the model's RESTful API endpoint
	urlRoot: "/QTech/index.php/api/Answer/",

	// Define default attributes for the model
	defaults: {
		answerid: null,               // ID of the answer
		questionid: null,             // ID of the question this answer belongs to
		userid: null,                 // ID of the user who posted the answer
		answer: null,                 // The text of the answer
		answerimage: null,            // URL or path to an image associated with the answer
		answerrate: null,             // Rating of the answer
		rate: null,                   // Another possible rating field
		questionrate: null,           // Rating of the question (might be used in some contexts)
		viewstatus: null,             // Status indicating if the answer has been viewed
		answeraddeddate: null,        // Date when the answer was added
	},

	// URL for the model's API endpoint, which will be used for fetch, save, etc.
	url: "/QTech/index.php/api/Answer/",

});

// Define a Backbone collection for answers
app.collections.AnswerCollection = Backbone.Collection.extend({

	// Specify the model that the collection contains
	model: app.models.Answers,

	// Set the base URL for the collection's RESTful API endpoint
	url: "/QTech/index.php/api/Answer/",
});
