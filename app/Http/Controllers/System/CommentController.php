<?php

namespace App\Http\Controllers\System;

use App\Models\comment;
use App;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class CommentController extends SystemController
{
    public function index(Request $request)
    {
        if ($request->isTablePagination) {
            $eloquentData =  Comment::select([
                'id',
                'user_id',
                'article_id',
                'body',
                'created_at'
            ]);
            if ($request->created_at1 && $request->created_at2) {
                $eloquentData->whereBetween('created_at', [
                    $request->created_at1 . ' 00:00:00',
                    $request->created_at2 . ' 23:59:59'
                ]);
            }

            if ($request->name) {
                $eloquentData->where(function ($query) use ($request) {
                    $query->where('body', 'LIKE', '%' . $request->name . '%')
                        ->orWhereHas('user', function ($userQuery) use ($request) {
                            $userQuery->where('name', 'LIKE', '%' . $request->name . '%');
                        })
                        ->orWhereHas('Comment', function ($commentQuery) use ($request) {
                            $commentQuery->where('title', 'LIKE', '%' . $request->name . '%');
                        });
                });
            }
            $eloquentData->orderBy('id', 'DESC');
            return Helper::tablePagination()
                ->eloquent($eloquentData)
                ->setHeadColumns([

                    __('User'),
                    __('Article'),
                    __('Body'),
                    __('Action')
                ])


                ->addColumn('user', function ($data) {
                    if (isset($data->user)) {
                        return $data->user->username;
                    }

                    return '--';
                })
                ->addColumn('article_id', function ($data) {
                    if (isset($data->article)) {
                        return $data->article->title;
                    }

                    return '--';
                })
                ->addColumn('body')
                ->addColumn('action', function ($data) {
                    $edit = '';
                    $delete = '';
                    $show = '';
                    if (Helper::adminCan('admin.comment.edit')) {
                        $edit = '<a href="' . route('admin.comment.edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    }
                    if (Helper::adminCan('admin.comment.show')) {
                        $show = ' <a href="' . route('admin.comment.show', $data->id) . '" class="action-icon"> <i class="mdi mdi-eye-circle-outline"></i></a>';
                    }
                    if (Helper::adminCan('admin.comment.destroy')) {
                        $delete = '<a href="javascript:void(0);" onclick="deleteRecord(\'' . route('admin.comment.destroy', $data->id) . '\');" data-token="' . csrf_token() . '" class="action-icon"> <i class="mdi mdi-delete"></i></a>';
                    }
                    return $edit . $show . $delete;
                })
                ->render($request->items_per_page);
        } else {
            // View Data
            $this->viewData['breadcrumb'][] = [
                'text' => __('Comment')
            ];

            $this->viewData['pageTitle'] = __('Comment');

            return $this->view('comment.index', $this->viewData);
        }
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }
    public function edit()
    {
        abort(404);
    }


    public function update()
    {
        abort(404);
    }

    public function show(Comment $comment)
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Comment'),
            'url' => route('admin.comment.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Show (:name)', ['name' => $comment->{'name_' . App::getLocale()}]),
        ];

        $this->viewData['pageTitle'] = __('Show comment');
        $this->viewData['result'] = $comment;

        return $this->view('comment.show', $this->viewData);
    }
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $this->response(
            true,
            200,
            __('Data has been deleted successfully'),
            [
                'url' => route('admin.comment.index')
            ]
        );
    }

}
