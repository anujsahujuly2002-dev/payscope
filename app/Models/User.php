<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Bank;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Fund;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,HasPermissions;
    public $appends = ['state_name','city','pincode','address'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_no',
        'status',
        'otp',
        'expire_at',
        'verified_at',
        'virtual_account_number',
        'services'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function apiPartner(){
       return $this->hasOne(ApiPartner::class,'user_id','id');
    }
    public function qrRequest(){
       return $this->hasOne(QRRequest::class,'user_id','id');
    }
    public function retailer(){
       return $this->hasOne(Retailer::class,'user_id','id');
    }
    public function status(){
       return $this->hasOne(Status::class,'id');
    }

    public function getCreatedAtAttribute($value){
        return date('d M y - h:i A', strtotime($value));
    }

    public function walletAmount() {
        return $this->hasOne(Wallet::class,'user_id','id');
    }

    public function getStateNameAttribute() {
        if(auth()->user()->getRoleNames()->first() =='api-partner'):
            return $this->apiPartner?->state_id;
        else:
            return $this->retailer?->state_id;
        endif;

    }
    public function getCityAttribute() {
        if(auth()->user()->getRoleNames()->first() =='api-partner'):
            return $this->apiPartner?->city;
        else:
            return $this->retailer?->city;
        endif;
    }
    public function getPincodeAttribute() {
        if(auth()->user()->getRoleNames()->first() =='api-partner'):
            return $this->apiPartner?->pincode;
        else:
            return $this->retailer?->pincode;
        endif;
    }
    public function getAddressAttribute() {
        if(auth()->user()->getRoleNames()->first() =='api-partner'):
            return $this->apiPartner?->address;
        else:
            return $this->retailer?->address;
        endif;
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function funds()
    {
        return $this->hasMany(Fund::class);
    }
    public function fund()
    {
        return $this->hasMany(Fund::class);
    }
    public function fundRequest()
    {
        return $this->hasMany(FundRequest::class);
    }
    public function payoutRequest()
    {
        return $this->hasMany(PayoutRequestHistory::class);
    }

}
