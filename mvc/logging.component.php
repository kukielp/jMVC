<?php
    class Logging {
        private static $_log = array();

        public static function Log($message) {
            // Add message to log.
            Logging::$_log[] = $message;
        }

        public static function FetchLog() {
            return Logging::$_log;
        }
    }
?>