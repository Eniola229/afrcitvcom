<?php
	/**
	 * 
	 */
	class ProfileInfo extends Dbh
	{
		
		function getProfileInfo($userId)
		{
			$stmt = $this->connect()->prepare('SELECT * FROM profiles WHERE user_id = ?;');

			if (!$stmt->execute(array($userId))) {
					$stmt = null;
					header("location: profile.php?status=stmtfailed");
					exit();
				  }			
			if ($stmt->rowCount() == 0) 
			{
				$stmt = null;
				header("location: profile.php?status=profilenotfound");
				exit();
			}

			$profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $profileData;
		}

		protected function setNewProfileInfo($user_about)
		{
			$stmt = $this->connect()->prepare('UPDATE profiles SET $user_about = ?;');

			if (!$stmt->execute(array($user_about))) {
				$stmt = null;
				header("location: ../profile.php?status=stmtfailed");
				exit();
			}
			$stmt = null;
		}

		protected function setProfileInfo()
		{
			$stmt = $this->connect()->prepare('INSERT INTO profiles (user_about) VALUES (?);');

			if (!$stmt->execute(array($user_about))) 
			{
				// code...
				$stmt = null;
				header("location ../profile.php?status=stmtfailed");
				exit();
			}
			$stmt = null;
		}


	}