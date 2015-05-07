<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\MoviesRequest;

use App\Movies;

class MoviesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$movies = Movie::all();
		return response()->json(['data' => $movies, 'code' => 200], 200);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MoviesRequest $req)
	{
		if(\Auth::user()->access == 1){
			$values = $req->only([
				'name', 
				'description', 
				'director',
				'genre',
				'year',
				'price'
			]);
			
			$movie = Movie::create($values);

			return response()->json(['message' => 'Movie Added.', 'data' => $movie, 'code' => 201], 201);
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$movie = Movie::find($id);
		if($movie){
			return response()->json(['data' => $movie, 'code' => 200], 200);
		} else {
			return response()->json(['message' => 'Movie Not Found.', 'code' => 404], 404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
		if(\Auth::user()->access == 1){
			$movie = Movie::find($id);
			if($movie){
				$movie->name = $req->get('name'); 
				$movie->description = $req->get('description'); 
				$movie->director = $req->get('director'); 
				$movie->genre = $req->get('genre'); 
				$movie->year = $req->get('year'); 
				$movie->price = $req->get('price'); 

				$movie->save();
				return response()->json(['message' => 'Movie Updated.', 'data' => $movie, 'code' => 201], 201);
			} else {
				return response()->json(['message' => 'Movie Not Found.', 'code' => 404], 404);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(\Auth::user()->access == 1){
			$movie = Movie::find($id);
			if($movie){
				$movie->delete();
				return response()->json(['message' => 'Movie Erased.', 'code' => 201], 201);
			} else {
				return response()->json(['message' => 'Movie Not Found.', 'code' => 404], 404);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}
}
