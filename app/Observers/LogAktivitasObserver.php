<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;

class LogAktivitasObserver
{
    private static $logged = false;

    public function creating($model)
    {
        if (!self::$logged) {
            $this->logActivity($model, 'create', $model->getDirty());
            self::$logged = true;
        }
    }

    public function updating($model)
    {
        if (!self::$logged) {
            $this->logActivity($model, 'update', $model->getDirty());
            self::$logged = true;
        }
    }

    public function deleting($model)
    {
        if (!self::$logged) {
            $this->logActivity($model, 'delete', $model->toArray());
            self::$logged = true;
        }
    }


    private function logActivity($model, $action, $data)
    {
        if ($this->shouldLog(Auth::user())) {
            LogAktivitas::create([
                'id_user' => Auth::id(),
                'user_role' => Auth::user()->role ?? null,
                'model' => class_basename($model),
                'aksi' => $action,
                'data' => $data,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    /**
     * Check if the user role is eligible for logging.
     */
    private function shouldLog($user)
    {
        return $user && in_array($user->role, ['Admin', 'Karyawan', 'Konsumen']);
    }
}
