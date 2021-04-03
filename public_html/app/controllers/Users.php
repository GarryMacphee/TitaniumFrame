<?php
/**
 * Users Controller class. Will handle
 * processing and loading user data
 */
class Users extends Controller
    {
    
    //public $userModel;
    //constructor
    public function __construct()
        {
            $this->userModel = $this->model('User');
            if (!is_object($this->keyMaster))
                {
                    $this->keyMaster = new KeyMaster();
                }
        }

    /**
     * Will handle loading and submitting
     */
    public function register()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $pre_sanitized_email = $_POST['email'];
                    $pre_sanitized_password = $_POST['password'];

                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                    //process the form
                    $data = [
                            'name'                  => trim($_POST['name']),
                            'email'                 => trim($_POST['email']),
                            'password'              => trim($_POST['password']),
                            'confirm_password'      => trim($_POST['confirm_password']),
                            'name_err'              => '',
                            'email_err'             => '',
                            'password_err'          => '',
                            'confirm_password_err'  => '',
                            'recaptcha'             => '',
                            'recaptcha_err'         => '',
                            'csrf_key'              => $this->keyMaster->generateCsrfToken('reg_form')
                    ];

                    //check email matches after being sanitized of special chars
                    if ($data['email'] != $pre_sanitized_email)
                        {
                            $data['email_err'] = 'Enter a valid email address';
                            unset($pre_sanitized_password);
                        }

                    //check password matches after being sanitized of special chars
                    if ($data['password'] != $pre_sanitized_password)
                        {
                            $data['password_err'] = 'Enter a valid password';
                            unset($pre_sanitized_email); //make sure cannot be used again
                        }

                    //validate email
                    if (empty($data['name']))
                        {
                            $data['name_err'] = 'Please enter name';
                        }

                    //check name length
                    if (isset($data['name'][50]) || !isset($data['name'][4]))
                        {
                            $data['name_err'] = 'Name must be between 4 and 50 characters';
                        }

                    //validate name
                    if (empty($data['email']))
                        {
                            $data['email_err'] = 'Please enter email';
                        }
                    else
                        {
                        if ($this->userModel->findUserByEmail($data['email']))
                            {
                                $data['email_err'] = 'Email is already registered';
                            }
                        }

                    //validate password
                    if (empty($data['password']))
                        {
                            $data['password_err'] = 'Please enter password';
                        }
                    elseif (strlen($data['password']) < 6 || strlen($data['password']) > 24)
                        {
                            $data['password_err'] = 'Password must be between 6 and 24 characters';
                        }

                    //validate confirm password
                    if (empty($data['confirm_password']))
                        {
                            $data['confirm_password_err'] = 'Please enter confirm password';
                        }
                    else
                        {
                        if ($data['password'] != $data['confirm_password'])
                            {
                                $data['confirm_password_err'] = 'Passwords do not match';
                            }
                        }

                    if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
                        {
                            //input has been validated
                            $options = [
                                'cost' => 12
                            ];

                            //clean name
                            $data['name'] = strip_tags($data['name']);
                            $data['name'] = htmlentities($data['name'], ENT_QUOTES);

                            //clean password
                            $data['password'] = strip_tags($data['password']);
                            $data['password'] = htmlentities($data['password'], ENT_QUOTES);

                            //One way hash password, plain text never revealed
                            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                            //Register User
                            if ($this->userModel->register($data))
                                {
                                    $this->userModel->logUserAction($this->getLogTemplate(0, 'Successfully registered', 1));

                                    flash('register_success', 'You have successfully registered', 'alert alert-success');
                                    redirect('/users/login');
                                }
                            else
                                {
                                    die('Error registering user');
                                }
                    }
                else
                    {
                        $this->view('users/register', $data);
                    }
                }
            else
                {
                    $data = [
                        'name' => '',
                        'email' => '',
                        'password' => '',
                        'confirm_password' => '',
                        'name_err' => '',
                        'email_err' => '',
                        'password_err' => '',
                        'confirm_password_err' => '',
                        'recaptcha' => '',
                        'recaptcha_err' => '',
                        'csrf_key' => $this->keyMaster->generateCsrfToken('reg_form')
                    ];

                    $this->view('users/register', $data);
                }
        }

    /**
     * Check users login credentials,
     * if they are valid set a new session for
     * the user with details returned from database.
     */
    public function login()
        {
            if (!empty($_SESSION['recaptcha_success']))
                {
                    unset($_SESSION['recaptcha_success']);
                }

            if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                    $data = [
                        'email'                     => trim($_POST['email']),
                        'password'                  => trim($_POST['password']),
                        'email_err'                 => '',
                        'password_err'              => '',
                        'recaptcha-response'        =>  isset($_POST['g-recaptcha-response']) ? trim($_POST['g-recaptcha-response']) : $_POST['g-recaptcha-response'] = "",
                        'recaptcha_err'             => '',
                        'response'                  => '',
                        'message'                   => '',
                        'csrf'                      => $this->keyMaster->outputCsrfToken('login_form')
                    ];

                    if ($data['recaptcha-response'])
                        {
                            require_once('../app/helpers/Recaptcha.php');

                            $captcha = new Recaptcha($data['recaptcha-response']);

                            if ($captcha->verifyHost())
                                {
                                    $data['response'] = $captcha->verify();
                                }
                            else
                                {
                                    $data['recaptcha_err'] = 'Host not verified';
                                    flash('recaptcha_success', 'For additional security please solve the recaptcha to continue', 'alert alert-danger');
                                }
                        }
                    else
                        {
                            $data['recaptcha_err'] = 'Please complete the recaptcha to continue';
                        }

                    if (empty($data['email']))
                        {
                            $data['email_err'] = 'Please enter a valid email';
                        }

                    if (empty($data['password']))
                        {
                            $data['password_err'] = 'Please enter password';
                        }
                    elseif (strlen($data['password']) < 6 || strlen($data['password']) > 24)
                        {
                            $data['password_err'] = 'Password must be between 6 and 24 characters';
                        }

                    if (!$this->userModel->findUserByEmail($data['email']))
                        {
                            $data['email_err'] = 'No user found';
                        }

                    if (empty($data['email_err']) AND empty($data['password_err']) AND empty($data['recaptcha_err']))
                        {
                            $data['email'] = strip_tags($data['email']);
                            $data['email'] = htmlentities($data['email'], ENT_QUOTES);

                            $data['password'] = strip_tags($data['password']);
                            $data['password'] = htmlentities($data['password'], ENT_QUOTES);

                            $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                            if ($loggedInUser)
                                {
                                    $this->createUserSession($loggedInUser);
                                    $this->userModel->logUserAction($this->getLogTemplate($_SESSION['user_id'], 'Successful login', 1));
                                }
                            else
                                {
                                    $data['password_err'] = 'Password not recognised';
                                    $this->view('users/login', $data);
                                }
                        }
                    else
                        {
                            $this->view('users/login', $data);
                        }
                }
            else
                {
                    $data = [
                        'email' => '',
                        'password' => '',
                        'email_err' => '',
                        'password_err' => '',
                        'csrf' => $this->keyMaster->generateCsrfToken('login_form')
                    ];

                    $this->view('users/login', $data);
                }
        }

        
    /**
     * unset all user variables and destroy the 
     * session, redirect to the login page
     */
    public function logout()
        {
            if (isLoggedIn())
                {
                    $this->userModel->logUserAction($this->getLogTemplate($_SESSION['user_id'], 'Successful logout', 1));
                }

            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            unset($_SESSION['start']);
            unset($_SESSION['form_key']);

            session_write_close();
            redirect('users/login');
        }

    /**
     * Set the Session values from the retrieved 
     * database values for the user
     * @param type $user object containing user data (db row)
     */
    public function createUserSession($user)
        {
            $_SESSION['user_id'] = (isset($user->id) === true) ? (int) $user->id : 0;
            $_SESSION['user_email'] = $user->users_email;
            $_SESSION['user_name'] = $user->users_name;
            $_SESSION['csrf'] = $this->createUserSessionToken($user->users_name);
            $_SESSION['start'] = date("Y-m-d H:i:s");
            $_SESSION['user_ip'] =  isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
            
            $_SESSION['user_id'] > 0 ? redirect('dashboard') : redirect('users/login');
            
            if ($_SESSION['user_id'] > 0)
                {
                    flash('invalid user', 'Something went wrong, please try logging in again', 'alert alert-danger');
                }
            
        }

        
    public function createUserSessionToken($user_id='empty')
        {
            //create a 7 digit random hashed salt token for the user
            // $salt  = substr(md5(time(), 0, 7));
            return $token = hash('sha1',SALT01.$user_id, false);
        }

    /**
     * Create the log array for sending to the User model
     * to log user actions
     * 
     * @param type $userId  - user session id
     * @param type $message    - type of log
     * @param type $type - message to record
     * @return type         - array of values to pass to User model
     */
    public function getLogTemplate($userId, $message, $type = 1, $ip_addr = '0')
        {
            $log_details = [
                        'user_id'   => $userId, //userId
                        'date'      => date('Y-m-d H:i:s'),     //current date
                        'type'      => $type,                   //1 => success, chage this to const.
                        'message'   => $message,                //message to log
                        'ip_addr'   => $ip_addr
            ];

            return $log_details;
        }

//********************************************************************************************
    // VALIDATION FUNCTIONS

    /**
     * Check recaptcha validation is correct
     * and valid
     * @param type $data the main data array to pass
     * to the view object
     */
    private function validateRecaptcha($data)
        {
            //validate recaptcha
            if (!empty($data['recaptcha-response']))
                {
                    require_once('../app/helpers/Recaptcha.php');

                    $captcha = new Recaptcha($data['recaptcha-response']);

                    if ($captcha->verifyHost())
                        {
                            $data['response'] = $captcha->verify();
                        }
                   
                }
            else
                {
                    $data['recaptcha_err'] = 'Please complete the recaptcha to continue';
                }

            return $data;
        }

    }
