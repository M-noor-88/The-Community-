<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function getAll(): Collection
    {
        return Category::all();
    }

    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete();
    }
}
