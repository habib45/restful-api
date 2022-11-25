<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
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
   protected $table = "tracks";

   /**
    * @var string
    */
   protected $primaryKey = 'id';


   /**
    * @var boolean 
    */ 
   public $timestamps = true;

   protected $dates = ['created_at','updated_at'];

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
       'description',
       'status',
   ];
}
