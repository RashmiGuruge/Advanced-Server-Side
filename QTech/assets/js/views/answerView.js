var app = app || {}

// Define Backbone view for individual answers
app.views.AnswerView = Backbone.View.extend({

	// Set the element where this view will be rendered
	el: '#answer',

	// Render method to render the view
	render: function(){

		// Get the template for individual answer view
		template = _.template($('#answer-template').html())

		// Check if the main page title is already appended
		if (this.$el.find('h1').length === 0) {
			this.$el.append('<h1 class="main_page_title pb-2">Answers</h1>');
			this.$el.css('display', 'block');
		}
		
		// Append the template with model attributes to the element
		this.$el.append(template(this.model.attributes));
	}

})
