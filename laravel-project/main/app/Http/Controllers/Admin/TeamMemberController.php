<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Model;

class TeamMemberController extends ResourceController
{
    protected function model(): string
    {
        return TeamMember::class;
    }

    protected function key(): string
    {
        return 'team';
    }

    protected function label(): string
    {
        return 'Team member';
    }

    protected function rules(?Model $item): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'role' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
