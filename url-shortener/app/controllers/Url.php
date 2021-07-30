<?php
/**
 * This controller is responsible for handling user requests
 * related to the work with the URL.
 */


namespace controllers;


class Url extends \core\Controller
{

    /**
     * Saving new URL
     * @param string $url URL string for creating shorten
     */
    public function create(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $Url = new \models\Url();
            $Url->create($url);

            $response = [
                'status' => 'ok',
                'code'   => \libs\Base62Converter::encode($Url->id)
            ];
        } else {

            $response = [
                'status' => 'error',
                'error'  => 'The string You entered is not valid HTTP URL'
            ];
        }

        $this->view->json($response);
    }


    /**
     * Get url hits count
     * @param string $code The part of the short URL that encodes the original link ID
     */
    public function hits(string $code)
    {
        $id = \libs\Base62Converter::decode($code);
        $Url = \models\Url::read($id);

        if (false !== $Url) {
            $response = [
                'status' => 'ok',
                'hits'   => $Url->hits
            ];
        } else {
            $response = [
                'status' => 'error',
                'error'  => 'That Shot doesn\'t exist '
            ];
        }

        $this->view->json($response);
    }


    /**
     * Redirect to original link
     * @param string $code The part of the short URL that encodes the original link ID
     */
    public function redirect(string $code)
    {
        $id = \libs\Base62Converter::decode($code);
        $Url = \models\Url::read($id);
        if (false !== $Url) {
            $Url->incrementHits();
            $this->view->redirect($Url->url, 3);
        } else {
            $this->error('Shot not found');
        }

    }

}