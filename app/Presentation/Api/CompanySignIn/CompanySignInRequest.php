<?php

declare(strict_types=1);

namespace App\Presentation\Api\CompanySignIn;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 企業サインインリクエスト
 */
class CompanySignInRequest extends FormRequest
{
    /**
     * リクエストの認証を判定
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'remember' => 'boolean',
        ];
    }

    /**
     * バリデーションエラーメッセージ
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスは必須です',
            'email.email' => '有効なメールアドレスを入力してください',
            'password.required' => 'パスワードは必須です',
            'password.min' => 'パスワードは8文字以上で入力してください',
        ];
    }
}
