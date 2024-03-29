<?php

/*
 * App Core Class
 * Loads the controller based on url value
 * URL FORMAT- /controller/method/params
 */
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        if ($url != null) {
            if (file_exists('../app/controllers/' . ucwords($url[0] . '.php'))) {

                $this->currentController = ucwords($url[0]);
                unset ($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->currentController . '.php';

        $this->currentController = new $this->currentController;

        if (isset ($url[1])) {

            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // unset it now we have the value
                unset ($url[1]);
            }
        }


        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * @return type Get the URL from address bar
     */
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim(filter_input(INPUT_GET, 'url'), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}
