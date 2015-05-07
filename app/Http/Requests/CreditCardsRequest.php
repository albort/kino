<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreditCardsRequest extends Request {

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
			'company' => 'required',
			'creditcard_number' => 'required', 
			'expiration_date' => 'required', 
			'security_code' => 'required'
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
