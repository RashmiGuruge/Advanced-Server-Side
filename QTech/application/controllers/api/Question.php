<?php

// Import the REST_Controller library
use Restserver\Libraries\REST_Controller;

// Require the REST_Controller.php file
require APPPATH . 'libraries/REST_Controller.php';


// Define the Question class that extends REST_Controller
class Question extends REST_Controller{


	// Constructor method
	public function __construct(){
		parent::__construct();
		// Load the QuestionModel
		$this->load->model('QuestionModel');
	}


	// Method to display all questions or a specific question
	public function displayAllQuestions_get($question_id = FALSE){

		// Log the question ID
		log_message('debug', 'Question::displayAllQuestions_get() - $question_id: ' . $question_id);

		// Check if a specific question ID is provided
		if ($question_id === FALSE) {
			// Get all questions
			$questions = $this->QuestionModel->getAllQuestions();
		} else {
			// Get a specific question
			$questions = $this->QuestionModel->getQuestion($question_id);
		}

		// Check if the user data exists
		if (!empty($questions)) {
			// Return questions with HTTP status code 200 (OK)
			$this->response($questions, REST_Controller::HTTP_OK);
		} else {
			// Return error message with HTTP status code 404 (Not Found)
			$this->response(array(
				'status' => FALSE,
				'message' => 'No questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}

	}


	// Method to get bookmarked questions for a user
	public function bookmarkQuestions_get($userid){

		// Get bookmarked questions for the user
		$questions = $this->QuestionModel->getBookmarkQuestions($userid);
		// Check if bookmarked questions exist
		if($questions) {
			// Return bookmarked questions with HTTP status code 200 (OK)
			$this->response($questions, REST_Controller::HTTP_OK);
		} else {
			// Return error message with HTTP status code 404 (Not Found)
			$this->response(array(
				'status' => FALSE,
				'message' => 'No bookmarked questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}

	}


	// Method to display search questions
	public function displaySearchQuestions_get($searchWord = FALSE){

		// Log the search word
		log_message('debug', 'Question::displaySearchQuestions_get() - $searchWord: ' . $searchWord);

		// Check if a search word is provided
		if ($searchWord === FALSE) {
			// Get all questions if no search word is provided
			$questions = $this->QuestionModel->getAllQuestions();
		} else {
			// Search for questions based on the provided search word
			$questions = $this->QuestionModel->getSearchQuestions($searchWord);
		}

		// Check if questions exist
		if (!empty($questions)) {
			// Return questions with HTTP status code 200 (OK)
			$this->response($questions, REST_Controller::HTTP_OK);
		} else {
			// Return error message with HTTP status code 404 (Not Found)
			$this->response(array(
				'status' => FALSE,
				'message' => 'No questions found.'
			), REST_Controller::HTTP_NOT_FOUND);
		}

	}


	// Method to upvote a question
	public function upvote_get($questionid){

		// Upvote the question
		$upvote = $this->QuestionModel->upvote($questionid);
		if($upvote) {
			// Return success message with HTTP status code 200 (OK)
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question upvoted successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			// Return error message with HTTP status code 400 (Bad Request)
			$this->response("Failed to upvote question.", REST_Controller::HTTP_BAD_REQUEST);
		}

	}


	// Method to downvote a question
	public function downvote_get($questionid){

		// Downvote the question
		$upvote = $this->QuestionModel->downvote($questionid);
		if($upvote) {
			// Return success message with HTTP status code 200 (OK)
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question downvoted successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			// Return error message with HTTP status code 400 (Bad Request)
			$this->response("Failed to downvote question.", REST_Controller::HTTP_BAD_REQUEST);
		}

	}
	

	// Method to add a new question
	public function addquestion_post() {

		// Decode JSON input
		$_POST = json_decode(file_get_contents("php://input"), true);

		// Set validation rules
		$this->form_validation->set_rules('title', 'checkTitle', 'required');
		$this->form_validation->set_rules('question', 'checkQuestion', 'required');
		$this->form_validation->set_rules('expectationQ', 'checkExpectationQ', 'required');
		$this->form_validation->set_rules('tags', 'checkTags', 'required');
		$this->form_validation->set_rules('category', 'checkCategory', 'required');
		$this->form_validation->set_rules('difficulty', 'checkDifficulty', 'required');

		// Extract data from the input
		$userid = strip_tags($this->post('user_id'));
		$title = strip_tags($this->post('title'));
		$question = $this->post('question');
		$expectationQ = $this->post('expectationQ');
		$tags = strip_tags($this->post('tags'));
		$category = strip_tags($this->post('category'));
		$qaddeddate = strip_tags($this->post('qaddeddate'));
		$imageurl = strip_tags($this->post('questionimage'));

		// Initialize questionimage variable
		$questionimage = '';

		// Check if an image file is uploaded
		if (!empty($_FILES['image']['name'])) {
			// Define upload directory and file name
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/QTech/assets/images/question/';
			$uploadFile = $uploadDir . basename($_FILES['image']['name']);

			// Attempt to move uploaded file to specified directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
				// File uploaded successfully, update image path
				$questionimage = $uploadFile;
			}
		}

		// Check if required data is not empty
		if (!empty($userid) && !empty($title) && !empty($question) && !empty($expectationQ) && !empty($tags) && !empty($category) && !empty($qaddeddate)) {
			$tagArray = explode(',', $tags);

			// Call the addQuestion method with the extracted data
			$result = $this->QuestionModel->addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray, $imageurl);
			
			// Check if the question is added successfully
			if ($result) {
				$this->response(array(
					'status' => TRUE,
					'message' => 'Question added successfully.'
				), REST_Controller::HTTP_OK);
			} else {
				$this->response("Failed to add question.", REST_Controller::HTTP_BAD_REQUEST);
			}
		}

	}


	// Method to get bookmark status of a question
	public function getBookmark_post(){

		// Extract question ID and user ID from input
		$questionid = $this->post('questionid');
		$userid = $this->post('userid');

		// Check if the question is bookmarked for the user
		$bookmark = $this->QuestionModel->getBookmark($questionid, $userid);
		if($bookmark) {
			$this->response(array(
				'is_bookmark' => TRUE,
				'status' => TRUE,
				'message' => 'Question bookmarked successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'is_bookmark' => FALSE,
				'status' => TRUE,
				'message' => 'Question bookmarked successfully.'
			), REST_Controller::HTTP_OK);
		}

	}


	// Method to remove a bookmark from a question
	public function remove_bookmark_post(){

		// Extract question ID and user ID from input
		$questionid = $this->post('questionid');
		$userid = $this->post('userid');

		// Remove bookmark from the question for the user
		$bookmark = $this->QuestionModel->removeBookmark($questionid, $userid);
		if($bookmark) {
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question removed from bookmark successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			$this->response("Failed to remove question from bookmark.", REST_Controller::HTTP_BAD_REQUEST);
		}

	}


	// Method to add a bookmark to a question
	public function add_bookmark_post(){

		// Extract question ID and user ID from input
		$questionid = $this->post('questionid');
		$userid = $this->post('userid');

		// Add bookmark to the question for the user
		$bookmark = $this->QuestionModel->addBookmark($questionid, $userid);
		if($bookmark) {
			$this->response(array(
				'status' => TRUE,
				'message' => 'Question added to the bookmark successfully.'
			), REST_Controller::HTTP_OK);
		} else {
			$this->response("Failed to add question to the bookmark.", REST_Controller::HTTP_BAD_REQUEST);
		}

	}

}
