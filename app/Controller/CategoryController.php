<?php

namespace App\Controller;

class CategoryController
{
    public function show($id) 
    {
        echo ($id);
    }

    public function edit(int $id)
    {
        return view('app');
    }
}