<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'name' => 'required|min:6|max:1000|unique:tasks',
            'photos.*' => 'sometimes|required|mimes:png,gif,jpeg,jpg,txt,pdf,doc',
            'duedate' => 'required',
            'priority' => 'required',
            'user' => 'required',
            'taskProject' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name for the task is required',
            'name.unique' => 'This name for this task has already been used',
            'name.mix' => 'The given name is too long',
            'name.min' => 'The given name is too short',
            'user.required' => 'Please Assign this new task to a member of your team',
            'taskProject.required' => 'Sorry a Task must belong to a project'
        ];
    }
}
