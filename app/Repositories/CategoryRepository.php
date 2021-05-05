<?php

namespace App\Repositories;

use App\Models\GetAllCategories;
use App\Models\GetHobbiesByCategory;
use Illuminate\Support\Facades\DB;
use App\Models\Pagination;

class CategoryRepository extends Repository
{
    public function getAll()
    {
        $sql = 'SELECT * FROM categories';
        $data = DB::select($sql);
        return new GetAllCategories($data);
    }

    public function getHobbiesByCategory($id, $curPage)
    {
        $totalPages = $this->getCount('SELECT CEILING(COUNT(id) / ' . Constants::HOBBIES_PER_PAGE . ') as count
            FROM posts
            WHERE category_id = ?', [$id]);

        $categoryInfoSql = 'SELECT id, name, icon FROM categories WHERE id = ?';
        $categoryInfoData = DB::selectOne($categoryInfoSql, [$id]);

        $hobbiesInfoSql = 'SELECT p.id as pid, p.title, p.date, p.category_id, p.description, p.rating, p.photo,
            (SELECT COUNT(c.id) FROM comments c WHERE c.post_id = p.id) as commentsNb,
            u.id, u.name, u.nickname, u.avatar
            FROM posts p
            INNER JOIN users u ON p.user_id = u.id
            WHERE p.category_id IN (SELECT id FROM categories WHERE id = ?)
            ORDER BY p.date DESC
            LIMIT ' . Constants::HOBBIES_PER_PAGE . '
            OFFSET ' . ($curPage - 1) * Constants::HOBBIES_PER_PAGE;

        $hobbiesInfoData = DB::select($hobbiesInfoSql, [$id]);

        $pagination = new Pagination($curPage, $totalPages);

        if (!isset($categoryInfoData) || !isset($hobbiesInfoData)) {
            return null;
        }

        return new GetHobbiesByCategory($categoryInfoData, $hobbiesInfoData, $pagination);
    }
}
