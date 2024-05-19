<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype>
<html lang="en">

<head>
	<title>QTech</title>
	<?php include 'head.php'; ?>
</head>

<body style="background-color: #f7f3f98c;">

	<div class="container" style="margin-top: 160px; margin-bottom: 150px;"></div>

	<!-- Header -->
	<script type="text/template" id="navigation-bar-template">
		<?php include('header_after.php'); ?>
	</script>

	<!-- Home Page View -->
	<script type="text/template" id="home_template">
		<?php include('home_page.php'); ?>
	</script>

	<!-- Home Page - Question Container -->
	<script type="text/template" id="question_template">
		<?php include('home_page_question.php'); ?>
    </script>

	<!-- Ask Question Page View -->
	<script type="text/template" id="add_question_template">
		<?php include('askquestion_page.php'); ?>
	</script>

	<!-- Answer Question Page View -->
	<script type="text/template" id="answer-question-template">
		<?php include('answerquestion_page.php'); ?>
	</script>

	<!-- Answer Question Page - Answer Container -->
	<script type="text/template" id="answer-template">
		<div class="extra-answer-box">
		    <p> <%= answer %> </p>
		    <% if (answerimage !== '') { %>
		    <img class="pb-3" src="<%= answerimage %>" alt="Answer Image" style="max-width: 30rem; max-height: 30rem;">
		    <% } %>
		    <p> <strong>Added Date: </strong><%= answeraddeddate %></p>
	    </div>
	</script>

	<!-- Bookmark Page View -->
	<script type="text/template" id="bookmark_View">
		<?php include('bookmark_page.php'); ?>
	</script>

	<!-- User Profile Page View -->
	<script type="text/template" id="user_template">
		<?php include('user_profile_page.php'); ?>
	</script>

</body>

</html>