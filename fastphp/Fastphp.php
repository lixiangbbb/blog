<?php
  /**
   * 
   */
  class Fastphp
  {
  	
  	protected $_config = [];

  	function __construct($config)
  	{
  		$this->_config = $config;
    }

  	public function run()
    {
      spl_autoload_register(array($this,'loadClass'));
      $this->setReporting();
  		$this->removeMagicQuotes();
      $this->removeMagicQuotes();
      $this->unregisterGlobals();
      $this->setDbConfig();
      $this->route();
  	}

  	//检测开发环境
  	public function setReporting()
  	{
  		if(APP_DEBUG === true){
  			error_reporting(E_ALL);
  			ini_set('display_errors','On');
  		}else{
  			error_reporting(E_ALL);
  			ini_set('display_errors','Off');
  			ini_set('log_errors','On');
  		}
  	}

    //删除反斜线
    public function stripSlashesDeep($value)
    {
      $value = is_array($value) ? array_map('stripSlashesDeep',$value):stripslashes($value);
    }

    public function removeMagicQuotes()
    {
      if(get_magic_quotes_gpc()){
        $GET   = isset($_GET)  ? $this->stripSlashesDeep($_GET)  : '';
        $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
        $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
        $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
      }
    }

    /* 检测全局变量设置（register globals）并移除他们 */
    public function unregisterGlobals()
    {
      if(ini_get('register_globals')){
        $array = array('_SESSION','_POST','_GET','_COOKIE','_REQUEST','_SERVEAR','_ENV','_FILES');
        foreach ($array as $value) {
           foreach ($GLOBALS[$value] as $k => $v) {
              if($v == $BLOBALS[$k]){
                unset($GLOBALS[$k]);
              }
           }
        }
      }
    }

    //路由处理
    public function route()
    {
      $defaultContr = $this->_config['defaultController'];
      $defaultAction = $this->_config['defaultAction'];
      $url = $_SERVER['REQUEST_URI'];
      $position = strpos($url,'?');
      $url = $position === false ? $url : substr($url,0,$position);
      $url = trim($url,'/');
      if($url){
          $urlArr = explode('/', $url);
          $urlArr = array_filter($urlArr);
          //获取控制器
          $contr = ucfirst($urlArr[0]);
          //获取方法名
          array_shift($urlArr);
          $action = $urlArr ? $urlArr[0] : $actionName;
          //获取url参数
          array_shift($urlArr);
          $param = $urlArr ? $urlArr : array();
          //判断控制器和操作是否存在
          $controller = $contr.'Controller';
          if (!class_exists($controller)) {
            exit($controller . '控制器不存在');
          }
          if (!method_exists($controller, $action)) {
            exit($action . '方法不存在');
          }
          //
          $dispatch = new $controller($contr,$action);
          call_user_func_array([$dispatch,$action], $param);
      }
    }

    //自动加载类
    public static function loadClass($class)
    {
      $frameworks = __DIR__.DS.$class.'.php';
      $contr = APP_PATH.'application'.DS.'controllers'.DS.$class.'.php';
      $model = APP_PATH.'application'.DS.'models'.DS.$class.'.php';
      if(file_exists($frameworks)){
        include $frameworks;
      }elseif(file_exists($contr)){
        include $contr;
      }elseif(file_exists($model)){
        include $model;
      }else{
         exit('代码错误');
      }
    } 

    //配置数据库信息
    public function setDbConfig()
    {
        if ($this->_config['db']) {
            Model::$dbConfig = $this->_config['db'];
        }
    }


  }