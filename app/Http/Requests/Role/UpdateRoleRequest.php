<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Models\Role;

class UpdateRoleRequest extends FormRequest
{

    /**
     * Determine if the Role is authorized to make this request.
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
        return Role::$rules;
    }
}
