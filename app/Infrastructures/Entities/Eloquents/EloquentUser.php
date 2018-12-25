<?php

namespace App\Infrastructures\Entities\Eloquents;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Domains\Models\BaseAccount\Account;
use App\Domains\Models\BaseAccount\AccountId;
use App\Domains\Models\BaseAccount\AccountName;

use App\Domains\Models\Account\Stylist;
use App\Domains\Models\Account\Member;

use App\Domains\Models\Email\EmailAddress;

class EloquentUser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return int
     */
    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * アカウントインターフェイスを継承したドメインモデルを返却する
     * @return Account Stylist, Member
     */
    public function toDomain(): Account
    {
        if ($this->role_id === Stylist::ACCOUNT_TYPE) {
            return new Stylist(
                new AccountId($this->id),
                new AccountName($this->name),
                new EmailAddress($this->email)
            );
        }
        
        return new Member(
            new AccountId($this->id),
            new AccountName($this->name),
            new EmailAddress($this->email)
        );
    }
}
