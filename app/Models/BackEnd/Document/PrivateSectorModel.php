<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class PrivateSectorModel extends Model
{

    protected $table="fm_private_sector";
    protected $fillable = ['company_name','address'];
}

