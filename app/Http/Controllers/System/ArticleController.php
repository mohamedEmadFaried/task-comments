<?php

namespace App\Http\Controllers\System;

use App\Models\Article;
use App;
use App\Helpers\Helper;
use App\Http\Requests\ArticleFormRequest;
use App\Support\Collection;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ArticleController extends SystemController
{
    public function index(ArticleFormRequest $request)
    {
        if ($request->isTablePagination) {
            $eloquentData =  Article::select([
                'id',
                'title',
                'content',
                'user_id',
                'type_user',
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
                    $query->where('title', 'LIKE', '%' . $request->name . '%')
                        ->orWhere('content', 'LIKE', '%' . $request->name . '%');
                });
            }
       
            $eloquentData->orderBy('id', 'DESC');
            return Helper::tablePagination()
                ->eloquent($eloquentData)
                ->setHeadColumns([

                    __('Title'),
                    __('Content'),
                    __('Auther'),
                    __('Action')

                ])

                ->addColumn('title')
                ->addColumn('content')

                ->addColumn('user_id', function ($data) {
                    if (isset($data->user)) {
                        return $data->user->username;
                    }

                    return '--';
                })
                ->addColumn('action', function ($data) {
                    $edit = '';
                    $delete = '';
                    $show = '';
                    if (Helper::adminCan('admin.article.edit')) {
                        $edit = '<a href="' . route('admin.article.edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    }
                    if (Helper::adminCan('admin.article.show')) {
                        $show = ' <a href="' . route('admin.article.show', $data->id) . '" class="action-icon"> <i class="mdi mdi-eye-circle-outline"></i></a>';
                    }
                    if (Helper::adminCan('admin.article.destroy')) {
                        $delete = '<a href="javascript:void(0);" onclick="deleteRecord(\'' . route('admin.article.destroy', $data->id) . '\');" data-token="' . csrf_token() . '" class="action-icon"> <i class="mdi mdi-delete"></i></a>';
                    }
                    return $edit . $show . $delete;
                })
                ->render($request->items_per_page);
        } else {
            // View Data
            $this->viewData['breadcrumb'][] = [
                'text' => __('Article')
            ];

            $this->viewData['pageTitle'] = __('Article');

            return $this->view('article.index', $this->viewData);
        }
    }

    public function create()
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Article'),
            'url' => route('admin.article.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Add Article'),
        ];

        $this->viewData['pageTitle'] = __('Add Article');

        return $this->view('article.create', $this->viewData);
    }

    public function store(ArticleFormRequest $request)
    {
        $requestData = $request->all();
       
        $requestData['user_id'] = auth()->user()->id;
        $requestData['type_user'] = 'admin';
        $insertData = Article::create($requestData);
        if ($insertData) {
            return $this->response(
                true,
                200,
                __('Data has been added successfully'),
                [
                    'url' => route('admin.article.create')
                ]
            );
        } else {
            return $this->response(
                false,
                11001,
                __('Sorry, the system is unable to add data')
            );
        }
    }
    public function edit(Article $article)
    {

        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Article'),
            'url' => route('admin.article.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Edit (:name)', ['name' => $article->{'name_' . App::getLocale()}]),
        ];

        $this->viewData['pageTitle'] = __('Edit Article');
        $this->viewData['result'] = $article;

        return $this->view('article.create', $this->viewData);
    }


    public function update(ArticleFormRequest $request, Article $article)
    {
        $requestData = $request->all();

        $updateData = $article->update($requestData);
        if ($updateData) {
            return $this->response(
                true,
                200,
                __('Data has been modified successfully'),
                [
                    'url' => route('admin.article.index')
                ]
            );
        } else {
            return $this->response(
                false,
                11001,
                __('Sorry, the system is unable to modify the data')
            );
        }
    }

    public function show(Article $article)
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Article'),
            'url' => route('admin.article.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Show (:name)', ['name' => $article->{'name_' . App::getLocale()}]),
        ];

        $this->viewData['pageTitle'] = __('Show Article');
        $this->viewData['result'] = $article;

        return $this->view('article.show', $this->viewData);
    }
    public function destroy(Article $article)
    {
        $article->delete();
        return $this->response(
            true,
            200,
            __('Data has been deleted successfully'),
            [
                'url' => route('admin.article.index')
            ]
        );
    }
}
