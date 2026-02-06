<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Rediger bil') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h3 class="text-2xl font-semibold tracking-tight text-gray-900">
                                Rediger {{ $car->make }} {{ $car->model }} ({{ $car->registration_number }})
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">Oppdater bilinformasjon.</p>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mx-6 mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-medium">Rett opp følgende feil:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('carpark.update', $car->registration_number) }}" method="POST"
                    class="px-6 py-6">
                    @csrf
                    @method('PUT')
                    @php
                        $currentStatus = old('status', $car->status);
                        $currentFuelType = old('fuel_type', $car->fuel_type);
                        $currentGearbox = old('gearbox', $car->gearbox);
                        $arrivedDateValue = old('arrived_date', $car->arrived_date);
                        if ($arrivedDateValue && preg_match('/^\d{4}-\d{2}-\d{2}$/', $arrivedDateValue)) {
                            $arrivedDateValue = \Carbon\Carbon::parse($arrivedDateValue)->format('d.m.Y');
                        }
                    @endphp

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="registration_number"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Registreringsnummer</label>
                            <input type="text" id="registration_number" name="registration_number"
                                value="{{ old('registration_number', $car->registration_number) }}" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="status"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Status</label>
                            <select id="status" name="status" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                <option value="Til salgs" @selected($currentStatus === 'Til salgs')>Til salgs</option>
                                <option value="Reservert" @selected($currentStatus === 'Reservert')>Reservert</option>
                                <option value="Solgt" @selected($currentStatus === 'Solgt')>Solgt</option>
                                @if (!in_array($currentStatus, ['Til salgs', 'Reservert', 'Solgt'], true))
                                    <option value="{{ $currentStatus }}" selected>{{ $currentStatus }}</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="make" class="mb-1.5 block text-sm font-semibold text-gray-700">Merke</label>
                            <input type="text" id="make" name="make" value="{{ old('make', $car->make) }}"
                                required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="model"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Modell</label>
                            <input type="text" id="model" name="model" value="{{ old('model', $car->model) }}"
                                required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="year" class="mb-1.5 block text-sm font-semibold text-gray-700">År</label>
                            <input type="number" id="year" name="year" value="{{ old('year', $car->year) }}"
                                min="1900" max="2100" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="kilometers"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Kilometerstand</label>
                            <input type="number" id="kilometers" name="kilometers"
                                value="{{ old('kilometers', $car->kilometers) }}" min="0" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="fuel_type"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Drivstoff</label>
                            <select id="fuel_type" name="fuel_type" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                <option value="Bensin" @selected($currentFuelType === 'Bensin')>Bensin</option>
                                <option value="Diesel" @selected($currentFuelType === 'Diesel')>Diesel</option>
                                <option value="Hybrid" @selected($currentFuelType === 'Hybrid')>Hybrid</option>
                                <option value="Elektrisk" @selected($currentFuelType === 'Elektrisk')>Elektrisk</option>
                                <option value="Annet" @selected($currentFuelType === 'Annet')>Annet</option>
                                @if (!in_array($currentFuelType, ['Bensin', 'Diesel', 'Hybrid', 'Elektrisk', 'Annet'], true))
                                    <option value="{{ $currentFuelType }}" selected>{{ $currentFuelType }}</option>
                                @endif
                            </select>
                        </div>
                        <div>
                            {{-- Dropdown options, med valg av girkasse/boks --}}
                            <label for="gearbox"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Girkasse</label>
                            <select id="gearbox" name="gearbox" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                <option value="Automat" @selected($currentGearbox === 'Automat')>Automat</option>
                                <option value="Manuell" @selected($currentGearbox === 'Manuell')>Manuell</option>
                                <option value="Annet" @selected($currentGearbox === 'Annet')>Annet</option>
                                {{-- Setter nåværende girboks til default vagl/option --}}
                                @if (!in_array($currentGearbox, ['Manuell', 'Automat', 'Annet'], true))
                                    <option value="{{ $currentGearbox }}" selected>{{ $currentGearbox }}</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="color" class="mb-1.5 block text-sm font-semibold text-gray-700">Farge</label>
                            <input type="text" id="color" name="color" value="{{ old('color', $car->color) }}"
                                required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="price" class="mb-1.5 block text-sm font-semibold text-gray-700">Pris
                                (kr)</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $car->price) }}"
                                min="0" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="arrived_date"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Ankomstdato</label>
                            <input type="text" id="arrived_date" name="arrived_date"
                                value="{{ $arrivedDateValue }}" placeholder="dd.mm.åååå" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Format: dd.mm.åååå</p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Beskrivelse</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">{{ old('description', $car->description) }}</textarea>
                        </div>
                    </div>

                    <div
                        class="mt-8 flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-0 pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('carpark') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                            <ion-icon name="arrow-back-outline" class="text-base"></ion-icon>
                            <span>Tilbake</span>
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">

                            <span>Lagre endringer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @once
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @endonce
</x-app-layout>
