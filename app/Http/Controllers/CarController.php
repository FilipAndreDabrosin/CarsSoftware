<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $selectedStatus = trim((string) $request->query('status', ''));
        $carsQuery = Car::query();

        if ($selectedStatus !== '') {
            $statusMap = [
                'Til salgs' => 'Til salgs',
                'Reservert' => 'Reservert',
                'Solgt' => 'Solgt',
            ];

            $matchingStatuses = $statusMap[$selectedStatus] ?? [$selectedStatus];
            if (!is_array($matchingStatuses)) {
                $matchingStatuses = [$matchingStatuses];
            }
            $carsQuery->where('status', $matchingStatuses);
        }

        $cars = $carsQuery->get();

        return view('carpark.index', compact('cars'));
    }

    public function show(string $registration_number)
    {
        $car = Car::where('registration_number', $registration_number)->firstOrFail();

        return view('carpark.show', compact('car'));
    }

    public function create()
    {
        return view('carpark.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'arrived_date' => $this->normalizeArrivedDate($request->input('arrived_date')),
        ]);

        $validated = $request->validate([
            'registration_number' => 'required|unique:cars|max:255',
            'make' => 'required|max:255',
            'model' => 'required|max:255',
            'year' => 'required|integer',
            'kilometers' => 'required|integer',
            'color' => 'required|max:255',
            'fuel_type' => 'required|max:255',
            'gearbox' => 'required|max:255',
            'price' => 'required|integer',
            'status' => 'required|max:255',
            'description' => 'nullable',
            'arrived_date' => 'required|date',
        ]);

        Car::create($validated);

        return redirect()
            ->route('carpark')
            ->with('success', 'Bil ble opprettet.');
    }

    public function edit(string $registration_number)
    {
        $car = Car::where('registration_number', $registration_number)->firstOrFail();

        return view('carpark.edit', compact('car'));
    }

    public function update(Request $request, string $registration_number) 
    {
        $request->merge([
            'arrived_date' => $this->normalizeArrivedDate($request->input('arrived_date')),
        ]);

        $validated = $request->validate([
            'registration_number' => [
                'required',
                'max:255',
                Rule::unique('cars', 'registration_number')->ignore($registration_number, 'registration_number'),
            ],
            'make' => 'required|max:255',
            'model' => 'required|max:255',
            'year' => 'required|integer',
            'kilometers' => 'required|integer',
            'color' => 'required|max:255',
            'fuel_type' => 'required|max:255',
            'gearbox' => 'required|max:255',
            'price' => 'required|integer',
            'status' => 'required|max:255',
            'description' => 'nullable',
            'arrived_date' => 'required|date',
        ]);

        $car = Car::where('registration_number', $registration_number)->firstOrFail();
        $car->update($validated);

        return redirect()
            ->route('carpark')
            ->with('success', 'Bil ble oppdatert.');
    }

    public function delete(string $registration_number)
    {
        $car = Car::where('registration_number', $registration_number)->firstOrFail();
        $car->delete();

        return redirect()
            ->route('carpark')
            ->with('success', 'Bil ble slettet.');
    }

    private function normalizeArrivedDate(?string $value): ?string
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
