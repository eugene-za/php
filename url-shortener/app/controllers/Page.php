<?php
/**
 * This controller is for rendering static pages
 */

namespace controllers;


class Page extends \core\Controller
{

    /**
     * Render the Index page
     */
    public function index()
    {
        $this->view->title = 'Index Page';
        $this->view->display('index');
    }

}