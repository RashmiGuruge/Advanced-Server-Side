var app = app || {};

// Define Backbone view for bookmark view
app.views.bookmarkView = Backbone.View.extend({
	el: ".container",

	render: function(){
		// Log message indicating rendering of the bookmark view
		console.log("rendering bookmark view");

		// Get the template for bookmark view
		template = _.template($("#bookmark_View").html());

		// Log app user attributes for debugging
		console.log("app.user.attributes", app.user.attributes);

		// Render the template with app user attributes to the element
		this.$el.html(template(app.user.attributes));

		// Create and render the navigation bar view
		app.navView = new app.views.NavBarView({model: app.user});
		app.navView.render();

		// Iterate over each question in the collection and render its view
		this.collection.each(function(question){
			var questionView = new app.views.QuestionView({model: question});
			questionView.render();
		})
	}
})
