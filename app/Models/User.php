<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\LogsActivityTrait;
use App\Traits\PaymentTrait;
use App\Traits\PlanholderRegistration;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $role_id
 * @property int|null $branch_id
 * @property string $account_type
 * @property string $username
 * @property string $lastname
 * @property string $firstname
 * @property string|null $middlename
 * @property string|null $gender
 * @property string|null $birthdate
 * @property int|null $age
 * @property string|null $address
 * @property string|null $postal_code
 * @property string|null $contact_no
 * @property string|null $civil_status
 * @property string|null $height
 * @property string|null $weigth
 * @property string|null $citizenship
 * @property string|null $sponsor
 * @property string|null $sss_number
 * @property string|null $tin_number
 * @property string|null $ben_firstname
 * @property string|null $ben_middlename
 * @property string|null $ben_lastname
 * @property string|null $ben_relationship
 * @property string|null $ben_birthdate
 * @property string|null $status
 * @property string|null $facebook
 * @property string|null $messenger
 * @property string|null $twitter
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Staff[] $staffs
 * @property-read int|null $staffs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBenBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBenFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBenLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBenMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBenRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCitizenship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMessenger($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSponsor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSssNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTinNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserame($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWeigth($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Beneficiary> $beneficiaries
 * @property-read int|null $beneficiaries_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Plan> $plans
 * @property-read int|null $plans_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Beneficiary> $beneficiaries
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Plan> $plans
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use InteractsWithMedia;
    use LogsActivityTrait;
    use PaymentTrait;
    use PlanholderRegistration;

    const COMPANY_REFFERRAL_CODE = 'OPHIRAGENT';

    const ROLE_ADMIN = 'Admin';

    const ROLE_DIRECTOR = 'Director';

    const ROLE_MANAGER = 'Manager';

    const ROLE_STAFF = 'Staff';

    const ROLE_AGENT = 'Agent';

    const ROLE_BRANCH_ADMIN = 'Branch Admin';

    const ROLE_PLANHOLDER = 'Planholder';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'profile_image',
        'signature_image',
        'marketing_tools',
    ];

    public function registerMediaCollections(): void
    {
        // Allow only one file to be associated per collection
        $this->addMediaCollection('profile_image')
            ->singleFile();
        $this->addMediaCollection('signature_image')
        ->singleFile();
        $this->addMediaCollection('marketing_tools');
    }

    /**
     * Get file URL for profile_image
     *
     * @return string
     */
    public function getProfileImageAttribute(): string
    {
        return $this->getFirstMediaUrl('profile_image');
    }

    /**
     * Get file URL for signature_image
     *
     * @return string
     */
    public function getSignatureImageAttribute(): string
    {
        return $this->getFirstMediaUrl('signature_image');
    }

    /**
     * Get file URL for marketing tools
     *
     * @return string
     */
    public function getMarketingToolsAttribute(): string
    {
        return $this->getFirstMediaUrl('marketing_tools');
    }

    /**
     * @return string
     *
     * @deprecated
     */
    public function getProfileImageUrl(): string
    {
        return $this->profile_image;
    }

    /**
     * @return string
     *
     * @deprecated
     */
    public function getSignatureImageUrl(): string
    {
        return $this->signature_image;
    }

    /**
     * @return string
     *
     * @deprecated
     */
    public function geMarketingToolsUrl(): string
    {
        return $this->marketing_tools;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->withPivot('is_active');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function userPlans()
    {
        return $this->belongsToMany(Plan::class, 'user_plan')
        ->withPivot('id', 'user_plan_uuid', 'is_active', 'referred_by_id', 'is_transferrable', 'billing_occurrence');
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Scope a query to only include users of a given type.
     */
    public function scopeOfRoles(Builder $query, array $roles): void
    {
        $query->whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        });
    }
}
