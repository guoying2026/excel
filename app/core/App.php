<?php

/**
 * The application class.
 *
 * Handles the request for each call to the application
 * and calls the chosen controller and method after splitting the URL.
 *
 */

use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler as WhoopsPrettyPageHandler;

class App
{
    /**
     * Stores the controller from the split URL
     *
     * @var string
     */
    protected $controller = 'Home';

    /**
     * Stores the method from the split URL
     * @var string
     */
    protected $method = 'index';

    /**
     * Stores the parameters from the split URL
     * @var array
     */
    protected $params = [];

    public function __construct()
    {
        // var_dump($_SERVER['HTTP_REFERER']);
        // var_dump($_SERVER['PHP_SELF']);
        // var_dump($_SERVER['SCRIPT_NAME']);
        if($_SERVER['REQUEST_URI'] && $_SERVER['REQUEST_URI'] != '/'){
            $routearr = explode('/',trim($_SERVER['REQUEST_URI'],'/'));
        }
  
        if(isset($routearr[0])){
            $this->controller = $routearr[0];
        }
            
        if(isset($routearr[1])){
            $this->method = $routearr[1];
            
        }else{
            /*  当方法省略时,默认为index方法   */
            $this->action = 'index';
        }
        if(isset($routearr[2])){
            $a = 2;
            $suode = [];
            while(isset($routearr[$a])){
                $zhi = explode('=',trim($routearr[$a],'='));
                $suode[] = [$zhi[0]=>$zhi[1]];
                $a++;
            }
            $this->params = $suode;
        } else {
            $this->params = [];
        }
        unset($routearr);

        require_once '../app/controllers/' . ucfirst($this->controller) . '.php';

        $this->controller = new $this->controller();
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}