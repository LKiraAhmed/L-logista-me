<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //

    public function index()
    {
        if(auth()->user()){
        $user = auth()->user();
        $roles = Role::where('user_id', $user->id)->get();
        }
        else{
            return view('login');
        }
        return view('roles.index', compact('roles'));
    }
        public function create()
        {
            return view('roles.addroles');
        }
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $user = Auth::user(); 
        if(!$user){
            return redirect()->route('login');
        }
    
        $role = Role::create([
            'role_name' => $request->role_name,
            'description' => $request->description,
            'user_id' => $user->id, 
        ]);
    
        return redirect()->route('roles.index');
    }
    public function edit($id)
{
    $role = Role::findOrFail($id);
    return view('roles.edit', compact('role'));
}

    
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'role_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $role->update($request->all());
        return redirect()->route('roles.index');
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}
