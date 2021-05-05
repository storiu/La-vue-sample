<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Models\Error;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        $data = $this->repository->getAll();
        return response()->json($data);
    }

    public function getHobbiesByCategory(Request $request, $id)
    {
        $page = $this->getPage($request);

        if (!is_numeric($id)) {
            return response()->json(new Error('Invalid query'), 400);
        }

        $data = $this->repository->getHobbiesByCategory($id, $page);

        if (!isset($data)) {
            return response()->json(new Error('Resource not found'), 404);
        }

        return response()->json($data);
    }
}
