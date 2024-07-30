<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'civilite',
        'prenom',
        'nom',
        'folder',
        'email',
        'telephone',
        'password',
        'photo',
        'anciennete',
        'status',
        'profil',
        'role',
        'device_token',
        'email_verified_at'
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends =  [
        'nom_complet',
        'anciennete_complet'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNomCompletAttribute()
    {
        if (empty($this->civilite)) {
            return $this->nom . ' ' . $this->prenom;
        } else {
            return $this->civilite . ' ' . $this->nom . ' ' . $this->prenom;
        }
    }

    public function getAncienneteCompletAttribute($value)
    {
        if ($value == 1) {
            return 'Plus d\'un ans d\'anciennete';
        } else if ($value == -1) {
            return 'Moins d\'un ans d\'anciennete';
        } else {
            return null;
        }
    }

    public function role_data()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class, 'user', 'id');
    }

    public function documents_fiscaux()
    {
        return $this->hasMany(DocumentFiscaux::class, 'user', 'id');
    }

    public function secteurs_data()
    {
        return $this->hasMany(Secteur::class, 'user', 'id')->with(['projets']);
    }

    public function profil_invest()
    {
        return $this->belongsTo(ProfilInvestisseur::class, 'profil', 'id');
    }

    public function profil_porteur()
    {
        return $this->belongsTo(ProfilPorteurProjet::class, 'status', 'type');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'privileges', 'user', 'module')->withPivot('id', 'consulter', 'modifier', 'ajouter', 'supprimer');
    }

    public static function writeReport($folder, $data)
    {
        try {
            $json = [];
            $path = storage_path("app/uploads/$folder/report.json");
            if (File::exists($path)) {
                $json = json_decode(file_get_contents($path), true);
                if (empty($json)) {
                    $json = [];
                }
            }
            array_push($json, $data);
            $json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            Storage::disk('local')->put("uploads/$folder/report.json", $json);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.' . $this->id;
    }

    public function sendFcmNotification($body, $title = 'Nouveau message')
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = $this->device_token;

        $serverKey = 'AAAAp7I2kBQ:APA91bGVBlX27Lfh9C9VdmWRkELtCeHAAFjwxwamlnjmSxiu5mzctSEIFSsxYqvzeL6dRfLJptUbM6TcySabiOXBqG6q1dySJJw3UPAklRZ3wcDbF6AhkTiVPo5lAgWehYC9ZJ-qo0d3';

        $data = [
            "to" => $FcmToken,
            "direct_boot_ok" => true,
            "notification" => [
                "title" => $title,
                "body" => $body,
                'notification_priority' => 'PRIORITY_MAX',
                "default_vibrate_timings" => true,
                "visibility" => 'SECRET',
                'sound' => 'default',
                'badge' => '1'
            ],
            'priority' => 'HIGH'
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type:application/json',
        ];

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

            curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
