<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Anime;

class AnimeController extends Controller
{
    //
    public function get_id(Request $request, $id) {
        $anime =  Anime::find($id);

        return response()->json($anime);
    }
    public function get(Request $request, $offset) {
        $animes = DB::table('animes')->take(10)->skip($offset)->get();

        $allanimes;
        foreach($animes as $anime) {
            $author = Author::where('id' ,$anime->author)->get();

            $allanimes[] = [$anime, $author];
        }

        return response()->json($allanimes);
    }
    public function update(Request $request, $id) {
        $anime = Anime::where('id', $id)->get();

        $anime->update($request->all());
        return response()->json($anime);
    }
    public function create(Request $request, $id) {
        $anime = Anime::create($request->all());

        return response()->json($anime);
    }
    public function delete(Request $request, $id) {
        $anime = Anime::where('id', $id)->get();

        $anime->delete();
        return response()->json('complited');
    }
    public function get_name(Request $request, $name) {
        $anime = Anime::where('name', $name)->get();

        return response()->json($anime);
    }
}
