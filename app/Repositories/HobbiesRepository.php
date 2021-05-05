<?php

namespace App\Repositories;

use App\Models\ShowHobbies;
use App\Models\ShowComments;
use Illuminate\Support\Facades\DB;
use App\Models\Pagination;

class HobbiesRepository extends Repository
{
    public function add($user_id, $categoryId, $title, $description, $rating, $photo)
    {
        $sql = 'INSERT INTO posts(category_id, title, description, rating, photo, date, user_id) VALUES (?, ?, ?, ?, ?, now(), ?)';
        DB::insert($sql, [$categoryId, $title, $description, $rating, $photo, $user_id]);
    }

    public function showFollowingHobbies($id, $curPage)
    {
        $totalPages = $this->getCount('SELECT CEILING(COUNT(p.id) / ' . Constants::HOBBIES_PER_PAGE . ') as count
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            WHERE p.user_id IN (SELECT user_id FROM followers WHERE follower_id = ?)', [$id]);

        $sql = 'SELECT p.id as pid, p.title, p.description, p.rating, p.photo, p.date, p.category_id,
            (SELECT COUNT(c.id) FROM comments c WHERE c.post_id = p.id) as commentsNb,
            u.id, u.name, u.nickname, u.avatar
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            WHERE p.user_id IN (SELECT user_id FROM followers WHERE follower_id = ?)
            ORDER BY date DESC
            LIMIT ' . Constants::HOBBIES_PER_PAGE . '
            OFFSET ' . ($curPage - 1) * Constants::HOBBIES_PER_PAGE;

        $ShowHobbiesData = DB::select($sql, [$id]);
        $pagination = new Pagination($curPage, $totalPages);

        return new ShowHobbies($ShowHobbiesData, $pagination);
    }

    public function getCommentsById($id, $curPage)
    {
        $totalPages = $this->getCount('SELECT CEILING(COUNT(id) / ' . Constants::COMMENTS_PER_PAGE . ') as count
            FROM comments
            WHERE post_id = ?', [$id]);

        $sql = 'SELECT c.id as cid, c.content,
            u.id, u.name, u.nickname, u.avatar
            FROM comments c
            INNER JOIN users u ON c.user_id = u.id
            WHERE c.post_id = ?
            ORDER BY c.id DESC
            LIMIT ' . Constants::COMMENTS_PER_PAGE . '
            OFFSET ' . ($curPage - 1) * Constants::COMMENTS_PER_PAGE;

        $commentsData = DB::select($sql, [$id]);
        $pagination = new Pagination($curPage, $totalPages);

        return new ShowComments($commentsData, $pagination);
    }
}
