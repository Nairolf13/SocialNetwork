<?php

class LogoutController extends Controller
{
    public function index()
    {
        session_start();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header("Location: /register");
        exit();
    }
}
