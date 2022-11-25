<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
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
    protected $table = "channels";

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    public $timestamps = true;


    protected $dateFormat = 'Y-m-d H:i:s';

    
    protected $fillable = [
        'track_id',
        'name',
        'namespace',
        'description',
        'status'
    ];
}
