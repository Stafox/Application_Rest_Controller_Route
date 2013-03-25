<?php

class Application_Rest_Controller_RouteTest extends PHPUnit_Framework_TestCase
{
    protected $_front;
    protected $_request;
    protected $_dispatcher;
    
    public function setUp()
    {
        $this->_front = Zend_Controller_Front::getInstance();
        $this->_front->resetInstance();
        $this->_front->setParam('noErrorHandler', true)
        ->setParam('noViewRenderer', true);
    
        $this->_dispatcher = $this->_front->getDispatcher();

        
        $this->_front->getRouter()->addRoute('users-messages', new Application_Rest_Controller_Route($this->_front, 'users/:user_id/messages', array('controller' => 'users-messages')));
        
    }
    
    public function testUserDefault()
    {
        $request = $this->_buildRequest('GET', '/users');
        $values = $this->_invokeRouteMatch($request);
    
        $this->assertTrue(isset($values['module']));
        $this->assertEquals('default', $values['module']);
        $this->assertEquals('users', $values['controller']);
        $this->assertEquals('index', $values['action']);
    }
    
    public function testUserMessages()
    {
        $request = $this->_buildRequest('GET', '/users/30/messages');
        $values = $this->_invokeRouteMatch($request);
    
        $this->assertTrue(isset($values['module']));
        $this->assertEquals('default', $values['module']);
        $this->assertEquals('users', $values['controller']);
        $this->assertEquals('get', $values['action']);
    }
    
    private function _buildRequest($method, $uri)
    {
        $request = new Zend_Controller_Request_HttpTestCase();
        $request->setMethod($method)->setRequestUri($uri);
        return $request;
    }
    
    private function _invokeRouteMatch($request, $config = array(), $route = null)
    {
        $this->_front->setRequest($request);
        if ($route == null) {
            $route = new Zend_Rest_Route($this->_front, array(), $config);
        }
        $values = $route->match($request);
        return $values;
    }
}
