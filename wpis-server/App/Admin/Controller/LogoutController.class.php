<?php
/**
 *
 * 
 * 
 * 
 * 
 * 
 *
 **/

namespace Admin\Controller;

class LogoutController extends BaseController
{
    public function index()
    {
        cookie('auth', null);
        session('uid',null);
        $url = U("login/index");
        header("Location: {$url}");
        exit(0);
    }
}