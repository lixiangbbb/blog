<?php

class View
{
  protected $_controller;
  protected $_action;
  protected $_variables = array();

  public function __construct($contrName,$action)
  {
    $this->_controller = lcfirst($contrName);
    $this->_action      = $action;
  }

  public function assgion($name,$value)
  {
  	$this->_variables[$name] = $value;
  }

  public function render()
  {
  	extract($this->_variables);

    $controllerHeader = APP_PATH . 'application/views/' . $this->_controller . '/header.php';
    $controllerFooter = APP_PATH . 'application/views/' . $this->_controller . '/footer.php';
    $controllerLayout = APP_PATH . 'application/views/' . $this->_controller . '/' . $this->_action . '.php';

    // 页头文件
    if (file_exists($controllerHeader)) {
        include ($controllerHeader);
    }

    include ($controllerLayout);
    
    // 页脚文件
    if (file_exists($controllerFooter)) {
        include ($controllerFooter);
    }
  }

}