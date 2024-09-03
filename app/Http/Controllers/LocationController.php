<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationCollection;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable',
            'id' => 'nullable'
        ]);

        if ($request->has('id'))
            return $this->location($request->id);

        return LocationCollection::collection(
            Location::with('children')->where('parent_id', $request->input('parent_id',null) )->get()
        );
    }


    private function location($id)
    {
        return new LocationCollection(
            Location::with('parent')->find($id)
        );
    }
}
