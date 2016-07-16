<?php

    /**
     * Class PublicFilter
     *
     * Demo filter that just prints stuff pre and post execution/
     */
    class PublicFilter extends Filter {
        public function __construct( ){
            // This is what the filter engine looks for in the controller method comments.
            $this->FilterId = "public";
        }

        public function PreExecution() {
            echo "Before method execution logging for public methods-";
        }

        public function PostExecution() {
            echo "After method execution logging for public methods";
        }
    }

    // Register the filter.
    MvcFilters::RegisterFilter(new PublicFilter());
