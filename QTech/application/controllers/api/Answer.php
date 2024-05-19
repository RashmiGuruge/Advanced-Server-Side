<?php

// Import the REST_Controller library
use Restserver\Libraries\REST_Controller;

// Require the REST_Controller.php file
require APPPATH . 'libraries/REST_Controller.php';


// Define the Answer class that extends REST_Controller
class Answer extends REST_Controller {


	// Constructor method
	public function __construct(){
		parent::__construct();
		// Load the AnswerModel
		$this->load->model('AnswerModel');
	}


	// Method to get answers for a specific question
	public function getAnswers_get($questionid){

		// Call the getAnswers method from the AnswerModel
		$answers = $this->AnswerModel->getAnswers($questionid);

		// Check if answers are not empty
		if (!empty($answers)) {
			// Return the answers with HTTP status code 200 (OK)
			$this->response($answers, REST_Controller::HTTP_OK);
		} else {
			// Return an empty array with HTTP status code 200 (OK)
			$this->response(array(), REST_Controller::HTTP_OK);
		}
	}


	// Method to handle the upload of an image associated with an answer
	public function ans_image_post(){

		// Check if file is uploaded and it's not empty
		if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
			// Define upload directory
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/QTech/assets/images/answer/';

			// Log the upload directory
			log_message('debug', 'uploadDir: ' . $uploadDir);

			// Set upload configuration
			$config['upload_path'] = $uploadDir;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 1024 * 10; // 10 MB

			// Load upload library
			$this->load->library('upload', $config);

			// Perform upload
			if ($this->upload->do_upload('image')) {
				// File uploaded successfully
				$uploadData = $this->upload->data();
				// Adjust imagePath relative to the URL structure
				$imagePath = '../../assets/images/answer/' . $uploadData['file_name'];

				// Return the image path with HTTP status code 200 (OK)
				$this->response(array('imagePath' => $imagePath), REST_Controller::HTTP_OK);
			} else {
				// Error uploading file
				$this->response(array('error' => $this->upload->display_errors()), REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			// No file uploaded, return a default image path or an empty response
			$this->response(array('imagePath' => ''), REST_Controller::HTTP_OK);
		}

	}


	// Method to add an answer to a question
	public function add_answer_post(){

		// Decode the JSON input
		$_POST = json_decode(file_get_contents("php://input"), true);

		// Extract data from the input
		$questionid = strip_tags($this->post('questionid'));
		$userid = strip_tags($this->post('userid'));
		$answer = $this->post('answer');
		$imageurl = strip_tags($this->post('answerimage'));
		$answeraddreddate = strip_tags($this->post('answeraddeddate'));
		$rate = strip_tags($this->post('rate'));

		// Initialize answerimage variable
		$answerimage = '';

		// Check if an image file is uploaded
		if (!empty($_FILES['image']['name'])) {
			// Define upload directory and file name
			$uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/QTech/assets/images/answer/';
			$uploadFile = $uploadDir . basename($_FILES['image']['name']);

			// Attempt to move uploaded file to specified directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
				// File uploaded successfully, update image path
				$answerimage = $uploadFile;
			}
		}

		// Check if required data is not empty
		if (!empty($questionid) && !empty($userid) && !empty($answer) && !empty($answeraddreddate)) {
			// Add the answer using the AnswerModel
			$result = $this->AnswerModel->addAnswer($questionid, $userid, $answer, $answeraddreddate, $imageurl, $rate);
			if ($result) {
				// Return success message with HTTP status code 200 (OK)
				$this->response(array(
					'status' => TRUE,
					'message' => 'Answer added successfully.'
				), REST_Controller::HTTP_OK);
			} else {
				// Return error message with HTTP status code 400 (Bad Request)
				$this->response("Failed to add answer.", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		
	}

}
