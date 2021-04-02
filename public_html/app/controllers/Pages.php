<?php

/**
 * Pages controller, controls the set up
 * of the pages via the {view($url, $params)} method
 * in the Controller super class
 */
class Pages extends Controller
    {
        //constructor 
        public function __construct()
            {
                //printf('The class "', __CLASS__,'" has been loaded <br />');
                // echo '<br><br /> Pages class loaded - constructor <br />';
                //calls the model() method in the super class
                // $this->postModel = $this->model('Post');
            }

        /**
         * Control and start the index page
         */
        public function index()
            {
                // data array we pass to the view
                $data = ['title'        => 'Garry Macphee',
                        'description'   => 'Garry Macphee\'s site '
                ];

                //pass data into our index page via the Controller view method
                $this->view('pages/index', $data);
            }

        /**
         * Control and start the about page
         */
        public function about()
            {
                // data array we pass to the view
                $data = [
                    'title'         => 'About page',
                    'description'   => 'A description of the About page'
                ];

                $this->view('pages/about', $data);
            }

        /**
         * Default error page
         */
        public function error()
            {
                $data = [
                    'title'         => 'Error',
                    'description'   => 'oops, an error was caused. Did you do this on purpose?'
                ];

                $this->view('pages/error', $data);
            }
    }
