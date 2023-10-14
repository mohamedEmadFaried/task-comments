<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use App;
use App\Helpers\Helper;
use App\Http\Requests\UserFormRequest;
 
 
 
 
use App\Support\Collection;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UserController extends SystemController
{
    public function index(UserFormRequest $request)
    {
        if ($request->isTablePagination) {
            $eloquentData =  User::select([
                'id',
                'username',
                'email',
                'phone',
                'in_block',
                'image',
                'created_at'
            ]);
            if ($request->created_at1 && $request->created_at2) {
                $eloquentData->whereBetween('created_at', [
                    $request->created_at1 . ' 00:00:00',
                    $request->created_at2 . ' 23:59:59'
                ]);
            }

            if ($request->status == 1) {
                $status = null;
                $eloquentData->where('in_block', $status);
            } elseif ($request->status == 2) {
                $eloquentData->where('in_block', '!=', null);
            }
            if ($request->name) {
                $eloquentData->where(function ($query) use ($request) {
                    $query->where('username', 'LIKE', '%' . $request->name . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->name . '%')
                        ->orWhere('phone', 'LIKE', '%' . $request->name . '%');
                });
            }
            // return $eloquentData->get();
            $eloquentData->orderBy('id', 'DESC');
            return Helper::tablePagination()
                ->eloquent($eloquentData)
                ->setHeadColumns([

                    __('User Name'),
                    __('Email'),
                    __('Phone'),
                    __('Image'),
                    __('Block'),
                    __('Action')

                ])

                ->addColumn('username')
                ->addColumn('email')
                ->addColumn('phone')
               

                ->addColumn('image', function ($data) {
                    if ($data->image == null) {
                        return '--';
                    }

                    return '<img src="' . Helper::path() . '/' .  $data->image . '" style="width: 40px; height: 40px;" />';
                })

                ->addColumn('block', function ($data) {
                    if (Helper::adminCan('admin.user.approved')) {
                        if ($data->in_block == null) {
                            return '<div class="custom-control custom-switch">
                        <input checked onchange="approvedStatus(\'' . route('admin.user.approved', $data->id) . '\');"  type="checkbox" class="custom-control-input" id="' . $data->id . '">
                        <label class="custom-control-label" for="' . $data->id . '"></label>';
                        } else {
                            return '<div class="custom-control custom-switch">
                        <input  onchange="approvedStatus(\'' . route('admin.user.approved', $data->id) . '\');"  type="checkbox" class="custom-control-input" id="' . $data->id . '">
                        <label class="custom-control-label" for="' . $data->id . '"></label>';
                        }
                    } else {
                        return 'you do not have permission';
                    }
                })
                ->addColumn('action', function ($data) {
                    $edit = '';
                    $delete = '';
                    $show = '';
                    if (Helper::adminCan('admin.user.edit')) {
                        $edit = '<a href="' . route('admin.user.edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    }
                    if (Helper::adminCan('admin.user.show')) {
                        $show = ' <a href="' . route('admin.user.show', $data->id) . '" class="action-icon"> <i class="mdi mdi-eye-circle-outline"></i></a>';
                    }
                    if (Helper::adminCan('admin.user.destroy')) {
                        $delete = '<a href="javascript:void(0);" onclick="deleteRecord(\'' . route('admin.user.destroy', $data->id) . '\');" data-token="' . csrf_token() . '" class="action-icon"> <i class="mdi mdi-delete"></i></a>';
                    }
                    return $edit . $show. $delete ;
                })
                ->render($request->items_per_page);
        } else {
            // View Data
            $this->viewData['breadcrumb'][] = [
                'text' => __('Customer')
            ];

            $this->viewData['pageTitle'] = __('Customer');

            return $this->view('user.index', $this->viewData);
        }
    }

    public function create()
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Customer'),
            'url' => route('admin.user.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Add Customer'),
        ];

        $this->viewData['pageTitle'] = __('Add Customer');

        return $this->view('user.create', $this->viewData);
    }

    public function store(UserFormRequest $request)
    {
        $requestData = $request->all();
        if ($request->file('image')) {
            $requestData['image'] =  Storage::disk('public')->put("user/)",  $request->file('image'));
        }
        if ($requestData['in_block'] == 1) {
            $requestData['in_block'] = null;
        } else {
            $requestData['in_block'] = Carbon::now();
        }
        $requestData['password'] =  bcrypt($requestData['password']);

        $insertData = User::create($requestData);

        if ($insertData) {
            return $this->response(
                true,
                200,
                __('Data has been added successfully'),
                [
                    'url' => route('admin.user.create')
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
    public function edit(User $user)
    {

        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Customer'),
            'url' => route('admin.user.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Edit (:name)', ['name' => $user->{'name_' . App::getLocale()}]),
        ];
 
        $this->viewData['pageTitle'] = __('Edit Customer');
        $this->viewData['result'] = $user;

        return $this->view('user.create', $this->viewData);
    }


    public function update(UserFormRequest $request, User $user)
    {
        $requestData = $request->all();

        if ($request->file('image')) {
            $requestData['image'] =  Storage::disk('public')->put("user/)",  $request->file('image'));
        } else {
            $requestData['image'] =  $user->image;
        }
        if ($requestData['in_block'] == 1) {
            $requestData['in_block'] = null;
        } else {
            $requestData['in_block'] = Carbon::now();
        }

        $updateData = $user->update($requestData);
        if ($updateData) {
            return $this->response(
                true,
                200,
                __('Data has been modified successfully'),
                [
                    'url' => route('admin.user.index')
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

    public function show(User $user)
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Customer'),
            'url' => route('admin.user.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Show (:name)', ['name' => $user->{'name_' . App::getLocale()}]),
        ];

        $this->viewData['pageTitle'] = __('Show Customer');
        $this->viewData['result'] = $user;
        
        return $this->view('user.show', $this->viewData);
    }
    public function destroy(User $user)
    {
        $user->delete();
        return $this->response(
            true,
            200,
            __('Data has been deleted successfully'),
            [
                'url' => route('admin.user.index')
            ]
        );
    }
  
    public function approvedStatus(User $user)
    {
        if ($user->status == 0) {
            $approved = 1;
        } elseif ($user->status == 1) {
            $approved = 0;
        }
        $updateData = $user->update([
            'in_block' => $approved
        ]);

        return $this->response(
            true,
            200,
            __('Data has been updatad successfully'),
            [
                'url' => route('admin.area.index')
            ]
        );
    }
}
