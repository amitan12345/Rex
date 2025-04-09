<?php

declare(strict_types=1);

namespace App\Presentation\Api\CompanySignOut;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 企業サインアウトリクエスト
 */
class CompanySignOutRequest extends FormRequest
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
        return [];
    }
}
