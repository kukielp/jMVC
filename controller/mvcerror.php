<?php

    /**
     * Class MvcError
     *
     * Standard class for handling MVC errors.
     */
    class MvcError extends Controller {

        /**
         * Method fired when there is a controller missing error.
         */
        public function ControllerMissing() {
            $view = [];
            $view['view'] = "error/error.php";

            return $view;
        }

        /**
         * Method fired when there is a method missing error.
         */
        public function MethodMissing() {
            $view = [];
            $view['view'] = "error/error.php";

            return $view;
        }
    }