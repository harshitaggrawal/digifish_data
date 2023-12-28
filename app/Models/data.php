<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;;

class data extends  Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb'; // Specify the MongoDB connection

    protected $collection = 'all_reports_daily'; // Specify the MongoDB collection name

    
}



