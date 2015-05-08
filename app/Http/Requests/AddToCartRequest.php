<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddToCartRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'article_type' => 'required', 
			'article_id' => 'required', 
			'article_amount' => 'required',
			'serie_id'
		];
	}

	/**
	 * Get the proper failed validation response for the request.
	 *
	 * @param  array  $errors
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function response(array $errors)
	{
		return response()->json(['message' => $errors, 'code' => 422], 422);
	}

}
