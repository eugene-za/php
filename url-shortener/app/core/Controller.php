<?php

namespace core;


abstract class Controller
{

    protected View $view;


    public function __construct()
    {
        $this->view = new \core\View();
    }


    /**
     * Render the error page
     * @param string $error
     */
    public function error(string $error)
    {
        $this->view->title = 'Error Page';
        $this->view->error = $error;
        $this->view->display('error');
    }

}