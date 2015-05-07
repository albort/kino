<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\SeriesRequest;

use App\Serie;

class SeriesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$series = Serie::all();
		return response()->json(['data' => $series, 'code' => 200], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SeriesRequest $req)
	{
		if(\Auth::user()->access == 1){
			$values = $req->only([
				'name', 
				'description', 
				'genre'
			]);
			
			$serie = Serie::create($values);

			return response()->json(['message' => 'Serie Added.', 'data' => $serie, 'code' => 201], 201);
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
		$serie = Serie::find($id);
		if($serie){
			return response()->json(['data' => $serie, 'code' => 200], 200);
		} else {
			return response()->json(['message' => 'Serie Not Found.', 'code' => 404], 404);
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
			$serie = Serie::find($id);
			if($serie){
				$serie->name = $req->get('name'); 
				$serie->description = $req->get('description'); 
				$serie->genre = $req->get('genre'); 

				$serie->save();
				return response()->json(['message' => 'Serie Updated.', 'data' => $serie, 'code' => 201], 201);
			} else {
				return response()->json(['message' => 'Serie Not Found.', 'code' => 404], 404);
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
			$serie = Serie::find($id);
			if($serie){
				$serie->delete();
				return response()->json(['message' => 'Serie Erased.', 'code' => 201], 201);
			} else {
				return response()->json(['message' => 'Serie Not Found.', 'code' => 404], 404);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

}
