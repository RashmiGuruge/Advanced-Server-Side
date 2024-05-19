var app = app || {};

// Define the NavBarView as a Backbone View
app.views.NavBarView = Backbone.View.extend({

	// Define the target element for the view
	el: '#main-header-div',

	// Render function to render the view
	render: function(){
		
		template = _.template($('#navigation-bar-template').html());   // Compile the template using Underscore.js template function
		this.$el.html(template(this.model.attributes));                // Insert the compiled template into the view's element
		console.log("nav bar attributes: ",this.model.attributes);     // Log the attributes of the model to the console
		console.log('rendering nav bar');                              // Log a message indicating that the navigation bar is being rendered
	}

});
