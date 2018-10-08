<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    # Constants
    const MAX_DISTANCE_MILES = 350; # Max miles runnable by a human
    const MAX_DISTANCE_KILOMETERS = MAX_DISTANCE_MILES * 1.6; # Max kilometers runnable by a human
    const MAX_HOURS = 90; # World record longest continuous run was 87 hours.

    /**
     * Calculate the running pace needed.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function calculatePace(Request $request)
    {
        //
        $request->input('');

    }
}
