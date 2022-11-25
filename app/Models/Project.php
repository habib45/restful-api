<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
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
    protected $table = "projects";

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];
}
