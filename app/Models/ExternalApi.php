<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalApi extends Model
{
    use HasFactory;
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';


    /**
     * @var string
     */
    protected $table = "external_apis";

    /**
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * @var boolean
     */
    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'api_type',
        'api_key',
        'secret',
        'url',
        'key',
        'is_form_field_mapped_api',
        'request_generation_method',
        'request_parameter',
        'extra_config',
        'response_parameter',
        'mock_response_parameter',
        'mock_request_parameter',
        'mock_header_parameter',
        'mock_request_parameter',
        'request_header',
        'response',
        'created_by',
        'updated_by',
        'status',
    ];

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
