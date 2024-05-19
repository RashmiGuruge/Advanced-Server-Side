<?php

/**
 * The AnswerModel class handles database operations related to answers.
 */
class AnswerModel extends CI_Model
{


	/**
	 * Retrieves answers for a given question ID.
	 *
	 * @param int $questionid The ID of the question to retrieve answers for.
	 * @return array|null An array of answer objects if answers exist, otherwise null.
	 */
	public function getAnswers($questionid)
	{

		// Retrieve answers from the database based on the question ID
		$answer = $this->db->get_where("Answers", array('questionid' => $questionid));

		// Check if answers exist
		if ($answer->num_rows() > 0) {
			// Return the answers as an array of objects
			return $answer->result();
		} else {
			// No answers found, return null
			return null;
		}
	}


	/**
	 * Adds an answer to the database.
	 *
	 * @param int $questionid The ID of the question the answer belongs to.
	 * @param int $userid The ID of the user providing the answer.
	 * @param string $answer The content of the answer.
	 * @param string $answeraddreddate The date when the answer was added.
	 * @param string $imageurl The URL of an image attached to the answer.
	 * @param float $rate The rating given to the answer.
	 * @return bool True if the answer was successfully added, otherwise false.
	 */
	public function addAnswer($questionid, $userid, $answer, $answeraddreddate, $imageurl, $rate)
	{

		// Convert rate to float
		$rate = floatval($rate);

		// Fetch past rate for the question
		$pastRateResult = $this->db->select('rate')
			->from('Questions')
			->where('questionid', $questionid)
			->get();

		// Check if past rate exists and rate is greater than 0					
		if ($pastRateResult->num_rows() > 0 && $rate > 0) {

			// Extract past rate from the result
			$pastRate = $pastRateResult->row()->rate;

			// Convert the past rate from string to double
			$pastRate = floatval($pastRate);

			if ($pastRate == 0) {
				$pastRate = $rate;
			}
			// Calculate the new rate
			$rate = ($rate + $pastRate) / 2;
		}

		// Update the rate in the Questions table
		$this->db->where('questionid', $questionid)
			->update('Questions', array('rate' => $rate));

		// Prepare answer data	
		$answerData = array(
			'questionid' => $questionid,
			'userid' => $userid,
			'answer' => $answer,
			'answerimage' => $imageurl,
			'answeraddeddate' => $answeraddreddate
		);

		// Insert the answer into the database
		$insertAns = $this->db->insert('Answers', $answerData);

		// If answer was inserted successfully, update user's answer question count
		if ($insertAns) {
			// Fetch past answer question count for the user
			$pastanswerquestioncnt = $this->db->select('answerquestioncnt')
				->from('Users')
				->where('user_id', $userid)
				->get()
				->row(); // Fetch the result as a single row

			// Increment answer question count	
			$answerquestioncnt = $pastanswerquestioncnt->answerquestioncnt + 1;

			// Update user's answer question count in the Users table
			$this->db->where('user_id', $userid)
				->update('Users', array('answerquestioncnt' => $answerquestioncnt));
		}

		// Return whether the answer was successfully inserted
		return $insertAns;
	}
}
