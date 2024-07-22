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
        'date',
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
        return self::where('date', '>=', Carbon::now())
                   ->orWhere('start_date', '>=', Carbon::now())
                   ->orderBy('date', 'asc')
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

        if ($this->date) {
            $formattedEvent['date'] = $this->date;
        } else {
            $formattedEvent['range'] = [
                $this->start_date,
                $this->end_date,
            ];
        }

        return $formattedEvent;
    }
}
