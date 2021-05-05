<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use App\Models\Error;
use Illuminate\Support\Facades\Auth;

class UsersApiController extends Controller
{
    protected $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getById($id)
    {
        if (!is_numeric($id)) {
            return $this->error('Invalid query');
        }

        $data = $this->repository->getById($id);
        return response()->json($data);
    }

    public function getInfoByUsername(Request $request, $username)
    {
        $userId = Auth::id();
        $page = $this->getPage($request);
        $data = $this->repository->getInfoByUsername($username, $page, $userId);

        if (!isset($data)) {
            return response()->json(new Error('Resource not found'), 404);
        }

        return response()->json($data);
    }

    public function follow($id)
    {
        $userId = Auth::id();

        if (!is_numeric($id)) {
            return $this->error('Invalid query');
        }

        if (!$this->repository->addFollower($id, $userId)) {
            return $this->error('Invalid query');
        }

        return response('{}', 201, ['Content-Type' => 'application/json']);
    }

    public function unfollow($id)
    {
        $userId = Auth::id();

        if (!is_numeric($id)) {
            return $this->error('Invalid query');
        }

        if (!$this->repository->unfollow($id, $userId)) {
            return response()->json(new Error('Not found'), 404);
        };

        return response('{}', 200, ['Content-Type' => 'application/json']);
    }

    public function getFollowers($id)
    {
        if (!is_numeric($id)) {
            return $this->error('Invalid query');
        }

        $data = $this->repository->getFollowers($id);
        return response()->json($data);
    }

    public function getFollowing($id)
    {
        if (!is_numeric($id)) {
            return $this->error('Invalid query');
        }

        $data = $this->repository->getFollowing($id);
        return response()->json($data);
    }

    public function addComment(Request $request, $id)
    {
        $userId = Auth::id();

        if (!is_numeric($id)) {
            return $this->error('Invalid query');
        }

        $content = $request->input('content');

        if (!isset($content)) {
            return $this->error('You must specify a comment.');
        }

        if (!$this->repository->addComment($content, $userId, $id)) {
            return $this->error('Invalid query');
        }

        return response('{}', 201, ['Content-Type' => 'application/json']);
    }

    public function getAllForAdmin(Request $request)
    {
        $page = $this->getPage($request);
        $data = $this->repository->getAllForAdmin($page);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        $username = $request->input('nickname');

        if (!preg_match("/^[A-Za-z0-9-_]{1,15}$/", $username)) {
            return $this->error('The username may only contain letters, numbers, dashes and underscores and may not be greater than 15 characters.');
        }

        $email = $request->input('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->error('Invalid email');
        }

        $password = $request->input('password');
        if ($password != null && strlen($password) < 8) {
            return $this->error('The password must be at least 8 characters.');
        }

        $base64Avatar = $request->input('avatar');
        $avatar = $this->saveBase64ImageToFileSystem($base64Avatar, 'avatars');

        $isAdmin = $request->input('is_admin');

        if (!$this->repository->update($name, $username, $email, $password, $avatar, $isAdmin, $id)) {
            return $this->error('Invalid query');
        };

        return response('{}', 200, ['Content-Type' => 'application/json']);
    }

    public function delete($id)
    {
        $userId = Auth::id();

        if ($id == $userId) {
            return $this->error('You are not allowed to delete yourself.');
        }

        $success = $this->repository->delete($id);
        if (!$success) {
            return $this->error('Error deleting user ' . $id);
        }

        return response('{}', 200, ['Content-Type' => 'application/json']);
    }

    private function error($message) {
        return response()->json(new Error($message), 400);
    }
}
