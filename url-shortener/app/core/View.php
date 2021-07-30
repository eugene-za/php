<?php
/**
 * Class for render views templates
 */

namespace core;


class View
{

    /**
     * @var array Data used in templates
     */
    private array $data = [];

    /**
     * Directory with templates
     */
    private const TPL_DIR = APP_DIR . 'views/';


    /**
     * @param string $template template file name without extension
     * @return string Returns text
     */
    private function render(string $template): string
    {
        ob_start();
        include self::TPL_DIR . str_replace('/', DIRECTORY_SEPARATOR, $template) . '.php';
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }


    /**
     * Displays template
     * @param string $template template file name without extension
     */
    public function display(string $template)
    {
        echo $this->render($template);
    }


    /**
     * Displays the Redirect page
     * @param string $location Location to redirect
     * @param int $time Time before redirect
     */
    public function redirect(string $location, int $time)
    {
        $this->data['title'] = 'Redirect Page';
        $this->data['time'] = $time;
        $this->data['location'] = $location;

        header('refresh:' . $time . ';url=' . $location);
        echo $this->render('redirect');
    }


    /**
     * Displays JSON
     * @param array $data Array that will be converted to json
     */
    public function json(array $data)
    {
        $this->data['json'] = json_encode($data);

        header('Content-Type: application/json');
        echo $this->render('json');
    }


    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }


    public function __get($name)
    {
        return $this->data[$name];
    }


    public function __isset($name)
    {
        return isset($this->data[$name]);
    }


}
