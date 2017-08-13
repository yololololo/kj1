<?php
class framework{
	public static function run(){
		// echo "run()";
		self::init();

       self::autoload();

       self::dispatch();
	}

	private static function init() {
		// echo "init";
		 // Define path constants

    define("DS", DIRECTORY_SEPARATOR);//DIRECTORY_SEPARATOR目录分隔符，windows下为'\'
    //返回：\
    define("ROOT", getcwd() . DS);
    //返回：D:\demo\test\shop\
    define("APP_PATH", ROOT . 'application' . DS);
    //返回：D:\demo\test\shop\application\

    define("FRAMEWORK_PATH", ROOT . "framework" . DS);
    //返回：D:\demo\test\shop\framework\
    define("PUBLIC_PATH", ROOT . "public" . DS);
    //返回：D:\demo\test\shop\public\

    define("CONFIG_PATH", APP_PATH . "config" . DS);
    //返回：D:\demo\test\shop\application\config\

    define("CONTROLLER_PATH", APP_PATH . "controller" . DS);
    //返回：D:\demo\test\shop\application\controller\
    define("MODEL_PATH", APP_PATH . "model" . DS);
    //返回：D:\demo\test\shop\application\model\
    define("VIEW_PATH", APP_PATH . "view" . DS);
    //返回：D:\demo\test\shop\application\view\

    define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
    //返回：D:\demo\test\shop\framwork\core\

    define('DB_PATH', FRAMEWORK_PATH . "database" . DS);
    //返回：D:\demo\test\shop\framwork\database\
    define("LIB_PATH", FRAMEWORK_PATH . "lib" . DS);
    //返回：D:\demo\test\shop\framwork\lib\

    define("HELPER_PATH", FRAMEWORK_PATH . "helper" . DS);
    //返回：D:\demo\test\shop\framwork\helper\

    define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);
    
    //返回：D:\demo\test\shop\public\uploads\
    // Define platform, controller, action, for example:

    // index.php?p=admin&c=Goods&a=add

    define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'index');
    //默认模块：index
    define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');
    //默认控制器：Index
    define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');
    //默认操作：index

    define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);

    define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);
// echo HELPER_PATH;exit();
    // Load core classes

    require CORE_PATH . "Controller.class.php";


    require CORE_PATH . "Loader.class.php";
 
    require DB_PATH . "Mysql.class.php";

    require CORE_PATH . "Model.class.php";

    // Load configuration file
    $GLOBALS['config'] = include CONFIG_PATH . "config.php";
   


    // Start session

    session_start();

   }


   private static function autoload() {
   	 spl_autoload_register(array(__CLASS__,'load'));

}


// Define a custom load method

private static function load($classname){


    // Here simply autoload app&rsquo;s controller and model classes

    if (substr($classname, -10) == "Controller"){

        // Controller

        require_once CURR_CONTROLLER_PATH . "$classname.class.php";

    } elseif (substr($classname, -5) == "Model"){

        // Model

        require_once  MODEL_PATH . "$classname.class.php";

    }


   }


   private static function dispatch() {

   	$controller_name = CONTROLLER . "Controller";

    $action_name = ACTION . "Action";

    $controller = new $controller_name;

    $controller->$action_name();
   }
}