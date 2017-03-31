<?php namespace GamingPassion\Controllers;

class PageController extends Controller
{
    public static function index()
    {
        return include __DIR__ . '/../Views/Templates/master.layout.php';
    }
}