<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function get(Request $request, $offset, $anime) {
        $comments = DB::table('coments')
        ->where('anime', $anime)
        ->take(10)
        ->skip($offset)
        ->get();

        $allinfo;
        foreach($comments as $coment) {
            $user = User::where('id', $coment->user)->get();
            $allinfo[] = [$coment, $user];
        }

        return response()->json($allinfo);
    }
    public function update(Request $request, $id) {
        $coment = Coment::where('id', $id)->get();

        $coment->update($request->all());
        return response()->json('complited');
    }
    public function create(Request $request) {
        $coment = Coment::create($request->all());

        return response()->json($coment);
    }
    public function delete_my(Request $request, $id) {
        $coment = Coment::where('id', $id)->get();

        if (Auth::user()->id == $coment->user) {
            $coment->delete();
            return response()->json($coment);
        }
        return response()->json('error');
    }
    public function delete(Request $request, $id) {
        $coment = Coment::where('id', $id)->get();
        $coment->delete();
        
        return response()->json($coment);
    }
}
