<?php

    namespace App\Models;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Spatie\Permission\Traits\HasRoles;

    class Admin extends Authenticatable
    {
        use Notifiable, HasRoles;

        protected $guard = 'admin';

        protected $fillable = [
            'name', 'email', 'username', 'password', 'avatar', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
    }
