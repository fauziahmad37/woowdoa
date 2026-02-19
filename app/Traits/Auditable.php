<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::storeLog('CREATE', null, $model->getAttributes());
        });

        static::updated(function ($model) {

            $changes = $model->getChanges();

            unset($changes['updated_at']);

            if (count($changes) > 0) {
                self::storeLog(
                    'UPDATE',
                    array_intersect_key($model->getOriginal(), $changes),
                    $changes
                );
            }
        });

        static::deleted(function ($model) {
            self::storeLog('DELETE', $model->getOriginal(),  null);
        });
    }

    protected static function storeLog($action, $oldData = null, $newData = null)
    {

        if ($oldData) {
            $oldData = self::cleanData($oldData);
        }

        if ($newData) {
            $newData = self::cleanData($newData);
        }

        AuditLog::create([
            'user_id' => Auth::id(), // Sanctum compatible
            'model' => class_basename(static::class),
            'action' => $action,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected static function cleanData($data)
    {
        $ignore = ['password', 'remember_token', 'updated_at', 'created_at'];

        return collect($data)
            ->except($ignore)
            ->map(function ($value, $key) use ($ignore) {

                // jika array nested
                if (is_array($value)) {
                    return collect($value)->except($ignore)->toArray();
                }

                return $value;
            })
            ->toArray();
    }
}
