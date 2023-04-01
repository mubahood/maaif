<?php

namespace Encore\Admin\Auth\Database;

use App\Models\Department;
use App\Models\District;
use App\Models\QuaterlyOutput;
use App\Models\Subcounty;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class Administrator extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasPermissions;
    use DefaultDatetimeFormat;

    protected $fillable = ['username', 'password', 'name', 'avatar'];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($m) {
            return Administrator::prepare($m);
        });

        self::updating(function ($m) {
            return Administrator::prepare($m);
        });
    }

    public function subcounty(){
        return $this->belongsTo(Subcounty::class,'subcounty_id');
    }
    public static function prepare($m)
    {
        $sub = Subcounty::find($m->subcounty_id);
        if($sub!=null){
            if($sub->county!=null){
                $m->district_id = $sub->county->district_id;
            }
        }

        if(
            $m->first_name != null &&
            $m->last_name != null &&
            strlen($m->last_name)> 2
        ){
            $m->name = $m->first_name." ".$m->last_name;
        }
         

        return $m; 
    } 


    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.users_table'));

        parent::__construct($attributes);
    }

    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar)) {
            return $avatar;
        }

        $disk = config('admin.upload.disk');

        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }

        $default = config('admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';

        return admin_asset($default);
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.database.user_permissions_table');

        $relatedModel = config('admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'permission_id');
    }


    public function activities()
    {
        return $this->hasMany(QuaterlyOutput::class, 'user_id');
    }


    public function bugdet()
    {
        $budget = 0;
        foreach ($this->activities as $key => $v) {
            $budget += $v->budget;
        }
        return $budget;
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
 

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

}
