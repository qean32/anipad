<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create(Request $request) {
        if ($request->hasFile('ava')) {
            $validator = Validator::make($request->all(), [
                // ...
            ]);

            $validator->setCustomMessage([
                'required' => ':attribute обязательное поля'
            ]);
            
            if ($validator->fails()) {
                return response()->json('uncomplited');
            }

            $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 1,
                'ava' => $imageName,
            ]);

            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            return response()->json($user);
        }
        return response()->json('uncomplited');
    }
    public function update_file(Request $request, $id) {
        if ($request->hasFile('ava')) {
            $user = User::FindOrFail($id);

            $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $user->update(['ava' => $imageName]);

            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            return response()->json($user);
        }
        return response()->json('uncomplited');
    }
    public function get() {
        $users = User::all(); 
        return response()->json($users);
    }
    public function get_id(Request $request, $id) {
        $user = User::FindOrFail($id);
        return response()->json($user);
    }
    public function ban(Request $request, $id) {
        $user = User::where('id', $id)->get();

        $user->ban = true;
        return response()->json('complited');
    }
    public function auth(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) 
            return response()->json($user->createToken('token')->plainTextToken);
    }
    public function logout(Request $request) {
        Auth::user()->currentToken()->delete();

        return response()->json('complited');
    }
}
