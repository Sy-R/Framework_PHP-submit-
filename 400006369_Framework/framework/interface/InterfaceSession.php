<?php
namespace framework\interface;

interface InterfaceSession
{
    public function start();

    public function sessionStatus();

    public function set($key, $value);

    public function getSession($key, $default = null);
    
    public function remove($key);
    
    public function destroy();

    public function unset_destroy();
}