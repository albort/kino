<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\CreditCard;
use App\Http\Requests\CreateCreditCardsRequest;

class CreditCardsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{		
		if(\Auth::user()){
			$uID = \Auth::user()->id;
			$creditCards = CreditCard::where('user_id', '=', $uID);
			return response()->json(['data' => $creditCards, 'code' => 200], 200);
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateCreditCardsRequest $req)
	{
		if(\Auth::user()){
			$uID = \Auth::user()->id;

			$values = $req->only([
				'company',
				'creditcard_number',
				'expiration_date',
				'security_code'
			]);

			$creditCard = CreditCard::create($values);
			$creditCard->user_id = $uID;
			$creditCard->save(); 

			return response()->json(['message' => 'Credit Card Added.', 'data' => $creditCard, 'code' => 201], 201);
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
			$uID = \Auth::user()->id;
			$creditCard = CreditCard::find($id);
			if($creditCard->user_id == $uID){
				if($creditCard){
					return response()->json(['data' => $creditCard, 'code' => 200], 200);
				} else {
					return response()->json(['message' => 'Credit Card Not Found.', 'code' => 404], 404);
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
			$creditCard = CreditCard::find($id);
			$uID = \Auth::user()->id;
			if($creditCard->user_id == $uID){
				if($creditCard){
					$creditCard->delete();
					return response()->json(['mensaje' => 'Credit Card Erased. ', 'code' => 201], 201);
				} else {
					return response()->json(['mensaje' => 'Credit Card not Found.', 'code' => 404], 404);
				}
			} else {
				return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
			}
		} else {
			return response()->json(['message' => 'Permision Denied', 'code' => 401], 401);
		}
	}

}
