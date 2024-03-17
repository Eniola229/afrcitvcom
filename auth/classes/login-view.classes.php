<?php

class LoginView extends Login {
    
    public function fetchName($user_id) {
        $userData = $this->getLoginView($user_id);
        if ($userData) {
            return $userData[0]["name"];
        } else {
            return "User not found";
        }
    }

    public function fetchEmail($user_id) {
        $userData = $this->getLoginView($user_id);
        if ($userData) {
            return $userData[0]["email"];
        } else {
            return "Email not found";
        }
    }

    public function fetchNumber($user_id) {
        $userData = $this->getLoginView($user_id);
        if ($userData) {
            return $userData[0]["phone_number"];
        } else {
            return "Phone number not found";
        }
    }
}
?>
