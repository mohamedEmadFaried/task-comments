<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Support\Facades\Storage;

use App;
use App\Helpers\Helper;
use App\Http\Requests\AdminFormRequest;
 
use App\Models\Admin;

class AdminController extends SystemController
{
    public function index(AdminFormRequest $request)
    {
        if ($request->isTablePagination) {
            $eloquentData =  Admin::select([
                'id',
                'username',
                'email',
                'last_login',
                'status',
                'permission_group_id',
                'created_at'
            ]);
            if ($request->created_at1 && $request->created_at2) {
                $eloquentData->whereBetween('created_at', [
                    $request->created_at1 . ' 00:00:00',
                    $request->created_at2 . ' 23:59:59'
                ]);
            }
            if ($request->status == 2) {
                $status = 0;
                $eloquentData->where('status', $status);
            } elseif ($request->status == 1) {
                $eloquentData->where('status', $request->status);
            }
            if ($request->name) {
                $eloquentData->where(function ($query) use ($request) {
                    $query->where('username', 'LIKE', '%' . $request->name . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->name . '%')
                        ->orWhereHas('permissionGroup', function ($q) use ($request) {
                            $q->where('name', 'LIKE', '%' . $request->name . '%');
                        });
                });
            }
            $eloquentData->orderBy('id', 'DESC');
            return Helper::tablePagination()
                ->eloquent($eloquentData)
                ->setHeadColumns([
                    __('User Name'),
                    __('Email'),
                    __('Permission Group'),
                    __('Last Login'),
                    __('Status'),
                    __('Action')

                ])
                ->addColumn('username')
                ->addColumn('email')
                ->addColumn('permissionGroup', function ($data) {
                    if (isset($data->permissionGroup)) {
                        return $data->permissionGroup->name;
                    } else {
                        return '--';
                    }
                })
                ->addColumn('last_login')

                ->addColumn('status', function ($data) {
                    if (Helper::adminCan('admin.admins.approved')) {
                        if ($data->status == 1) {
                            return '<div class="custom-control custom-switch">
                        <input checked onchange="approvedStatus(\'' . route('admin.admins.approved', $data->id) . '\');"  type="checkbox" class="custom-control-input" id="' . $data->id . '">
                        <label class="custom-control-label" for="' . $data->id . '"></label>';
                        } elseif ($data->status == 0) {
                            return '<div class="custom-control custom-switch">
                        <input  onchange="approvedStatus(\'' . route('admin.admins.approved', $data->id) . '\');"  type="checkbox" class="custom-control-input" id="' . $data->id . '">
                        <label class="custom-control-label" for="' . $data->id . '"></label>';
                        }
                    } else {
                        return 'you do not have permission';
                    }
                })
                ->addColumn('action', function ($data) {
                    $edit = '';
                    $delete = '';
                    if (Helper::adminCan('admin.admins.edit')) {
                        $edit = '<a href="' . route('admin.admins.edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    }
                    if (Helper::adminCan('admin.admins.destroy')) {
                        $delete = '<a href="javascript:void(0);" onclick="deleteRecord(\'' . route('admin.admins.destroy', $data->id) . '\');" data-token="' . csrf_token() . '" class="action-icon"> <i class="mdi mdi-delete"></i></a>';
                    }
                    return $edit . $delete;
                })
                ->render($request->items_per_page);
        } else {
            // View Data
            $this->viewData['breadcrumb'][] = [
                'text' => __('Admin')
            ];

            $this->viewData['pageTitle'] = __('Admin');

            return $this->view('admins.index', $this->viewData);
        }
    }

    public function create()
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Admin'),
            'url' => route('admin.admins.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Add Admin'),
        ];

        $this->viewData['pageTitle'] = __('Add Admin');

        return $this->view('admins.create', $this->viewData);
    }

    public function store(AdminFormRequest $request)
    {
        $requestData = $request->all();

        $requestData['password'] =  bcrypt($requestData['password']);
        $insertData = Admin::create($requestData);

        if ($insertData) {
            return $this->response(
                true,
                200,
                __('Data has been added successfully'),
                [
                    'url' => route('admin.admins.create')
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
    public function edit(Admin $admin)
    {

        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Admin'),
            'url' => route('admin.admins.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Edit (:name)', ['name' => $admin->username]),
        ];

        $this->viewData['pageTitle'] = __('Edit Admin');
        $this->viewData['result'] = $admin;

        return $this->view('admins.create', $this->viewData);
    }


    public function update(AdminFormRequest $request, Admin $admin)
    {
        $requestData = $request->all();
        $requestData['password'] =  bcrypt($requestData['password']);

        $updateData = $admin->update($requestData);
        if ($updateData) {
            return $this->response(
                true,
                200,
                __('Data has been modified successfully'),
                [
                    'url' => route('admin.admins.index')
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

    public function show(Admin $admin)
    {
        // Main View Vars
        $this->viewData['breadcrumb'][] = [
            'text' => __('Admin'),
            'url' => route('admin.admins.index')
        ];

        $this->viewData['breadcrumb'][] = [
            'text' => __('Show (:name)', ['name' => $admin->{'name_' . App::getLocale()}]),
        ];

        $this->viewData['pageTitle'] = __('Show Admin');
        $this->viewData['result'] = $admin;

        return $this->view('admins.show', $this->viewData);
    }
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return $this->response(
            true,
            200,
            __('Data has been deleted successfully'),
            [
                'url' => route('admin.admins.index')
            ]
        );
    }
    public function getCity($country)
    {
        // dd($country);
        $cities = City::where('country_id', $country)->get();
        return $this->response(
            true,
            200,
            __('Data has been get successfully'),
            $cities
        );
    }
    public function getArea($areaId)
    {
        $areas = Area::where('city_id', $areaId)->get();
        return $this->response(
            true,
            200,
            __('Data has been get successfully'),
            $areas

        );
    }
    public function approvedStatus(Admin $admin)
    {
        if ($admin->status == 0) {
            $approved = 1;
        } elseif ($admin->status == 1) {
            $approved = 0;
        }
        // return $approved;
        $updateData = $admin->update([
            'status' => $approved
        ]);

        return $this->response(
            true,
            200,
            __('Data has been updatad successfully'),
            [
                'url' => route('admin.admins.index')
            ]
        );
    }
}
