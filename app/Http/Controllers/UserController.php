<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\CheckOutRequest;

use App\Movie;
use App\Serie;
use App\SerieSeason;
use App\User;
use App\OrderItem;

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

	public function showOrders(){
		if(\Auth::user()){
			$user = \Auth::user();
			$orders = $user->orders;
			return response()->json(['data' => $orders, 'code' => 200], 200);
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	public function showOrder($id){
		if(\Auth::user()){
			$user = \Auth::user();
			$order = $user->orders()->find($id);
			if($order){
				$order->items;
				return response()->json(['data' => $order, 'code' => 200], 200);
			} else {
				return response()->json(['message' => 'Order Not Found.', 'code' => 404], 404);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	public function checkOut(CheckOutRequest $req){
		if(\Auth::user()){
			$user = \Auth::user();
			$credit_card_number = $req->get('credit_card');
			$credit_card = $user->creditCards()->where('creditcard_number', $credit_card_number)->first();
			if($credit_card){
				$shoppingCart = $user->shoppingCart;
				$total = 0;
				$order = $user->orders()->create([
					'credit_card' => $credit_card_number,
					'total' => $total,
					'status' => 'Processing'
				]);

				foreach($shoppingCart as $item){
					$article_type = $item->article_type;
					$article_id = $item->article_id;
					$article_amount = $item->article_amount;
					$order->items()->create([
						'article_type' => $article_type,
						'article_id' => $article_id,
						'article_amount' => $article_amount
					]);
					$total = $total + $item->total;
				}

				$order->total = $total;
				$order->save();

				$orderItems = $order->items;
				$shoppingCart = $user->shoppingCart()->delete();
				
				return response()->json(['data' => $shoppingCart, 'code' => 200], 200);
			} else {
				return response()->json(['message' => 'Credit Card Not Found.', 'code' => 404], 404);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}
}
