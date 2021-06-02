<?php


namespace app\Middleware;


use helperClasses\Request;

abstract class CoreMiddleware
{
    abstract public function handle(Request $request) : bool;
}
