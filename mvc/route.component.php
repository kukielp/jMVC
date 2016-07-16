<?php

    /**
     * Class MvcRoute
     *
     * Manage route detection.
     */
    class MvcRoute {

        /**
         * @param $routes       Routing table information.
         * @return array        Matching route data.
         */
        public static function GetRouteData($routes) {
            // Get request URI.
            $u = $_SERVER['REQUEST_URI'];

            // Take out query params.
            if(strpos($u, "?") > -1) {
                $u = substr($u, 0, strpos($u, "?"));
            }

            // Match the route.
            $matchedRoute = false;

            foreach ($routes as $route => $key) {
                preg_match($route, $u, $matches);
                if( count($matches) > 0 ){
                    $u = preg_replace($route, $key, $u);

                    $matchedRoute = true;
                    break;
                }
            }

            // Split up the resulting route.
            $routeParts = [];
            $expl = array_filter(explode('/', $u));
            foreach($expl as $e) { $routeParts[] = $e; }

            // Check if we have enough to find a controller and method.
            if(count($routeParts) >= 2) {
                // Controller and method are the first two elements..
                $controller = $routeParts[0];
                $method = $routeParts[1];
            } else {
                // Not enough route info, assume default.
                $controller = 'Home';
                $method = 'Index';
            }

            // Get query params.
            MvcRoute::ParseQueryParams();

            // Setup and return the result.
            $result = [];
            $result['controller'] = $controller;
            $result['method'] = $method;
            $result['args'] = MvcRoute::ParseRouteParams($routeParts);
            return $result;
        }


        /**
         * @param $routeParts       Route elements.
         * @return array            Resulting params.
         */
        private static function ParseRouteParams($routeParts) {
            $result = [];

            $idx = 2;
            $key = true;
            $lastKey = "";

            // Make sure we can even get a param out.
            if(count($routeParts) > 2) {

                // Iterate over each route part.
                while($idx < count($routeParts)) {

                    // If we are setting a key.
                    if($key) {
                        $result[$routeParts[$idx]] = "";
                        $lastKey = $routeParts[$idx];
                    } else
                        // Else set the value.
                        $result[$lastKey] = $routeParts[$idx];

                    // Flip key/val flag, move to next index.
                    $key = !$key;
                    $idx ++;
                }
            }

            return $result;
        }

        /**
         * Parse the query params past the ?
         */
        private static function ParseQueryParams() {
            $q = $_SERVER['REQUEST_URI'];
            $q = substr($q, strpos($q, "?") + 1);
            $q = explode("&", $q);

            $result = [];

            foreach($q as $x) {
                $y = explode("=", $x);
                if(count($y) > 1)
                    $result[$y[0]] = $y[1];
            }

            $_GET = $result;
        }


        /**
         * Parse slash separated params from the URL. (For when route params just don't cut it)
         *
         * @param string $prefix        Disregard beginning of URL if needed.
         * @param array $defaults       Default params struct.
         */
        public static function ParseUrlParams($prefix = "", $defaults = []) {
            $params = $defaults;

            $u = $_SERVER['REQUEST_URI'];
            $u = str_replace($prefix, "", $u);

            while(strlen($u) > 0 && substr($u, 0, 1) == "/")
                $u = substr($u, 1);

            $u = explode("/", $u);
            $u = array_filter($u); // Remove blank entries.
            if(count($u) >= 2) {
                for($i = 0; $i < count($u); $i += 2) {
                    if($i + 1 <= count($u) - 1)
                        $params[$u[$i]] = urldecode($u[$i + 1]);
                }
            }

            // Filter the data (Prevent XSS).
            $_GET = filter_var_array($params, FILTER_SANITIZE_STRING);
        }
    }
