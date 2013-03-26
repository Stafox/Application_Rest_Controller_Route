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
    
    public function testListUserMessages()
    {
        $route = new Application_Rest_Controller_Route($this->_front, 'users/:user_id/messages', array('controller' => 'users-messages'));
        
        $request = $this->_buildRequest('GET', '/users/30/messages');
        $values = $this->_invokeControllerRouteMatch('/users/30/messages', $request, $route);
    
        $this->assertEquals('users-messages', $values['controller']);
        $this->assertEquals('index', $values['action']);
        $this->assertEquals('30', $values['user_id']);
    }
    
    public function testPutUserMessages()
    {
        $route = new Application_Rest_Controller_Route($this->_front, 'users/:user_id/messages', array('controller' => 'users-messages'));
    
        $request = $this->_buildRequest('POST', '/users/30/messages');
        $values = $this->_invokeControllerRouteMatch('/users/30/messages', $request, $route);
    
        $this->assertEquals('users-messages', $values['controller']);
        $this->assertEquals('put', $values['action']);
        $this->assertEquals('30', $values['user_id']);
    }
    
    public function testGetUserMessages()
    {
        $route = new Application_Rest_Controller_Route($this->_front, 'users/:user_id/messages/:message_id', array('controller' => 'users-messages'));
    
        $request = $this->_buildRequest('GET', '/users/30/messages/33');
        $values = $this->_invokeControllerRouteMatch('/users/30/messages/33', $request, $route);
    
        $this->assertEquals('users-messages', $values['controller']);
        $this->assertEquals('get', $values['action']);
        $this->assertEquals('30', $values['user_id']);
        $this->assertEquals('33', $values['message_id']);
    }
    
    private function _buildRequest($method, $uri)
    {
        $request = new Zend_Controller_Request_HttpTestCase();
        $request->setMethod($method)->setRequestUri($uri);
        return $request;
    }
    
    private function _invokeControllerRouteMatch($url, $request, $route = null)
    {
        $this->_front->setRequest($request);
        $values = $route->match($url);
        return $values;
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
