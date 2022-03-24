<?php

namespace Framework\Router;

use Framework\Router\Request;

class Route
{
    private array $verbs;
    private string $uri;
    private $callback;    
    private ?string $name = null;
    private array $params = [];

    public function __construct(array $verbs, string $uri, $callback)
    {
        $this->verbs = $verbs;
        $this->uri = '/' . trim($uri, '/');
        $this->callback = $callback;
    }

    public function setName(string $name): Route
    {
        $this->name = $name;
        return $this;
    }

    public function canRespondTo(string $verb): bool
    {
        return in_array($verb, $this->verbs);
    }

    private function extractParams($braces = true): array
    {
        $type = ($braces) ? 0 : 1;
        $found = preg_match_all('/{(.*?)}/', $this->uri, $matches);
        
        return ($found) ? $matches[$type] : [];
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    private function getSegments(): array
    {
        return [
            explode('/', $this->uri),
            explode('/', Request::getUri()),
        ];
    }

    private function matchSegments(): bool
    {
        list($segments, $request) = $this->getSegments();
        
        if (count($segments) != count($request)) return false;

        $params = $this->extractParams();

        foreach ($segments as $index => $segment) {
            $value = $request[$index];
            if ($segment == $value) continue;            
            if (in_array($segment, $params)) {
                $this->setParam($segment, $value);
                continue;
            }
            return false;
        }

        return true;
    }

    private function setParam(string $segment, string $value): void
    {
        $key = str_replace('}', '', str_replace('{', '', $segment));
        $this->params[$key] = $value;
    }

    public function matchRequest(): bool
    {
        if ($this->uri === Request::getUri() || $this->matchSegments())
            return true;

        return false;
    }
}