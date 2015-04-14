<?php

namespace Shalkam\CrudGenerator\Base;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    protected $fillable = [];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }
}
