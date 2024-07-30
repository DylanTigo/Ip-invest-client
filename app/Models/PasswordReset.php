<?php

namespace App\Models;

use App\Mail\ResetPasswordMail;
use App\Mail\SendMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dirape\Token\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = [
        "email",
        "role",
        "token",
        "token_used",
        "created_at",
        "expired_at"
    ];

    protected $casts = [
        'token_used' => 'boolean',
    ];

    public $timestamps = false;

    public static function userExist($email, $role)
    {
        $user = User::where('email', $email)->where('role', $role)->first();

        if (empty($user)) {
            return false;
        }

        return true;
    }

    public static function sendResetPasswordLink($email, $role)
    {
        $instance = new static;
        $today = Carbon::now();
        $expired = Carbon::now()->addMinutes(5)->timestamp;

        $userToken = static::tokenExist($email, $role);

        if ($userToken == null) {
            $userToken = $instance::create(
                [
                    'email' => $email,
                    'role' => $role,
                    'token' => (new Token())->unique('password_resets', 'token', 60),
                    'created_at' => $today,
                    'expired_at' => $expired
                ]
            );
        }

        return $instance->sendResetEmail($userToken->email, $userToken->role, $userToken->token);
    }

    public static function tokenUsed($email, $role, $token)
    {
        $instance = new static;

        $today = Carbon::now()->timestamp;

        $token = $instance::where([
            'email' => $email,
            'role' => $role,
            'token' => $token
        ])->first();

        if ($token->expired_at < $today) {
            return true;
        }

        if ($token->token_used) {
            return true;
        }

        return false;
    }

    public static function tokenExist($email, $role)
    {
        $instance = new static;

        $today = Carbon::now()->timestamp;

        $token = $instance::where([
            'email' => $email,
            'role' => $role,
            'token_used' => false
        ])->orderBy('created_at', 'DESC')->first();

        if (empty($token)) {
            return null;
        }

        if ($token->expired_at < $today) {
            return null;
        }

        return $token;
    }

    private function buildResetMail($email, $role, $token)
    {
        return "https://invest--partners.com/auth/password/reset/$token?email=" . urlencode($email) . "&role=$role";
    }

    private function sendResetEMail($email, $role, $token)
    {
        $details = [
            'url' => $this->buildResetMail($email, $role, $token)
        ];

        Mail::to($email)->send(new ResetPasswordMail($details));
    }
}
