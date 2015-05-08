<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\UpdateOrderRequest;

use App\User;
use App\Order;
use App\OrderItem;

class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(\Auth::user()){
			if(\Auth::user()->access == 1){
				return Order::all();
			} else {
				return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
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
	public function show($id)
	{
		if(\Auth::user()){
			if(\Auth::user()->access == 1){
				$order = Order::find($id);
				if($order){
					$order->items;
					return $order;
				} else {
					return response()->json(['message' => 'Order Not Found.', 'code' => 404], 404);
				}
			} else {
				return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UpdateOrderRequest $req, $id)
	{
		if(\Auth::user()){
			if(\Auth::user()->access == 1){
				$order = Order::find($id);
				if($order){
					$order->status = $req->get('status'); 

					$order->save();
					return response()->json(['message' => 'Order Updated.', 'data' => $order, 'code' => 201], 201);
				} else {
					return response()->json(['message' => 'Order Not Found.', 'code' => 404], 404);
				}
			} else {
				return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
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
		if(\Auth::user()){
			if(\Auth::user()->access == 1){
				$order = Order::Find($id);
				if($order){
					$order->delete();
					return response()->json(['message' => 'Order Erased.', 'code' => 201], 201);
				} else {
					return response()->json(['message' => 'Order Not Found.', 'code' => 404], 404);
				}
			} else {
				return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	public function userOrders($id){
		if(\Auth::user()){
			if(\Auth::user()->access == 1){
				$user = User::Find($id);
				return $user->orders;
			} else {
				return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

}
