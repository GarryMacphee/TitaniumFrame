<?php

/**
 * Provide hashed keys as authentication
 * tokens to ensure we are only processing data
 * from our application
 */
class KeyMaster
{
    public $form_key;
    public $csrf_key;
    private $oldFormKey;
    public $origin_id;

    //constructor
    public function __construct()
    {
        //keep track of the last key
        if (isset($_SESSION['form_key'])) {
            $this->oldFormKey = $_SESSION['form_key'];
        }
    }

    public function setOriginId($origin = 'form_key')
    {
        $this->origin_id = $origin;
    }


    /**
     * generate token with date so that they cannot be reused
     * @param type $page_type , the page making the request
     * @return type hashed String token
     */
    public function generateCsrfToken($page_type)
    {
        $secretKey = '75675675756878876567678678678679789#';
        if (!session_id()) {
            session_start();
        }
        $sessionId = session_id();
        $body = $page_type . session_id() . date("Y") . SALT01 . date("m") . SALT02 . date("d");

        return hash("sha3-512", $body, false);
    }


    /**
     * Create an input HTML element to hold our token so that
     * when the user sends us data we can verify the token came
     * from the page
     * @param type $page_type , the page making the request
     * @return type String containing an HTML input element
     */
    public function outputCsrfToken($page_type)
    {
        $this->csrf_key = $this->generateCsrfToken($page_type);
        return "<input type='hidden' id='form_key' value='" . $this->csrf_key . "' />";
    }


    /**
     * Generate a unique token for each page
     * @param type $token returned in the $POST method
     * @param type $page_type , the page making the request
     * @return type boolean, true if the provided token matches
     */
    public function validateCsrfToken($token, $page_type)
    {
        return $token == generateCsrfToken($page_type);
    }


    /**
     * Security key to pass to logged in user
     * to prevent XXS cross site scripting attacks
     */
    private function generateFormKey($user_id = '0')
    {
        //get user ip address
        $ip = filter_input(INPUT_SERVER, $_SERVER['REMOTE_ADDR']);
        //mt_rand() = better random gen and true = longer string
        $unique_id = uniqid(mt_rand(), true);

        return md5($ip . $unique_id);
    }


    /**
     * Generate our form key, add it to the session
     * and echo out the hidden field to the page
     */
    public function outputFormKey()
    {
        $this->form_key = $this->generateFormKey();
        $_SESSION['form_key'] = $this->form_key;
        return "<input type='hidden' id='form_key' name='form_key' value='" . $this->form_key . "' />";
    }


    /**
     * Check whether a form key is valid, check the key origin and
     * request origin match
     *
     * @param type $key_origin the page currently making the request
     * @param type $request_origin the location of the request
     *
     * @return boolean true if form_key is equal to oldFormKey
     */
    public function validateFormKeyAlpha($key_origin, $request_origin)
    {
        if (isset($_POST['form_key'])) {
            $key = $_POST['form_key'];
            echo $key;

            if ($key == $this->oldFormKey) {
                echo 'Form key validated';
                return true;
            } else {
                echo 'Form key doesn\'t match';
                return false;
            }
        }
    }


    /**
     * Check whether a form key is valid
     * @return boolean true if form_key is equal to oldFormKey
     */
    public function validateFormKey()
    {
        if (isset($_POST['form_key'])) {
            $key = $_POST['form_key'];

            if ($key == $this->oldFormKey) {
                echo 'Form key validated';
                return true;
            } else {
                echo 'Form key doesn\'t match';
                return false;
            }
        }
    }

    /**
     * Check whether a form key is valid
     * @return boolean true if form_key is equal to oldFormKey
     */
    public function validateFormKeyUploads()
    {
        if (isset($_POST['form_key'])) {
            $key = $_POST['form_key'];

            if ($key == $this->oldFormKey) {
                return true;
            } else {
                return false;
            }
        }
    }


    /**
     * Check whether a form key is valid
     * @return boolean true if form_key is equal to oldFormKey
     * false otherwise
     */
    public function validateChatFormKey($user_form_key)
    {
        if (isset($user_form_key) && $user_form_key != '') {
            if ($user_form_key === $this->oldFormKey) {
                echo 'Form key validated';
                return true;
            } else {
                echo 'Form key not validated';
                return false;
            }
        }
    }

    function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }


    function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_,', '+/='));
    }
}
