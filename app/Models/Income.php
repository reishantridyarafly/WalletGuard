<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Income extends Model
{
    use HasFactory;
    protected $table = 'incomes';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'income',
        'category_id',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setIncomeAttribute($value)
    {
        $this->attributes['income'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function getIncomeAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
}
