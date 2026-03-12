<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Requests\EditUserForCustomerRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('name');

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%");
            });
        }

        $users = $query->paginate(25);

        return new UserCollection($users);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function getUserInfo()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
    }

    public function update(EditUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->admin = $data['admin'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();
    }

    // Edit user for customer
    public function editUser(EditUserForCustomerRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ], 200);
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting user', 'error' => $e->getMessage()], 500);
        }
    }
}
