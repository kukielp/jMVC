<?php

    class Home extends Controller {

        public function __construct( ){
        }

        /**
         * @public
         */
        public function Index(){
            $view = [];
            $links = array( array( 'text' => 'Sample Call', 'path' => '/go/away'), array( 'text' =>  'Sample Route', 'path'  => '/get/lost')  );
            $view['links'] = $links;
            return $view;
        }
    }
