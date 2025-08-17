<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable)
    {
        if(!auth()->user()->hasPermission('role_read'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return $dataTable->render('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!auth()->user()->hasPermission('role_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermission('role_create'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'company_id' => auth()->user()->company_id
        ]);

        $permission = new Permission();
        $permission->role_id = $role->id;
        $permission->permission = '[]';
        $permission->save();

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!auth()->user()->hasPermission('role_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        $role = Role::find($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!auth()->user()->hasPermission('role_edit'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::find($id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('roles.index')->with('success', 'Role Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->hasPermission('role_delete'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $role = Role::with('users')->find($id);
        if(count($role->users) > 0) {
            return redirect()->route('roles.index')->with('error', 'Role cannot be deleted because it has users');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role Deleted successfully');
    }
    public function permissions(string $id,Request $request)
    {
        if(!auth()->user()->hasPermission('role_permissions'))
        {
            return redirect()->back()->with('error', 'You do not have permission to access this feature.');
        }
        $role = Role::find($id);

        $permission = Permission::where('role_id',$id)->first();
        $all_permissions = $permission ? json_decode($permission->permissions) : [];
        if($request->isMethod('post')){

            $permissions = [];
            foreach ($request->all() as $key => $value) {
                if($key != "_token"){
                    array_push($permissions, $key);
                }
            }
            $permissions = json_encode($permissions);
            if($permission){
                $permission->permissions = $permissions;
                $permission->update();
            }else{
                $permission = new Permission();
                $permission->role_id = $id;
                $permission->permissions = $permissions;
                $permission->save();
            }
            return redirect()->back()->with('success','Permissions updated successfully');  
        }
        return view('roles.permissions', compact('role','permission','all_permissions'));
    }
}
