<?php

class Controller
{
  protected $_controller;
  protected $_action;
  protected $_view;

  public function __construct($contrName,$action)
  {
    $this->_controller = $contrName;
    $this->_action      = $action;
    $this->_view        = new View($contrName,$action);
  }

  public function assgin($name,$value)
  {
    $this->_view->assgin($name,$value);
  }

  public function render()
  {
    $this->_view->render();
  }

}