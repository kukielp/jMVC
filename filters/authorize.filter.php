<?php

    /**
     * Class AuthorizeFilter
     *
     * Demo filter that just prints stuff pre and post execution/
     */
    class AuthorizeFilter extends Filter {
        public function __construct( ){
            // This is what the filter engine looks for in the controller method comments.
            $this->FilterId = "authorize";
        }
        
        public function PreExecution() {
            echo "Before method execution";
        }

        public function PostExecution() {
            echo "After method execution";
        }
    }

    // Register the filter.
    MvcFilters::RegisterFilter(new AuthorizeFilter());