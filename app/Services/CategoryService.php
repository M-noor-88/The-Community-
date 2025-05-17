<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Exception;
class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepo) {}

    /**
     * @throws Exception
     */
    public function create(array $data): Category
    {
        if(!Auth::user()->hasRole('government_admin'))
        {
            throw new Exception("you dont have permission");
        }
        return $this->categoryRepo->create($data);
    }

    public function getAll(): Collection
    {
        return $this->categoryRepo->getAll();
    }

    public function delete(int $id): void
    {
        $this->categoryRepo->delete($id);
    }

}
