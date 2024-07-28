<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    public $timestamps = false;

    protected $fillable = [
		'label',
		'description',
		'color',
        'start_date',
        'end_date',
	];
    
    /**
     * Get upcoming events.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUpcomingEvents()
    {
        return self::where('start_date', '>=', Carbon::now())
                   ->orWhere(function ($query) {
                       $query->where('end_date', '>=', Carbon::now())
                             ->whereNotNull('end_date');
                   })
                   ->orderBy('start_date', 'asc')
                   ->get();
    }
    
    /**
     * Format the event for the frontend.
     *
     * @return array
     */
    public function formatForFrontend()
    {
        $formattedEvent = [
            'label' => $this->label,
            'description' => $this->description,
            'css' => '!bg-' . $this->color . '-200',
        ];

        if (is_null($this->end_date)) {
            $formattedEvent['date'] = $this->start_date;
        } else {
            $formattedEvent['range'] = [
                $this->start_date,
                $this->end_date,
            ];
        }

        return $formattedEvent;
    }

    /**
     * Set the value of the 'end_date' attribute.
     *
     * @param mixed $value The value to set for the 'end_date' attribute.
     * @return void
     */
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ?: null;
    }
}
