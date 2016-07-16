<?php

    class Go extends Controller {

        public function __construct( ){
        }

        /**
         * @authorize
         */
        public function away( $key = 'default Key' ){
            $view = [];
            $view['route'] = $key;
            return $view;
        }
    }
