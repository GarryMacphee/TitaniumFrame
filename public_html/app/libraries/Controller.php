<?php

/*
 * Base Controller, all other Controllers extend this class.
 * loads the models and views
 */


class Controller
    {

    public $keyMaster;
    public $userModel;
    public $postModel;
    public $chatModel;
    public $uploadModel;
    public $dashboardModel;

    //load model
    public function model ($model)
        {
            if (!is_object ($this->keyMaster))
                {
                    $this->keyMaster = new KeyMaster();
                }
            require_once '../app/models/'.$model.'.php';

            return new $model();
        }

    //Load the view
    public function view ($view, $data = [])
        {
            $filename = '../app/views/'.$view.'.php';
            
            if (file_exists($filename) AND is_readable($filename))
                {
                    require_once $filename;
                }
            else
                {
                    redirect ('/users/login');
                    die ();
                }
        }
        
        
    //Load the view
    public function chatView ($view, $data = [])
        {
             $filename = '../app/views/'.$view.'.php';
             
             if (file_exists($filename) AND is_readable($filename))
                {
                    require_once '../app/views/'.$view.'.php';
                }
            else
                {
                    redirect ('/users/login');
                    die ();
                }
        }
    }
