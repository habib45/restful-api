<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
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
    protected $table = "groups";

    /**
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channels()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

}
