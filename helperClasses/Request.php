<?php


namespace helperClasses;


use Illuminate\Support\Collection;

class Request extends Collection
{
    protected Collection $url;
    protected Session $session;
    protected string $method;

    public function __construct($items = [])
    {
        parent::__construct(array_merge($items, $_GET, $_POST));
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $parsed = parse_url($url);
        $this->url = collect([
            'full_url' => $url,
            'protocol' => $parsed['scheme'] ?? null,
            'domain' => $parsed['host'] ?? null,
            'path' => $parsed['path'] ?? null,
        ]);

        $this->session = Session::getInstance();
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function url() {
        return $this->url;
    }

    public function session() {
        return $this->session;
    }

    public function method() {
        return $this->method;
    }
}
