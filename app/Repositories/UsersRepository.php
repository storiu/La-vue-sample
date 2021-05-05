<?php

namespace App\Repositories;

use App\Models\Admin\UsersList;
use App\Models\GetFollowers;
use App\Models\GetFollowing;
use Illuminate\Support\Facades\DB;
use App\Models\GetSingleUserHobbies;
use App\Models\Pagination;
use App\Models\User;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UsersRepository extends Repository
{
    public function getById($id)
    {
        $sql = 'SELECT id, name, nickname, email, avatar, is_admin
            FROM users
            WHERE id = ?';
        $userData = DB::selectOne($sql, [$id]);

        return new User($userData);
    }

    public function getInfoByUsername($username, $curPage, $curUserId)
    {
        $totalPages = $this->getCount('SELECT CEILING(COUNT(p.id) / ' . Constants::HOBBIES_PER_PAGE . ') as count
            FROM posts p
            INNER JOIN users u ON u.id = p.user_id
            WHERE u.nickname = ?', [$username]);

        $userInfoSql = 'SELECT id, name, nickname, avatar,
            (SELECT COUNT(id) FROM followers WHERE user_id = u.id) as followers,
            (SELECT COUNT(id) FROM followers WHERE follower_id = u.id) as following,
            (SELECT COUNT(id) FROM followers WHERE follower_id = ? AND user_id = u.id) as followed
            FROM users u WHERE nickname = ?';

        $userInfoData = DB::selectOne($userInfoSql, [$curUserId, $username]);
        if (!isset($userInfoData)) {
            return null;
        }

        $hobbiesInfoSql = 'SELECT p.*,
            (SELECT COUNT(c.id) FROM comments c WHERE c.post_id = p.id) as commentsNb
            FROM posts p
            WHERE p.user_id = ? ORDER BY date DESC
            LIMIT ' . Constants::HOBBIES_PER_PAGE . '
            OFFSET ' . ($curPage - 1) * Constants::HOBBIES_PER_PAGE;

        $hobbiesInfoData = DB::select($hobbiesInfoSql, [$userInfoData->id]);
        $pagination = new Pagination($curPage, $totalPages);

        return new GetSingleUserHobbies($userInfoData, $hobbiesInfoData, $pagination);
    }

    public function addFollower($userId, $followerId)
    {
        $countSql = 'SELECT COUNT(id) as count FROM followers WHERE user_id = ? AND follower_id = ?';
        $hasAlreadyFollower = $this->getCount($countSql, [$userId, $followerId]);
        if ($hasAlreadyFollower > 0) {
            return false;
        }

        $sql = 'INSERT INTO followers(user_id, follower_id) VALUES (?, ?)';

        try {
            DB::insert($sql, [$userId, $followerId]);
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function unfollow($userId, $followerId)
    {
        $sql = 'DELETE FROM followers WHERE user_id = ? AND follower_id = ?';
        $affectedRows = DB::delete($sql, [$userId, $followerId]);
        return $affectedRows > 0;
    }

    public function getFollowers($id)
    {
        $usersql = 'SELECT id, name, nickname, avatar FROM users WHERE id = ?';
        $userInfoData = DB::selectOne($usersql, [$id]);
        $sql = 'SELECT u.id, u.name, u.nickname, u.avatar
            FROM users u
            INNER JOIN followers f ON f.follower_id = u.id
            WHERE f.user_id = ?';
        $followersInfoData = DB::select($sql, [$id]);

        return new GetFollowers($userInfoData, $followersInfoData);
    }

    public function getFollowing($id)
    {
        $usersql = 'SELECT id, name, nickname, avatar FROM users WHERE id = ?';
        $userInfoData = DB::selectOne($usersql, [$id]);
        $sql = 'SELECT u.id, u.name, u.nickname, u.avatar
            FROM users u
            INNER JOIN followers f ON f.user_id = u.id
            WHERE f.follower_id = ?';
        $followingInfoData = DB::select($sql, [$id]);

        return new GetFollowing($userInfoData, $followingInfoData);
    }

    public function addComment($content, $userId, $postId)
    {
        $sql = 'INSERT INTO comments(content, user_id, post_id, date) VALUES (?, ?, ?, NOW())';

        try {
            DB::insert($sql, [$content, $userId, $postId]);
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function getAllForAdmin($curPage)
    {
        $totalPages = $this->getCount('SELECT CEILING(COUNT(id) / ' . Constants::USERS_PER_PAGE . ') as count FROM users');

        $sql = 'SELECT id, name, nickname, email, avatar, is_admin
            FROM users
            ORDER BY id ASC
            LIMIT ' . Constants::USERS_PER_PAGE . '
            OFFSET ' . ($curPage - 1) * Constants::USERS_PER_PAGE;

        $usersData = DB::select($sql);
        $pagination = new Pagination($curPage, $totalPages);

        return new UsersList($usersData, $pagination);
    }

    public function update($name, $nickname, $email, $password, $avatar, $isAdmin, $id)
    {
        $sql = 'UPDATE users SET name = ?, nickname = ?, email = ?';
        $sqlArgs = [$name, $nickname, $email];

        // If we modify user from admin page
        if ($isAdmin != null) {
            $sql .= ', is_admin = ?';
            array_push($sqlArgs, $isAdmin);
        }

        // If user wants to update his/her password
        if ($password != null) {
            $password = Hash::make($password);
            $sql .= ', password = ?';
            array_push($sqlArgs, $password);
        }

        // If user wants to update his/her avatar
        if ($avatar != null) {
            $this->deleteAvatar($id);
            $sql .= ', avatar = ?';
            array_push($sqlArgs, $avatar);
        }

        // Finish SQL query
        $sql .= ' WHERE id = ? LIMIT 1';
        array_push($sqlArgs, $id);

        try {
            DB::update($sql, $sqlArgs);
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        $this->deleteAvatar($id);
        $this->deletePostsPhotos($id);

        $sql = 'DELETE FROM users WHERE id = ? LIMIT 1';
        try {
            $affectedRows = DB::delete($sql, [$id]);
            if ($affectedRows == 0) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }

    private function deleteAvatar($id)
    {
        $user = $this->getById($id);
        $this->deleteUploadedPhoto($user->avatar, 'avatars');
    }

    private function deletePostsPhotos($userId)
    {
        $sql = 'SELECT photo FROM posts WHERE user_id = ?';
        $data = DB::select($sql, [$userId]);

        foreach($data as $item) {
            $this->deleteUploadedPhoto($item->photo, 'posts');
        }
    }

    private function deleteUploadedPhoto($photo, $type)
    {
        if (isset($photo)) {
            $fileName = public_path() . '/images/' . $type . '/' . $photo;
            try {
                unlink($fileName);
            } catch (ErrorException $e) {
                // Do nothing: file does not exist on the filesystem.
            }
        }
    }
}
