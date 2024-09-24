<?php

class Router
{
    public function start()
    {

        try {
            $url = $_SERVER['REQUEST_URI'];
            if ($url !== '/') {
                $controller = ucfirst(explode("/", $url)[1]) . "Controller";
                if (class_exists($controller)) {
                    
                    $controllerObject = new $controller();
                    if (method_exists($controllerObject, 'index')) {
                        $controllerObject->index();
                    } else {
                       
                        throw new Exception("Pas de méthode index dans ce contrôleur", 1);
                    }
                } else {
                   
                    throw new Exception("Ce contrôleur n'existe pas", 1);
                }
            } else {
                $controllerObject = new MainController();
                $controllerObject->index();
            }
        } catch (\PDOException $e) {
            echo($e->getMessage());
            
        }
        
    }
}
