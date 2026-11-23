<?php

namespace App\Support;

use App\Models\Admin;
use App\Models\AdminActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/** Writes the admin activity log. A logging failure never breaks the admin action. */
class ActivityLog
{
    public static function record(string $action, string $description, ?Admin $admin = null): void
    {
        try {
            $admin ??= request()->attributes->get('admin');
            if (! $admin && ($id = session('admin_id'))) {
                $admin = Admin::find($id);
            }

            AdminActivity::create([
                'admin_id' => $admin?->id,
                'admin_name' => $admin?->username ?? 'unknown',
                'action' => $action,
                'description' => Str::limit($description, 300, ''),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /** Readable name for a content item (title, menu name, heading...). */
    public static function itemName(Model $item): string
    {
        foreach (['title', 'nav_label', 'name', 'heading', 'label'] as $field) {
            $value = trim((string) $item->getAttribute($field));
            if ($value !== '') {
                return $value;
            }
        }

        return '#'.$item->getKey();
    }
}
