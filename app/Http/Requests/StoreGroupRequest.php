<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CustomMessage;
use App\Models\Group;

class StoreGroupRequest extends FormRequest
{
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
		$id=\Request::input('id');
		$name=\Request::input('name');

		$message=false;
		
		if(!$id){
			
			$count=Group::where('name',$name)->count();
			if($count>0){
				$message=__('messages.Name unique');
			}
		}else{
			
			$data=Group::where('name',$name)->first();
			if(isset($data->id) && $data->id!=$id){
				$message=__('messages.Name unique');
			}
		}
		
        return [
            'name'=>['required','max:255',new CustomMessage($message)],
        ];
    }
	
	function messages()
	{
		return [
			'name.required'=>__('messages.Name required'),
			'name.max'=>__('messages.Name max 255'),
			'name.unique'=>__('messages.Name unique'),
		];
	}
}
