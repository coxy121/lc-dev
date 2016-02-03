<?php
namespace App\ModelTraits;
use Carbon\Carbon;
trait HasModelTrait
{
    public function showDateCreated($createdAtTimestamp)
    {
        return Carbon::parse($createdAtTimestamp)->format('m/d/Y');
    }
}