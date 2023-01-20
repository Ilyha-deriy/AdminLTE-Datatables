<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Employee extends Model
{
    use HasFactory;

    protected $casts = [
        'recruitment_date' => 'datetime:d-m-y',
        'phone_number' => RawPhoneNumberCast::class.':UA',
     ];

    protected $fillable= ['name', 'position_id', 'phone_number',
    'recruitment_date', 'email', 'head_id',
    'image_path', 'payment', 'admin_created_id', 'admin_updated_id'];

    public function position()
    {
        return $this->belongsTo(Position::class,  'position_id');
    }

    public function head()
    {
        return $this->belongsTo(Employee::class,  'head_id');
    }
}
