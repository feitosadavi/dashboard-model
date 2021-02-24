<?php
    class SessionController {
        // construtores
        function __construct(){}

        // métodos
        function destroy() {
            session_unset();
            session_destroy();
        }
        function restart() {
            return session_regenerate_id();
        }
        function removeKey($key) {
            if( isset($_SESSION[$key]) ) {
                unset ($_SESSION[$key]);
                return true;
            } else {
                return false;
            }
        }
        function addKey($key, $value) {
            if( isset($_SESSION[$key]) ) {
                return false;
            } else {
                $_SESSION[$key] = $value;
                return true;
            }
        }
        function editKey($key, $value) {
            if( isset($_SESSION[$key]) ) {
                $_SESSION[$key] = $value;
                return true;
            } else {
                return false;
            }
        }
        function getId() {
            return session_id();
        }
        function getKey($key) {
            return !isset($_SESSION[$key]) ? null : $_SESSION[$key];
        }
    }
?>