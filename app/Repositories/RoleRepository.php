<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Str;

class RoleRepository
{

    public function roleFindById($id)
    {
        return Role::findOrFail($id);
    }

    public function defaultRouteMapper()
    {
        $permissions = [];
        $allRoutes = checkPermissionAccessRouteName();
        foreach ($allRoutes as $routeName => $routeValues){
            foreach ($routeValues as $key => $val){
                $data = [$val['routeName'] => false];
                $merge = array_merge($permissions,$data);
                $permissions = $merge;
            }
        }

        return $permissions;
    }

    public function appendPermissionStoreAndUpdate($data)
    {
        $permissionList = [];
        foreach($data as $name => $permission){
            $permissionBool = $permission == 'true' ? true : false;
            $dataDefault = [$name => $permissionBool];
            $merge = array_merge($permissionList,$dataDefault);
            $permissionList = $merge;

            $parentRouteName = explodeByLastDelimiter($name);

            $containsCreate = Str::contains($name, '.create');
            if($containsCreate && $permissionBool == true){
                $dataPermissionStore = [$parentRouteName.'.store' => true];
                $mergeStore = array_merge($permissionList,$dataPermissionStore);
                $permissionList = $mergeStore;
            } else if($containsCreate && $permissionBool == false) {
                $dataPermissionStore = [$parentRouteName.'.store' => false];
                $mergeStore = array_merge($permissionList,$dataPermissionStore);
                $permissionList = $mergeStore;
            }

            $containsEdit = Str::contains($name, '.edit');
            if($containsEdit && $permissionBool == true){
                $dataPermissionStore = [$parentRouteName.'.update' => true];
                $mergeStore = array_merge($permissionList,$dataPermissionStore);
                $permissionList = $mergeStore;
            } else if($containsEdit && $permissionBool == false){
                $dataPermissionStore = [$parentRouteName.'.update' => false];
                $mergeStore = array_merge($permissionList,$dataPermissionStore);
                $permissionList = $mergeStore;
            }

//            $explodeName = explode('.',$name);
//            if(count($explodeName) > 1){
//                $containsCreate = Str::contains($name, 'create');
//                if($containsCreate && $permissionBool == true){
//                    $dataPermissionStore = [$explodeName[0].'.store' => true];
//                    $mergeStore = array_merge($permissionList,$dataPermissionStore);
//                    $permissionList = $mergeStore;
//                } else if($containsCreate && $permissionBool == false) {
//                    $dataPermissionStore = [$explodeName[0].'.store' => false];
//                    $mergeStore = array_merge($permissionList,$dataPermissionStore);
//                    $permissionList = $mergeStore;
//                }
//
//                $containsEdit = Str::contains($name, 'edit');
//                if($containsEdit && $permissionBool == true){
//                    $dataPermissionStore = [$explodeName[0].'.update' => true];
//                    $mergeStore = array_merge($permissionList,$dataPermissionStore);
//                    $permissionList = $mergeStore;
//                } else if($containsEdit && $permissionBool == false){
//                    $dataPermissionStore = [$explodeName[0].'.update' => false];
//                    $mergeStore = array_merge($permissionList,$dataPermissionStore);
//                    $permissionList = $mergeStore;
//                }
//            }
        }

        return json_encode($permissionList);
    }

    public function create($data)
    {
        $role = new Role();
        $role->name = $data['name'];
        $role->permissions = $this->appendPermissionStoreAndUpdate($this->defaultRouteMapper());
        $role->slug = createSlug($data['name']);
        $role->created_by = @user_info('id');
        $role->save();

        return $role;
    }

    public function update($data, $id)
    {
        $role = $this->roleFindById($id);
        $role->name = $data['name'];
        $role->slug = createSlug($data['name']);
        $role->updated_by = @user_info('id');
        $role->update();

        return $role;
    }

    public function delete($id)
    {
        $user = $this->roleFindById($id);
        $user->delete();

        return $user;
    }

    public function updatePermission($data,$id)
    {
        $role = $this->roleFindById($id);
        $role->permissions = $this->appendPermissionStoreAndUpdate($data['permissions']);
        $role->update();

        return $role;
    }
}
