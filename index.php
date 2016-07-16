<?php

    // Routing table.
    $routeTable = [
        '~/get/lost/(.*)?~' => '/go/away/$1/'
    ] ;

    // Load includes.
    require 'lib/kint/Kint.class.php';
    require 'globals.php';

    // Mvc components.
    require 'mvc/controller.component.php';
    require 'mvc/filter.component.php';
    require 'mvc/view.component.php';
    require 'mvc/route.component.php';

    // Custom filters.
    require 'filters/authorize.filter.php';
    require 'filters/public.filter.php';

    // Get the route data.
    $routeData = MvcRoute::GetRouteData($routeTable);

    // Start the session.
    session_start();

    // Check if the controller exists.
    $controllerPath = 'controller/' . strtolower($routeData['controller']) . '.php';
    if(!file_exists($controllerPath)) {
        // Create error controller.
        require_once "controller/mvcerror.php";
        $object = new MvcError();

        $routeData = array(
            "controller" => "error",
            "method" => "ControllerMissing",
            "args" => array()
        );
    } else {
        // Create controller.
        include $controllerPath;
        $object = new $routeData['controller'];
    }

    // Check to make sure appropriate method exists.
    if(!method_exists($object, $routeData['method'])) {
        // Create error controller.
        require_once "controller/mvcerror.php";
        $object = new MvcError();

        $routeData = array(
            "controller" => "error",
            "method" => "MethodMissing",
            "args" => array()
        );
    }

    // Create view from controller method result.
    global $view;
    $view = MvcFilters::ProcessControllerMethod($object, $routeData['method'], $routeData['args']);

    // Load up and process the view.
    $viewpath = "view/";
    if(isset($view['view'])){
        $viewpath .=  $view['view'];
    }else{
        $viewpath .=  $routeData['controller'] . '/' . $routeData['method'] .'.php';
    }
    MvcView::ProcessView($view, $viewpath);
