<?php

/**
 * Pages controller, controls the set up
 * of the pages via the {view($url, $params)} method
 * in the Controller super class
 */
class Pages extends Controller
    {
        public function __construct()
            {
            
            }

        /**
         * Control and start the index page
         */
        public function index()
            {
                $data = ['title'        => 'Garry Macphee',
                        'description'   => 'Garry Macphee\'s site '
                ];

                $this->view('pages/index', $data);
            }

        /**
         * Control and start the about page
         */
        public function about()
            {
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
