<?php
    // Includes.
    require_once("logging.component.php");

    /**
     * Class MvcFilters
     *
     * Manage MVC filters and filter execution.
     */
    class MvcFilters {

        // Private vars.
        private static $_filters = [];

        /**
         * Constructor.
         */
        public function __construct( ){
        }


        /**
         * Get the filters required for a controller-method call.
         *
         * @param Controller $controller    Controller context for filter annotations.
         * @param $method                   Method we are entering.
         * @return array                    Array of applicable filters.
         */
        private static function GetFilters(Controller $controller, $method) {
            $filters = [];
            $rflClass = new ReflectionClass($controller);

            // Loop over methods.
            foreach ($rflClass->getMethods() as $rflMethod)
            {
                // Check method name.
                if($rflMethod->getName() == $method) {

                    // Iterate over filters.
                    foreach(MvcFilters::$_filters as $filterid => $filter) {
                        /* @var $filter Filter */

                        // Iterate over comment lines.
                        foreach(explode("\n", $rflMethod->getDocComment()) as $cline) {
                            $cline = trim($cline);

                            // Check if it matches our filter.
                            if(substr($cline, 0, 3 + strlen($filterid)) == "* @" . $filterid ) {

                                // Find params.
                                $params = substr($cline, strpos($cline, "@" . $filterid) + strlen("@" . $filterid . " "));

                                // Set params and insert it into the filter list.
                                $filter->FilterParams = $params;
                                $filters[] = $filter;
                            }
                        }
                    }
                }
            }

            return $filters;
        }


        /**
         * Execute filters and call controller method.
         *
         * @param Controller $controller    Controller context reference.
         * @param $method                   Controller method to call.
         */
        public static function ProcessControllerMethod(Controller $controller, $method, $args) {
            // Get required filters.
            $filters = MvcFilters::GetFilters($controller, $method);

            // Do pre execution calls.
            foreach($filters as $filter) {
                /* @var $filter Filter */
                $filter->PreExecution();
            }

            // Call method and get view.
            $view = call_user_func_array(array($controller ,$method),$args);

            // Do post execution calls.
            foreach($filters as $filter) {
                /* @var $filter Filter */
                $filter->PostExecution();
            }

            // Return view.
            return $view;
        }


        /**
         * Register a filter.
         *
         * @param Filter $filter    Filter for registration.
         */
        public static function RegisterFilter(Filter $filter) {
            Logging::Log("Registering filter:" . $filter->FilterId);

            // Register the filter.
            if(!array_key_exists($filter->FilterId, MvcFilters::$_filters))
                MvcFilters::$_filters[$filter->FilterId] = $filter;
            else
                Logging::Log("Filter {$filter->FilterId} already registered.");
        }
    }


    /**
     * Class Filter
     *
     * Base filter class.
     */
    class Filter {
        public $FilterId;
        public $FilterParams;

        public function PreExecution() { echo "HEY!"; }
        public function PostExecution() {}
    }