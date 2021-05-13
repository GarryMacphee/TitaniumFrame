<?php

/**
 * Responsible for validating response token with Google
 * Provide the response text and any error messages
 */
class Recaptcha
    {
        public $resp_token;       
        public $verify_host;      
        public $response;          
        public $error_codes = [];
        
        
        public function __construct($response_token)
            {
                $this->resp_token = $response_token;
                
                if(strlen($this->resp_token) > 0)
                    {
                        //contact Google to verify
                        $this->getResponse();
                    }
            }
            
        /**
         * Contact Google and verify the response
         * token provided.
         */
        private function getResponse()
            {
                $curl =  curl_init();
            
                curl_setopt_array($curl,[
                            CURLOPT_RETURNTRANSFER  =>  1,
                            CURLOPT_URL             =>  'https://www.google.com/recaptcha/api/siteverify',
                            CURLOPT_POST            =>  1,
                            CURLOPT_POSTFIELDS      =>  [
                                                        'secret'    =>  CAPTCHA_PRIVATE_KEY,
                                                        'response'  =>  $this->resp_token
                            ],
                ]);
                
                $this->response = json_decode(curl_exec($curl));
            }
            
        /**
         * Check the host returned from Google matches
         * the host name of our site.
         * @param type $host returned from Google
         */
        public function verifyHost()
            {
                if($this->response->success)
                    {
                        $curr_host = parse_url(URLROOT);
                        
                        if(array_key_exists('hostname', $this->response) && array_key_exists('host', $curr_host))
                            {
                                return $curr_host['host'] == $this->response->hostname ? true : false;
                            }
                    }
                return false;
            }

         /**
         * Get the response returned from Google after
         * submitting the response token
         * @return type 
         */
        public function verify()
            {
                if(!is_null($this->response))
                    {
                        return  $this->response;
                    }
                return '';
            }
    }
