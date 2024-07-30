<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return $this->sendResponse(User::where('role', 3)->with(['role_data'])->get(), 'All Users');
    }

    public function show($id)
    {
        return $this->sendResponse(User::with(['role_data'])->find($id), 'User');
    }

    public function store(Request $request)
    {
        $data = $request->input();
        $data['password'] = Hash::make($request->password);

        $data = User::create($data);

        return $this->show($data->id);
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();

        return $this->sendResponse([], 'User deleted');
    }
}
