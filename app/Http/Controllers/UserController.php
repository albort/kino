<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\AddToCartRequest;

use App\Movie;
use App\Serie;
use App\SerieSeason;
use App\User;

class UserController extends Controller {

	public function showCart(){
		if(\Auth::user()){
			$user = \Auth::user();
			return $user->shoppingCart;
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	public function addtocart(AddToCartRequest $req){
		if(\Auth::user()){
			$article_type = $req->get('article_type');
			$article_id = $req->get('article_id');
			$article_amount = $req->get('article_amount');

			if($article_type=='Movies'){
				$movie = Movie::Find($article_id);
				if($movie){
					$price = $movie->price;
					$total = $price * $article_amount;
				} else {
					return response()->json(['message' => 'Article Not Found.', 'code' => 404], 404);
				}
			} elseif ($article_type == 'Series') {
				$serie = Serie::Find($req->get('serie_id'));
				$season = $serie->seasons()->where('season_number', $seasonID)->first();
				if($season){
					$article_id = $season->id;
					$price = $season->price;
					$total = $price * $article_amount;
				} else {
					return response()->json(['message' => 'Article Not Found.', 'code' => 404], 404);
				}
			} else {
				return response()->json(['message' => 'Article Type Not Found.', 'code' => 404], 404);
			}

			$user = \Auth::user();

			$user->shoppingCart()->create([
				'article_type' => $article_type,
				'article_id' => $article_id,
				'article_amount' => $article_amount,
				'total' => $total
			]);
			$shoppingCart = $user->shoppingCart;
			return response()->json(['message' => 'Shopping Cart Updated.', 'data' => $shoppingCart, 'code' => 201], 201);
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	public function deleteCart(){
		if(\Auth::user()){
			$user = \Auth::user();
			$shoppingCart = $user->shoppingCart()->delete();
			return response()->json(['message' => 'Shopping Cart Cleared.', 'data' => $shoppingCart, 'code' => 201], 201);
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

}
