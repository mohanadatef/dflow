<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Service\NotificationService;
/**
 * @Target this file to make function to help for all system
 * @note can call it in all system
 */
/**
 * user login
 */
function user()
{
    if(Auth::guard('web')->check())
    {
        return Auth::guard('web')->user();
    }
    return false;
}

/**
 * to execution time for web
 */
function executionTime(): void
{
    ini_set('max_execution_time', 120000);
    ini_set('post_max_size', 120000);
    ini_set('upload_max_filesize', 100000);
    ini_set('memory_limit', '-1');
}

/**
 * @param $view @note path blade in code
 * @if mixed will send page 404
 */
function checkView($view)
{
    return view()->exists($view) ? $view : 'errors.500';
}

function permissionShow($name): int
{
    return DB::table('permissions')
        ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
        ->where('permission_role.role_id', user()->role_id ?? 0)
        ->where('permissions.name', $name)->count();
}

if(!function_exists('can'))
{
    function can($permission)
    {
        if(!Auth::guard('web')->user()->can($permission))
        {
            abort(401);
        }
        return true;
    }
}
function rand_color(): string
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

/**
 * @param $numerator
 * @param $denominator
 * @return float
 */
function divide($numerator, $denominator)
{
    return $denominator == 0 ? 0 : ($numerator / $denominator);
}

function notificationStore($type, $module, $user_id, $action_id)
{
    $request = new \Illuminate\Http\Request(['action' => $type, 'action_category' => get_class($module), 'receiver_id' => $user_id, 'action_id'=> $action_id,'pusher_id'=>user()->id ?? 0]);

    return app()->make(NotificationService::class)->store($request);
}
