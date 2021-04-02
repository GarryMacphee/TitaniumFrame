<?php

/**
 * Model class will be responsible for 
 * storing and retrieving data from the database
 */
class User
{
    private $db;

    public function __construct()
        {
            $this->db = new Database;
        }

     /**
     * Log user actions during their session
     * @param type $log_vals array of log values to record
     * @return boolean true if log save, false otherwise
     */
    public function logUserAction($log_vals = array())
        {
            $sql = 'INSERT INTO
                        log_actions(
                                log_user_id,
                                log_type,
                                log_message
                                )
                            VALUES(
                                :user_id,
                                :type,
                                :message
                                )';
            
            //prepare statement
            $this->db->query($sql);
            
            //bind the data values
            $this->db->bind(':user_id',     $log_vals['user_id']);
            $this->db->bind(':type',        $log_vals['type'], PDO::PARAM_INT);
            $this->db->bind(':message',     $log_vals['message']);
            
            //check success
            if($this->db->execute())
                {
                    return true;
                }
            else
                {
                    return false;
                }
        }
        
    //register user
    public function register($data)
        {
            //prepared query
            $sql = 'INSERT INTO
                            users(
                                 users_name, 
                                 users_email, 
                                 users_password)
                            VALUES(
                                 :name,
                                 :email,
                                 :password
                                 );';

            //create the prepared statement
            $this->db->query($sql);

            //bind the values to the prepared statement
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);

            //check success
            if($this->db->execute())
                {
                    return true;
                }
            else
                {
                    return false;
                }
        }
    
    
    /**
     * Fetch user details from the database using
     * the email parameter. Compare the database
     * hashed password with the password entered
     *  by the user for a match.
     * @param type $email the users email
     * @param type $password the users password
     */
    public function login($email, $password)
        {
            //parameterised query string
            $sql = 'SELECT
                         *
                    FROM
                         users
                    WHERE
                         users_email = :users_email';

            //create and set up the prepared query
            $this->db->query($sql);
            $this->db->bind(':users_email', $email);

            //execute the query and get single row
            $row = $this->db->single();

            $hashed_password = $row->users_password;

             if(password_verify($password, $hashed_password))
                {
                    return $row;
                }
             else 
                {

                }
        }

    //find user by email
    public function findUserByEmail($email)
        {
            $sql = 'SELECT 
                          *
                    FROM 
                          users 
                    WHERE 
                          users_email = :users_email';

            //create prepared statement
            $this->db->query($sql);

            //bind the values
            $this->db->bind(':users_email', $email);

            //get single row
            $row = $this->db->single();

            //check row exists
            if ($this->db->getRowCount() > 0)
                {
                    //email is already taken
                    return true;
                }
            else
                {
                    //email doesn't exist
                    return false;
                }
        }
    
    // Get User by ID
    public function getUserById($id)
        {
            $this->db->query('SELECT * FROM users WHERE id = :id');

            // Bind value
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            return $row;
        }
}
