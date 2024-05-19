<?php

/**
 * The QuestionModel class handles database operations related to questions.
 */
class QuestionModel extends CI_Model
{


	/**
	 * Retrieves all questions from the database.
	 *
	 * @return array|stdClass An array of question objects if questions exist, otherwise an empty stdClass object.
	 */
	public function getAllQuestions()
	{

		log_message('debug', 'getAllQuestions() called');

		// Retrieve all questions from the 'Questions' table
		$question = $this->db->get("Questions");

		// Check if questions exist
		if ($question->num_rows() > 0) {

			// Convert the result to an array of objects
			$question_array = $question->result();

			// Iterate through each question
			foreach ($question_array as $question) {
				// Retrieve tags for the current question
				$question_id = $question->questionid;
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question_id)
					->get();
				$tags = $tag_query->result();
				$question->tags = array_column($tags, 'tags');
			}
			return $question_array;
		} else {
			// No questions found, return an empty stdClass object
			return new stdClass();
		}
	}


	/**
	 * Retrieves a specific question from the database.
	 *
	 * @param int $question_id The ID of the question to retrieve.
	 * @return object|null The question object if found, otherwise null.
	 */
	public function getQuestion($question_id)
	{

		// Retrieve the question from the 'Questions' table based on the question ID
		$question = $this->db->get_where("Questions", array('questionid' => $question_id))->row();

		if ($question) {
			$tag_query = $this->db->select('tags')
				->from('Tags')
				->where('questionid', $question->questionid)
				->get();
			$tags = $tag_query->result();
			$question->tags = array_column($tags, 'tags');

			return $question;
		} else {
			return null; // Return null if no question found
		}
	}


	/**
	 * Retrieves questions based on a search word.
	 *
	 * @param string $searchWord The word to search for in titles, questions, and tags.
	 * @return array|stdClass An array of question objects if matching questions exist, otherwise an empty stdClass object.
	 */
	public function getSearchQuestions($searchWord)
	{

		// Search for the word in titles, questions, and tags
		$this->db->like('title', $searchWord);
		$this->db->or_like('question', $searchWord);
		$this->db->join('Tags', 'Questions.questionid = Tags.questionid', 'left');
		$this->db->or_like('tags', $searchWord);
		$question = $this->db->get("Questions");

		if ($question->num_rows() > 0) {
			$question_array = $question->result();
			foreach ($question_array as $question) {
				$question_id = $question->questionid;
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question_id)
					->get();
				$tags = $tag_query->result();
				$question->tags = array_column($tags, 'tags');
			}
			return $question_array;
		} else {
			return new stdClass();
		}
	}


	/**
	 * Adds a new question to the database.
	 *
	 * @param int $userid The ID of the user asking the question.
	 * @param string $title The title of the question.
	 * @param string $question The content of the question.
	 * @param string $expectationQ The user's expectations related to the question.
	 * @param string $category The category of the question.
	 * @param string $qaddeddate The date when the question was added.
	 * @param array $tagArray An array of tags associated with the question.
	 * @param string $imageurl The URL of an image attached to the question.
	 * @return bool True if the question was successfully added, otherwise false.
	 */
	public function addQuestion($userid, $title, $question, $expectationQ, $category, $qaddeddate, $tagArray, $imageurl)
	{

		// Start transaction
		$this->db->trans_start(); // Start transaction

		// Prepare question data
		$questionData = array(
			'userid' => $userid,
			'title' => $title,
			'question' => $question,
			'expectationQ' => $expectationQ,
			'questionimage' => $imageurl, // Ensure that the questionimage field is correctly set here
			'category' => $category,
			'qaddeddate' => $qaddeddate,
		);

		// Insert into 'Questions' table
		$insertDetails = $this->db->insert('Questions', $questionData);

		// Check if the insertion was successful
		if ($insertDetails) {

			// Get the last inserted question ID
			$questionId = $this->db->insert_id();

			// Insert into 'Tags' table
			foreach ($tagArray as $tag) {
				$tagData = array(
					'questionid' => $questionId, // Use the retrieved question ID
					'tags' => trim($tag)
				);
				$this->db->insert('Tags', $tagData);
			}
		}

		// If insertion was successful, update user's ask question count
		if ($insertDetails) {
			$pastaskquestioncnt = $this->db->select('askquestioncnt')
				->from('Users')
				->where('user_id', $userid)
				->get()
				->row(); // Fetch the result as a single row

			$askquestioncnt = $pastaskquestioncnt->askquestioncnt + 1;

			$this->db->where('user_id', $userid)
				->update('Users', array('askquestioncnt' => $askquestioncnt));
		}

		// Complete transaction
		$this->db->trans_complete();

		// Return whether the question was successfully added and the transaction status
		return $insertDetails && $this->db->trans_status(); // Return transaction status
	}


	/**
	 * Increments the view status (upvote) of a question.
	 *
	 * @param int $questionid The ID of the question to upvote.
	 * @return bool True if the upvote was successful, otherwise false.
	 */
	public function upvote($questionid)
	{

		// Retrieve current view status (upvote) of the question
		$currentViewStatus = $this->db->select('viewstatus')
			->from('Questions')
			->where('questionid', $questionid)
			->get()
			->row()
			->viewstatus;

		// Calculate new view status
		$newViewStatus = $currentViewStatus + 1;

		// Update view status in the 'Questions' table
		$updateViewStatus = $this->db->where('questionid', $questionid)
			->update('Questions', array('viewstatus' => $newViewStatus));

		// Return whether the upvote was successful
		return $updateViewStatus;
	}


	/**
	 * Decrements the view status (downvote) of a question.
	 *
	 * @param int $questionid The ID of the question to downvote.
	 * @return bool True if the downvote was successful, otherwise false.
	 */
	public function downvote($questionid)
	{

		// Retrieve current view status (downvote) of the question
		$currentViewStatus = $this->db->select('viewstatus')
			->from('Questions')
			->where('questionid', $questionid)
			->get()
			->row()
			->viewstatus;

		// Calculate new view status
		$newViewStatus = $currentViewStatus - 1;

		// Update view status in the 'Questions' table
		$updateViewStatus = $this->db->where('questionid', $questionid)
			->update('Questions', array('viewstatus' => $newViewStatus));

		// Return whether the downvote was successful
		return $updateViewStatus;
	}


	/**
	 * Checks if a question is bookmarked by a user.
	 *
	 * @param int $questionid The ID of the question to check for bookmark.
	 * @param int $userid The ID of the user who may have bookmarked the question.
	 * @return bool True if the question is bookmarked by the user, otherwise false.
	 */
	public function getBookmark($questionid, $userid)
	{
		// Check if the combination of questionid and userid exists in the 'BookmarkQue' table
		$bookmark = $this->db->get_where("BookmarkQue", array('questionid' => $questionid, 'userid' => $userid));
		if ($bookmark->num_rows() > 0) {

			return TRUE;
		} else {
			return FALSE;
		}
	}


	/**
	 * Removes a bookmark for a question by a user.
	 *
	 * @param int $questionid The ID of the question from which to remove the bookmark.
	 * @param int $userid The ID of the user who wants to remove the bookmark.
	 * @return bool True if the bookmark was successfully removed, otherwise false.
	 */
	public function removeBookmark($questionid, $userid)
	{
		// Remove the bookmark from the 'BookmarkQue' table
		$bookmark = $this->db->delete("BookmarkQue", array('questionid' => $questionid, 'userid' => $userid));

		// Return whether the bookmark was successfully removed
		return $bookmark;
	}


	/**
	 * Adds a bookmark for a question by a user.
	 *
	 * @param int $questionid The ID of the question to bookmark.
	 * @param int $userid The ID of the user who wants to bookmark the question.
	 * @return bool True if the bookmark was successfully added, otherwise false.
	 */
	public function addBookmark($questionid, $userid)
	{
		// Check if the combination of questionid and userid already exists in the database
		$this->db->where('questionid', $questionid);
		$this->db->where('userid', $userid);
		$existingBookmark = $this->db->get('BookmarkQue')->row();

		// If the combination already exists, return false to indicate that the bookmark was not added
		if ($existingBookmark) {
			return false;
		}

		// If the combination does not exist, add the new bookmark to the database
		$bookmarkData = array(
			'questionid' => $questionid,
			'userid' => $userid
		);
		$bookmark = $this->db->insert('BookmarkQue', $bookmarkData);

		// Return true to indicate that the bookmark was successfully added
		return $bookmark;
	}


	/**
	 * Retrieves bookmarked questions for a user.
	 *
	 * @param int $userid The ID of the user for whom to retrieve bookmarked questions.
	 * @return array|stdClass An array of bookmarked question objects if any, otherwise an empty stdClass object.
	 */
	public function getBookmarkQuestions($userid)
	{
		// Select questions from the 'Questions' table that are bookmarked by the user
		$this->db->select('Questions.*');
		$this->db->from('Questions');
		$this->db->join('BookmarkQue', 'Questions.questionid = BookmarkQue.questionid');
		$this->db->where('BookmarkQue.userid', $userid);
		$question = $this->db->get();

		// Check if bookmarked questions exist
		if ($question->num_rows() > 0) {

			// Convert the result to an array of objects
			$question_array = $question->result();

			// Iterate through each question
			foreach ($question_array as $question) {

				// Retrieve tags for the current question
				$question_id = $question->questionid;
				$tag_query = $this->db->select('tags')
					->from('Tags')
					->where('questionid', $question_id)
					->get();
				$tags = $tag_query->result();
				$question->tags = array_column($tags, 'tags');
			}
			return $question_array;
		} else {
			// No bookmarked questions found, return an empty stdClass object
			return new stdClass();
		}
	}
}
