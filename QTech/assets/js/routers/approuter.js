var app = app || {};

// Define Backbone router for the application
app.routers.AppRouter = Backbone.Router.extend({

	// Define routes and corresponding methods
	routes: {
		"": "login",
		"login_page/home": "home",
		"home/askquestion": "askquestion",
		"home/answerquestion/:questionid": "answerquestion",
		"home/bookmark/:userid": "bookmark",
		"home/user/:userid": "user",
		"logout": "logout"
	},
	

	// Define the method for the login route
	login: function () {
		console.log("login route");

		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));

		// If no user is found in localStorage
		if(userJson == null){
			console.log("if");
			// Check if loginView is not already defined
			if(!app.loginView) {
				// Create a new user model
				app.user = new app.models.User();
				// Create and render login view with the user model
				app.loginView = new app.views.LoginFormView({ model: app.user });
				app.loginView.render();
			}
		}else {
			// If user is found, navigate to the home route
			this.home();
		}

	},
	

	// Define the method for the user route
	user: function (userid){
		console.log("user route");
		console.log("userid: "+ userid);

		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));

		// If user is found in localStorage
		if(userJson != null) {
			// Create a new user model with user details
			app.user = new app.models.User(userJson);
			console.log("if");

			// Create and render user view with a new user model
			app.userView = new app.views.UserView({model: new app.models.User()});
			app.userView.render();

		}

	},


	// Define the method for the bookmark route
	bookmark: function(userid){
		console.log("bookmark route");

		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));
		$userid = userJson.user_id;
		console.log("user"+userJson);

		// If user is found in localStorage
		if(userJson != null){

			// Create a new user model with user details
			app.user = new app.models.User(userJson);
			console.log("if");

			// Define the URL for fetching bookmarked questions
			var url = app.user.urlAskQuestion + "bookmarkQuestions/"+$userid;
			console.log("url: "+ url);

			// Create and render bookmark view with a new question collection
			app.bookmarkView = new app.views.bookmarkView({collection: new app.collections.QuestionCollection()});

			// Fetch bookmarked questions from the server
			app.bookmarkView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){
					console.log("response: "+ response);
					app.bookmarkView.render();
				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						app.bookmarkView.render();
					}
					console.log("error");
				}
			});
		}else {
			// If user is not found, navigate to the login route
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},


	// Define the method for the home route
	home: function(){
		console.log("home route");

		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));
		console.log(userJson);

		// If user is found in localStorage
		if (userJson != null){

			// Create a new user model with user details
			app.user = new app.models.User(userJson);
			console.log("user: "+ app.user);

			// Create and render home view with a new question collection
			app.homeView = new app.views.homeView({collection: new app.collections.QuestionCollection()});

			// Define the URL for fetching all questions
			var url = app.homeView.collection.url + "displayAllQuestions";
			app.homeView.collection.fetch({
				reset: true,
				"url": url,
				success: function(collection, response){
					console.log("response: "+ response);

					app.homeView.render();
				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						app.homeView.render();
					}
				}
			});
		} else {
			// If user is not found, navigate to the login route
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},


	// Define the method for the ask question route
	askquestion: function (){
		console.log("askQuestion route");

		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));
		console.log("user"+userJson);

		// If user is found in localStorage
		if(userJson != null){

			// Create a new user model with user details
			app.user = new app.models.User(userJson);
			console.log("if");

			// Create and render ask question view with the user model
			app.askQuestionView = new app.views.AddQuestionView({model: app.user});
			app.askQuestionView.render();
		}else {
			// If user is not found, navigate to the login route
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},


	// Define the method for the answer question route
	answerquestion:function (questionid){
		console.log("answerQuestion route : "+ questionid);

		// Retrieve user details from localStorage
		userJson = JSON.parse(localStorage.getItem("user"));
		$user_id = userJson.user_id;
		console.log("user"+userJson);

		// If user is found in localStorage
		if(userJson != null){

			// Create a new user model with user details
			app.user = new app.models.User(userJson);

			// Define the URL for fetching the question details
			var url = app.user.urlAskQuestion + "displayAllQuestions/" + questionid;

			// Fetch question details from the server
			app.user.fetch({
				"url": url,
				success: function(model, responseQ){
					console.log("sucess");
					responseQ['username'] = app.user.get("username");
					var questionModel = new app.models.Questions(responseQ);

					// Define the URL for checking if the question is bookmarked
					var urlBookmark = app.user.urlAskQuestion + "getBookmark";
					console.log("urlBookmark: "+ urlBookmark);

					// Send AJAX request to check if the question is bookmarked
					$.ajax({
						url: urlBookmark,
						type: "POST",
						data: {
							"questionid": questionid,
							"userid": $user_id
						},
						success: function(responseB){
							console.log("response: "+ responseB.is_bookmark);
							// Set bookmark status on the question model
							if(responseB.is_bookmark){
								questionModel.set("is_bookmark", true);
								console.log("true bookmarked");
								app.ansQuestionView = new app.views.AnswerQuestionView({
									model: questionModel,
									collection: new app.collections.AnswerCollection(),
									bookmark: true
								});
							}else {
								questionModel.set("is_bookmark", false);
								console.log("false bookmarked");
								app.ansQuestionView = new app.views.AnswerQuestionView({
									model: questionModel,
									collection: new app.collections.AnswerCollection(),
									bookmark: false
								});
							}

							// Define the URL for fetching answers to the question
							var answerUrl = app.ansQuestionView.collection.url + "getAnswers/" + questionid;

							// Fetch answers to the question from the server
							app.ansQuestionView.collection.fetch({
								reset: true,
								"url": answerUrl,
								success: function (collection, response) {
									console.log("response: " + response);
									app.ansQuestionView.render();
								},
								error: function (model, xhr, options) {
									if (xhr.status == 404) {
										console.log("error 404");
									}
									console.log("error");
								}
							});
						},
						error: function(model, xhr, options){
							if(xhr.status == 404){
								console.log("error 404");
							}
							console.log("error");
						}
					});

				},
				error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
					}
					console.log("error");
				}
			})

		}else {
			// If user is not found, navigate to the login route
			app.appRouter.navigate("", {trigger: true});
			console.log("else")
		}
	},


	// Define the method for the logout route
	logout: function(){
		console.log("logout route");

		// Clear localStorage
		localStorage.clear();

		// Define the URL for logging out
		var url = app.user.url + "logout";

		// Send AJAX request to log out
		$.ajax({
			url: url,
			type: "POST",
			success: function (response) {
				// Redirect to the login page after logout
				window.location.href = "http://localhost/QTech/index.php/user/login_page";

			},

			error: function(model, xhr, options){
				if(xhr.status == 404){
					console.log("error 404");
				}
				console.log("error");
			}
		});

	}
});
