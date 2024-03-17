<?php

class ProfileInfoContr extends ProfileInfo
{
    private $userId;
    private $user_id;
 
    public function __construct($userId, $email)
    {
        $this->userId = $userId;
        $this->email = $email;
    }

    protected function defaultProfileInfo()
    {
        $user_about = "Let Inform The World!";
        $this->setProfileInfo($user_about, $this->userId);
    }

    protected function updateProfileInfo($user_about)
    {
        // Make sure that the text is not too long
        if ($this->sizeInputCheck(str_word_count($user_about)) > 100) 
        {
            header("location: ../profile.php?status=sizetolarge");
            exit();
        }

        // Update the profile
        $this->setNewProfileInfo($user_about, $this->userId);
        
    
        $this->setProfileInfo($user_about, $this->userId);
    }
}
