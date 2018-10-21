<?php

namespace App\Http\Controllers;

// Custom request object that validates
use App\Http\Requests\CalculatePaceRequest;

use Illuminate\Http\Request;

class FormController extends Controller
{
    # Constants
    const MAX_DISTANCE_MILES = 350; # Max miles runnable by a human
    const MAX_DISTANCE_KILOMETERS = 350 * 1.6; # Max kilometers runnable by a human
    const MAX_HOURS = 90; # World record longest continuous run was 87 hours.

    /**
     * Calculate the running pace needed.
     * @param  Request $request
     * @param  string $id
     * @return Response
     */
    public function calculatePace(CalculatePaceRequest $request)
    {
        // Validate form params using custom Request validator
        // Handles loading error messages and returning form original data to populate the form if an error
        $validated = $request->validated();

        // If we made it here that means our inputs are valid
        $hours = $request->input('hours');
        $minutes = $request->input('minutes');
        $distance = $request->input('distance');
        $unit = $request->input('unit');

        $total_number_of_minutes = $hours * 60 + $minutes;
        $minutes_per_distance = $total_number_of_minutes / $distance;

        # Convert fractional minutes into seconds for legibility
        $fractional_seconds = $minutes_per_distance - (int)$minutes_per_distance;
        if ($fractional_seconds > 0) {
            # Converting to int cause not really interested in fractions of seconds
            $seconds_per_distance = (int)(60 * $fractional_seconds);
            $minutes_per_distance = (int)$minutes_per_distance;
        }

        # Convert greater than 60 minutes into hours for legibility
        if ($minutes_per_distance >= 60) {
            $hours_per_distance = (int)($minutes_per_distance / 60);
            $minutes_per_distance = $minutes_per_distance % 60;
        }

        # Convert result to human legible
        $result_string = '';
        if (isset($hours_per_distance)) {
            $hour_pluralize = $hours_per_distance == 1 ? 'hour' : 'hours';
            $result_string = $result_string . $hours_per_distance . ' ' . $hour_pluralize;
        }
        if ($minutes_per_distance > 0) {
            $minutes_pluralize = $minutes_per_distance == 1 ? 'minute' : 'minutes';
            $result_string = $result_string . ' ' . $minutes_per_distance . ' ' . $minutes_pluralize;
        }
        if (isset($seconds_per_distance)) {
            $second_pluralize = $seconds_per_distance == 1 ? 'second' : 'seconds';
            $result_string = $result_string . ' and ' . $seconds_per_distance . ' ' . $second_pluralize;
        }
        $result_string = $result_string . ' per ' . $unit;

        return back()->with('results', $result_string)->withInput();
    }
}
