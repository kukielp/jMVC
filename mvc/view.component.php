<?php

    /**
     * Class MvcView
     *
     * Manage view calling.
     */
    class MvcView {

        // Private vars.
        private static $_viewdata = [];
        private static $_viewpath = "";

        /**
         * Set the viewdata and load the layour.
         *
         * @param $view     View data.
         */
        public static function ProcessView($view, $viewpath) {
            // Copy view data and view path.
            MvcView::$_viewdata = $view;
            MvcView::$_viewpath = $viewpath;

            // Find thae layour path.
            $layoutpath = "view/";
            if(isset($view['layout'])) {
                $layoutpath .= $view['layout'];

                // Handle no layout.
                if($view['layout'] == "none") {
                    MvcView::RenderBody();
                    return;
                }
            } else
                $layoutpath .= "_shared/layout.php";

            // Include the layout.
            include $layoutpath;
        }

        /**
         *  Load up the view page.
         */
        public static function RenderBody() {
            global $view;
            $view = MvcView::$_viewdata;
            include MvcView::$_viewpath;
        }
    }