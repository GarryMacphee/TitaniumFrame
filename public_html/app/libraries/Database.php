<?php
/**
 * PDO database class,
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $db_master;
    private $stmt;
    private $error;
    private $conn;

    public function __construct()
        {
             //('The class "', __CLASS__,'" has been loaded <br />');
            //set dsn - data source name
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8mb4';

            $options = array(
                            PDO::ATTR_PERSISTENT    => true,
                            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
            );

            try
                {
                    $this->db_master = new PDO($dsn, $this->user, $this->pass, $options);
                }
            catch (PDOException $ex)
                {
                    $this->error = $ex->getMessage();
                    echo $this->error;
                    redirect('users/login');
                }
        }

    //Prepare statement with query
    public function query($sql)
        {
            $this->stmt = $this->db_master->prepare($sql);
        }

        
    // call this after we prepare our SQL statements
    public function bind($param, $value, $type = null)
        {
            if (is_null($type))
                {
                    switch (true)
                        {
                            case is_int($value) :
                                $type = PDO::PARAM_INT;
                                break;
                            case is_bool($value) :
                                $type = PDO::PARAM_BOOL;
                                break;
                            case is_null($value) :
                                $type = PDO::PARAM_NULL;
                                break;
                            case is_string($value) :
                                $type = PDO::PARAM_STR;
                                break;
                            default:
                                $type = PDO::PARAM_INT;
                        }
            }
            
            //bind value, stmt is prepared sql query
            $this->stmt->bindValue($param, $value, $type);
        }

        
    //Execute prepared statement
    public function execute()
        {
            return $this->stmt->execute();
        }

        
    //Get result set of array of objects
    public function resultSet()
        {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        
    //single row as an object
    public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        
    //get the row count
    public function getRowCount()
        {
            return $this->stmt->rowCount();
        }
}

