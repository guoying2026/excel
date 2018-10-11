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
    protected $controller = 'Content';

    /**
     * Stores the method from the split URL
     * @var string
     */
    protected $method = 'report';

    /**
     * Stores the parameters from the split URL
     * @var array
     */
    protected $params = [];

    public function __construct()
    {

        // 有效用户认证开始
        //请在$remote_user数组中添加有效用户，如'guoying\\1'
        // $remote_user = [
        //     'guoying\\1',
        // ];
        // //用户认证的前提是可以获取到$_SERVER['REMOTE_USER']
        // if(!in_array($_SERVER['REMOTE_USER'],$remote_user,true)){
        //     exit('Access unauthorized, connection aborted. <br />Current user: ' . $_SERVER['REMOTE_USER'] . '.');
        // }
        //有效用户认证结束

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