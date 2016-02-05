<?php
namespace App\ModelTraits;
use Carbon\Carbon;
trait HasModelTrait
{
    public function showDateCreated($createdAtTimestamp)
    {
        return Carbon::parse($createdAtTimestamp)->format('m/d/Y');
    }

    public function formatDatePickerDate($datePickerDate)
    {
        return Carbon::createFromFormat('m/d/Y', $datePickerDate)->format('Y-m-d');
    }


    public function showStatusOf($record)
    {

        switch ($record) {

            case $record->status_id == 10:

                return 'Active';
                break;

            case $record->status_id == 7:

                return 'Inactive';
                break;

            default:

                return 'Inactive';

        }

    }
}