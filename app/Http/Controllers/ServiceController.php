<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Mechanic;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return view('service.index', compact('services'));
    }

    public function create()
    {
        $cars = Car::orderBy('registration_number')->get(['registration_number', 'make', 'model']);
        $mechanics = Mechanic::orderBy('id')->get(['name', 'title', 'email']);

        return view('service.create', compact('cars', 'mechanics'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'scheduled_date' => $this->normalizeDate($request->input('scheduled_date')),
            'completed_date' => $this->normalizeDate($request->input('completed_date')),
        ]);

        $validated = $request->validate([
            'registration_number' => 'required|unique:services|max:255',
            'type' => 'required|max:255',
            'priority' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'estimated_cost' => 'required|integer',
            'scheduled_date' => 'required|date',
            'mechanic' => 'required|max:255',
        ]);

        Service::create($validated);

        return redirect()
            ->route('service')
            ->with('success', 'Service på bil opprettet.');
    }

    public function edit(string $registration_number)
    {
        $service = Service::where('registration_number', $registration_number)->firstOrFail();
        $cars = Car::orderBy('registration_number')->get(['registration_number', 'make', 'model']);
        $mechanics = Mechanic::orderBy('id')->get(['name', 'title', 'email']);

        return view('service.edit', compact('service', 'cars', 'mechanics'));
    }

    public function update(Request $request, string $registration_number) 
    {
        $request->merge([
            'scheduled_date' => $this->normalizeDate($request->input('scheduled_date')),
            'completed_date' => $this->normalizeDate($request->input('completed_date')),
        ]);

        $validated = $request->validate([
            'registration_number' => [
                'required',
                'max:255',
                Rule::unique('services', 'registration_number')
                    ->ignore($registration_number, 'registration_number'),
            ],
            'type' => 'required|max:255',
            'priority' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'estimated_cost' => 'required|integer',
            'real_cost' => 'required|integer',
            'scheduled_date' => 'required|date',
            'completed_date' => 'required|date',
            'mechanic' => 'required|max:255',
        ]);

        $service = Service::where('registration_number', $registration_number)->firstOrFail();
        $service->update($validated);

        return redirect()
            ->route('service')
            ->with('success', 'Service ble oppdatert.');
    }

    public function delete(string $registration_number)
    {
        $service = Service::where('registration_number', $registration_number)->firstOrFail();
        $service->delete();

        return redirect()
            ->route('service')
            ->with('success', 'Service ble slettet.');
    }

    private function normalizeDate(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return $value;
        }

        $value = trim($value);
        $formats = ['Y-m-d', 'd.m.Y', 'd-m-Y', 'd/m/Y', 'm/d/Y'];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date !== false && $date->format($format) === $value) {
                    return $date->format('Y-m-d');
                }
            } catch (\Throwable $th) {
                continue;
            }
        }

        return $value;
    }
}
