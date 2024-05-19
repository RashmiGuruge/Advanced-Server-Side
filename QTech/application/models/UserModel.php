<?php

class UserModel extends CI_Model
{

	/**
	 * Authenticates a user based on username/email and password.
	 *
	 * @param string $username The username or email of the user.
	 * @param string $password The password of the user.
	 * @return mixed Returns user data if authentication is successful, otherwise returns false.
	 */
	public function loginUser($username, $password)
	{

		// Select all columns where username/email and password match
		$this->db->select('*');
		$this->db->where("(username = '$username' OR email = '$username')");
		$this->db->where('password', $password);
		$this->db->from('users');

		// Execute query
		$respond = $this->db->get();

		// Check if a single row is returned
		if ($respond->num_rows() == 1) {
			return ($respond->row(0));
		} else {
			return false;
		}
	}


	/**
	 * Registers a new user with the provided user data.
	 *
	 * @param array $userData Array containing user data.
	 * @return bool True if registration is successful, otherwise false.
	 */
	public function registerUser($userData)
	{
		// Insert user data into the 'users' table
		$insertDetails = $this->db->insert('users', $userData);
		return $insertDetails; // Return true or false based on registration success
	}


	/**
	 * Updates user data for a given user ID.
	 *
	 * @param int $user_id The ID of the user to update.
	 * @param array $userData Array containing updated user data.
	 * @return bool True if update is successful, otherwise false.
	 */
	public function updateUser($user_id, $userData)
	{
		// Select specific columns for the user with the given user ID
		$this->db->select('user_id, username, occupation, name, email');
		$this->db->where('user_id', $user_id);
		$existingData = $this->db->get('users')->row_array();

		// Check if the existing data is different from $userData
		$isDifferent = false;
		foreach ($existingData as $key => $value) {
			if (isset($userData[$key]) && $existingData[$key] !== $userData[$key]) {
				$isDifferent = true;
				break;
			}
		}

		if ($isDifferent) {
			// Update user data
			$this->db->where('user_id', $user_id);
			$updateDetails = $this->db->update('users', $userData);
			return $updateDetails;
		} else {
			// Return false if no update is performed
			return false;
		}
	}


	/**
	 * Updates password for a given user ID.
	 *
	 * @param int $user_id The ID of the user whose password to update.
	 * @param string $oldpassword The current password of the user.
	 * @param string $newpassword The new password to set.
	 * @return mixed Returns the new password if update is successful, otherwise returns false.
	 */
	public function updatePassword($user_id,  $oldpassword, $newpassword)
	{

		// Retrieve existing password for the user
		$this->db->select('password');
		$this->db->where('user_id', $user_id);
		$existingPasswordQuery = $this->db->get('users');

		// Check if user exists and retrieve existing password
		if ($existingPasswordQuery->num_rows() > 0) {
			$existingPasswordRow = $existingPasswordQuery->row();
			$existingPassword = $existingPasswordRow->password;

			// Compare old password with existing password
			if ($oldpassword == $existingPassword) {
				// Update password
				$this->db->where('user_id', $user_id);
				$this->db->update('users', array('password' => $newpassword));

				// Check if password was successfully updated
				if ($this->db->affected_rows() > 0) {
					return $newpassword; // Return new password
				} else {
					return false; // Return false if update fails
				}
			} else {
				return false; // Return false if old password doesn't match
			}
		} else {
			return false; // Return false if user not found
		}
	}


	/**
	 * Resets the password for a user based on username/email.
	 *
	 * @param string $username The username or email of the user.
	 * @param string $newpassword The new password to set.
	 * @return bool True if password reset is successful, otherwise false.
	 */
	public function forgetPassword($username, $newpassword)
	{
		// Retrieve existing password for the user
		$this->db->select('password');
		$this->db->where("(username = '$username' OR email = '$username')");
		$existingPasswordQuery = $this->db->get('users');

		if ($existingPasswordQuery->num_rows() > 0) {
			// Update password
			$this->db->where("(username = '$username' OR email = '$username')");
			$updatepassword = $this->db->update('users', array('password' => $newpassword));
			return $updatepassword;
		}
	}


	/**
	 * Updates user image for a given user ID.
	 *
	 * @param int $user_id The ID of the user whose image to update.
	 * @param array $userData Array containing updated user image data.
	 * @return bool True if update is successful, otherwise false.
	 */
	public function updateUserImage($user_id, $userData)
	{

		// Select user image for the user with the given user ID
		$this->db->select('userimage');
		$this->db->where('user_id', $user_id);
		$existingData = $this->db->get('users')->row_array();

		// Check if the existing data is different from $userData
		$isDifferent = false;
		foreach ($existingData as $key => $value) {
			if (isset($userData[$key]) && $existingData[$key] !== $userData[$key]) {
				$isDifferent = true;
				break;
			}
		}

		if ($isDifferent) {
			// Update user image
			$this->db->where('user_id', $user_id);
			$updateDetails = $this->db->update('users', $userData);
			return $updateDetails; // Return true or false based on update success
		} else {
			return false; // Return false if no update is performed
		}
	}


	/**
	 * Retrieves user data for a given user ID.
	 *
	 * @param int $id The ID of the user to retrieve data for.
	 * @return mixed Returns user data if found, otherwise returns null.
	 */
	public function getUser($id)
	{
		// Select all columns for the user with the given user ID
		$this->db->select('*');
		$this->db->where('userID', $id);
		$this->db->from('users');

		// Execute query
		$respond = $this->db->get();
		return $respond->row();
	}


	/**
     * Checks if a user with the given username/email exists.
     *
     * @param string $username The username or email to check.
     * @return bool True if user exists, otherwise false.
     */
	public function checkUser($username)
	{
		// Select username and email where username/email matches
		$this->db->select('username, email');
		$this->db->where("(username = '$username' OR email = '$username')");
		$respond = $this->db->get('users');

		// Return true if a single row is returned, otherwise false
		if ($respond->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}
	
}
