var app = app || {};

// Define the homeView as a Backbone View
app.views.homeView = Backbone.View.extend({
	// Define the target element for the view
	el: ".container",

	// Render function to render the view
	render: function () {
		console.log("rendering home view"); // Log a message indicating that the home view is being rendered
		var template = _.template($("#home_template").html()); // Compile the template using Underscore.js template function
		this.$el.html(template(app.user.attributes)); // Insert the compiled template into the view's element, passing user attributes

		// Render the navigation bar
		app.navView = new app.views.NavBarView({ model: app.user });
		app.navView.render();

		// Loop through each question in the collection and render its view
		this.collection.each(function (question) {
			var questionView = new app.views.QuestionView({ model: question });
			questionView.render();
		});
	},

	// Define event bindings for the view
	events: {
		"click #ask_question_btn": "ask_question",
		"click #homesearch": "home_search",
	},

	// Function to handle the "ask_question" event
	ask_question: function (e) {
		e.preventDefault();
		e.stopPropagation();

		console.log("ask question"); // Log a message indicating that a question is being asked
		app.appRouter.navigate("home/askquestion", { trigger: true }); // Navigate to the "askquestion" route
	},

	// Function to handle the "home_search" event
	home_search: function (e) {
		e.preventDefault();
		e.stopPropagation();

		// Validate the search form
		var validateAnswer = validateSearchForm();

		var searchWord = $("#searchHome").val();

		// Check if search word is not empty
		if (searchWord != "") {
			// Log a message indicating that searching is initiated
			console.log("searching");

			// Set up user model
			app.user = new app.models.User(userJson);
			console.log("user: " + app.user);

			// Initialize homeView with a new collection
			app.homeView = new app.views.homeView({
				collection: new app.collections.QuestionCollection(),
			});

			// Set up URL for fetching search questions
			var url =
				app.homeView.collection.url + "displaySearchQuestions/" + searchWord;
			console.log("url: " + url);

			// Fetch search questions from the server
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
			// Set up user model
			app.user = new app.models.User(userJson);
			console.log("user: " + app.user);

			// Initialize homeView with a new collection
			app.homeView = new app.views.homeView({
				collection: new app.collections.QuestionCollection(),
			});

			// Set up URL for fetching all questions
			var url = app.homeView.collection.url + "displayAllQuestions";

			// Fetch all questions from the server
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
