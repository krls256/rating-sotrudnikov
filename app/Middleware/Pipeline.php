<?php


namespace app\Middleware;


use helperClasses\Request;
use Illuminate\Support\Collection;

class Pipeline
{
    protected Collection $pipe;

    public function __construct() {
        $this->pipe = collect();
    }

    public function pipe($middlewareClass) {
        $middleware = new $middlewareClass();
        $this->pipe->push($middleware);
    }

    public function run() {
        $request = new Request();
        foreach ($this->pipe as $Middleware) {
            $res = $Middleware->handle($request);
            if($res === false)
                break;
        }
    }
}
