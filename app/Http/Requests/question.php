<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class question extends FormRequest
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
        return [
            'question'=>'required',
            'type'=>'required|in:choiceone,trueorfalse,complete,multiplechoice',
            'option1'=>'required_if:type,choiceone,trueorfalse,multiplechoice,complete',
            'option2'=>'required_if:type,choiceone,trueorfalse,multiplechoice',
            'option3'=>'required_if:type,choiceone,multiplechoice',
            'option4'=>'required_if:type,choiceone,multiplechoice',
            'correctanswer'=>'required',
            'mark'=>'required|integer',
            'exam_id'=>'integer|required',
        ];
    }
}
