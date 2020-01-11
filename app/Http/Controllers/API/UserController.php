<?php

namespace boxe\Http\Controllers\API;

use Illuminate\Http\Request;
use boxe\Http\Controllers\Controller;
use boxe\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        return User::all(); //latest()->paginate(5);
    }


    public function store(Request $request)
    {   $this->validate($request, [
        'name' =>  ['required', 'string'],
        'email' => [ 'required', 'email', 'unique:users'],
        'type' =>  ['required'],
        'password'  => ['required', 'string', 'min:6'],
    ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
        ]);
    }

    public function show($id)
    {
        ///
    }

    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' =>  ['required', 'string', 'max:191'],
            'email' => [ 'required', 'email', 'max:191', 'unique:users,email,'.$user->id],
            'type' =>  [ ],
            'password'  => ['sometimes', 'string', 'min:6'],
        ]);

        $user->update($request->all());
        return ['message' => 'upate user'];
    }

    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'User Deleted'];
    }
}
