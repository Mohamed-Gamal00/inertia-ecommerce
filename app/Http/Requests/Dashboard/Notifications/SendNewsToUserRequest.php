<?php

namespace App\Http\Requests\Dashboard\Notifications;

use Illuminate\Foundation\Http\FormRequest;

class SendNewsToUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
  public function rules()
  {
    return [
      'title'    => 'required|string|max:255',
      'body'     => 'required|string',
      'users'    => 'required|array|min:1',
      'users.*'  => 'required|integer|exists:send_news_to_users,id',
    ];
  }
}
