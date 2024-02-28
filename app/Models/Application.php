<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function files()
    {
        return $this->hasmany(File::class);
    }

    public function getStatusAttribute($status)
    {
        if($status==1){

            return 'تاییدشده';

        }elseif($status == 0){

            return 'تاییدنشده';

        }else{

            return 'در حال بررسی';

        }
    }
}
