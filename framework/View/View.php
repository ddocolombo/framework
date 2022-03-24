<?php

namespace Framework\View;

class View
{
    private string $file;
    private array $params = [];

    public function __construct(string $path, array $params = [])
    {
        $path = str_replace('.', '/', $path);
        $this->file = '../app/view/' . $path . '.php';
        $this->params = $params;
    }

    public function create()
    {
        $file = $this->file;
        if (!file_exists($file))
            exit(sprintf(T('File: "%s", not found.'), $file));
        
        extract($this->params);
        require_once($file);
    }
}