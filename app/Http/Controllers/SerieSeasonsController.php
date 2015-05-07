<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\SeasonsRequest;

use App\Serie;
use App\SerieSeason;

class SerieSeasonsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($serieID)
	{
		$serie = Serie::find($serieID);
		if($serie){
			return response()->json(['data' => $serie->seasons, 'code' => 200], 200);
		} else {
			return response()->json(['message' => 'Serie Not Found.', 'code' => 404], 404);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SeasonsRequest $req, $serieID)
	{
		if(\Auth::user()->access == 1){
			$serie = Serie::find($serieID);
			if($serie){
				$values = $req->only([
					"season_number",
					'episodes',
					'director',
					'year',
					'price'
				]);
				$season = $serie->seasons()->create($values);
				
				return response()->json(['message' => 'Season Added.', 'data' => $season, 'code' => 201], 201);
			} else {
				return response()->json(['message' => 'Serie Not Found.', 'code' => 404], 404);
			}
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
	public function show($serieID, $seasonID)
	{
		$serie = Serie::find($serieID);
		if($serie){
			$season = $serie->seasons()->where('season_number', $seasonID)->first();
			if($season){
				return response()->json(['data' => $season, 'code' => 200], 200);
			} else {
				return response()->json(['message' => 'Season Not Found.', 'code' => 404], 404);
			}			
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
	public function update($serieID, $seasonID)
	{
		if(\Auth::user()->access == 1){
			$serie = Serie::find($serieID);
			if($serie){
				$season = $serie->seasons()->where('season_number', $seasonID)->first();
				if($season){
					$season->season_number = $req->get('season_number'); 
					$season->episodes = $req->get('episodes'); 
					$season->director = $req->get('director'); 
					$season->year = $req->get('year'); 
					$season->price = $req->get('price'); 

					$season->save();
					return response()->json(['message' => 'Season Updated.', 'data' => $season, 'code' => 201], 201);
				} else {
					return response()->json(['message' => 'Season Not Found.', 'code' => 404], 404);
				}			
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
	public function destroy($serieID, $seasonID)
	{
		if(\Auth::user()->access == 1){
			$serie = Serie::find($serieID);
			if($serie){
				$season = $serie->seasons()->where('season_number', $seasonID)->first();
				if($season){
					$season->delete();
					return response()->json(['message' => 'Season Erased.', 'code' => 201], 201);
				} else {
					return response()->json(['message' => 'Season Not Found.', 'code' => 404], 404);
				}			
			} else {
				return response()->json(['message' => 'Serie Not Found.', 'code' => 404], 404);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

}
