<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('BilButikk1') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Labels, som skal color code avhengig av side. --}}
            @php
                $statusLabels = [
                    'Available' => 'Tilgjengelig',
                    'Reserved' => 'Reservert',
                    'Sold' => 'Solgt',
                    'Tilgjengelig' => 'Tilgjengelig',
                    'Reservert' => 'Reservert',
                    'Solgt' => 'Solgt',
                ];
                $fuelLabels = [
                    'Petrol' => 'Bensin',
                    'Diesel' => 'Diesel',
                    'Hybrid' => 'Hybrid',
                    'Electric' => 'Elektrisk',
                    'Other' => 'Annet',
                    'Bensin' => 'Bensin',
                    'Elektrisk' => 'Elektrisk',
                    'Annet' => 'Annet',
                ];

                $statusFilters = [
                    '' => 'Alle statuser',
                    'Til salgs' => 'Til salgs',
                    'Reservert' => 'Reservert',
                    'Solgt' => 'Solgt',
                ];
                $selectedStatus = (string) request('status', '');
            @endphp

            @if (session('success'))
                <div class="mb-4 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <ion-icon name="checkmark-circle-outline" class="text-base"></ion-icon>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- HEADER SEKSJON --}}

            <div class="mb-6 rounded-2xl border border-gray-200 bg-white px-4 py-5 shadow-sm sm:px-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-4xl font-semibold tracking-tight text-gray-900">Bilpark</h3>
                        <p class="mt-1 text-2xl text-gray-500">
                            {{ $cars->count() }} {{ $cars->count() === 1 ? 'bil totalt' : 'biler totalt' }}
                        </p>
                    </div>
                    <a href="{{ route('carpark.create') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">
                        <ion-icon name="add" class="text-base"></ion-icon>
                        <span>Legg til bil</span>
                    </a>
                </div>

                {{-- FILTER SEKSJON --}}
                <form method="GET" action="{{ route('carpark') }}" class="mt-6 grid gap-3 md:grid-cols-12">

                     {{-- Søkebar, er ikke implemented i backend enda --}}
                    {{-- <label for="car-search" class="relative md:col-span-10 my-2">
                        <ion-icon name="search-outline" class="pointer-events-none absolute text-lg text-gray-400"></ion-icon>
                        <input id="car-search" type="text" placeholder="Søk etter merke, modell, reg.nr..."
                               class="h-11 w-full rounded-lg border border-gray-200 pl-10 pr-3 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 ">
                    </label> --}}
                    {{-- Dropdwon meny med valg der man kan filtrere etter solgte biler o.l. --}}
                    <label for="status-filter" class="relative md:col-span-2">
                        <select id="status-filter" name="status" onchange="this.form.submit()"
                                class="h-11 w-full appearance-none rounded-lg border border-gray-200 px-3 pr-9 text-sm text-gray-700 focus:border-sky-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach ($statusFilters as $value => $label)
                                <option value="{{ $value }}" @selected($selectedStatus === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <ion-icon name="chevron-down-outline" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-base text-gray-400"></ion-icon>
                    </label>
                </form>
                {{-- FILTER SEKSJON SLUTT --}}
            </div>

            {{-- HEADER SKESJON SLUTT --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- TOM SEKSJON --}}

                {{-- Sjekker om den finner noen biler. Også avhengig av statusFilters --}}
                @if ($cars->isEmpty())
                    <div class="px-6 py-16 text-center">
                        {{-- Bil Ikon --}}
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-indigo-700">
                            <ion-icon name="car-sport-outline" class="text-2xl"></ion-icon>
                        </div>
                        
                        <h4 class="text-base font-semibold text-gray-900">Ingen biler registrert i systemet.</h4>
                        <p class="mt-2 text-sm text-gray-500">Legg til den første bilen for å starte.</p>
                        <a href="{{ route('carpark.create') }}"
                           class="mt-5 inline-flex items-center justify-center gap-2 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                            <ion-icon name="add" class="text-base"></ion-icon>
                            <span>Legg til bil</span>
                        </a>
                    </div>
                
                {{-- TOM SEKSJON SLUTT --}}
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-4 py-4 text-left">Bil</th>
                                    <th class="px-4 py-4 text-left">Reg.nr</th>
                                    <th class="px-4 py-4 text-left">Årsmodell</th>
                                    <th class="px-4 py-4 text-left">Km</th>
                                    <th class="px-4 py-4 text-left">Drivstoff</th>
                                    <th class="px-4 py-4 text-left">Status</th>
                                    <th class="px-4 py-4 text-left">Pris</th>
                                    <th class="px-4 py-4 text-left">Handlinger</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white text-sm text-gray-700">
                                @foreach ($cars as $car)
                                    <tr class="align-top">
                                        @php
                                            $statusLabel = $statusLabels[$car->status] ?? $car->status;
                                            $statusClass = match (strtolower((string) $statusLabel)) {
                                                'tilgjengelig', 'available' => 'border border-emerald-200 bg-emerald-50 text-emerald-700',
                                                'reservert', 'reserved' => 'border border-indigo-400 bg-indigo-50 text-indigo-700',
                                                'solgt', 'sold' => 'border border-gray-200 bg-gray-100 text-gray-600',
                                                default => 'border border-amber-200 bg-amber-50 text-amber-700',
                                            };
                                        @endphp

                                        <td class="whitespace-nowrap px-4 py-4">
                                            <p class="font-semibold text-gray-900">{{ $car->make }} {{ $car->model }}</p>
                                            <p class="text-xs text-gray-500">{{ $car->color }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 font-semibold text-gray-900">{{ $car->registration_number }}</td>
                                        <td class="whitespace-nowrap px-4 py-4">{{ $car->year }}</td>
                                        <td class="whitespace-nowrap px-4 py-4">{{ number_format($car->kilometers, 0, ',', ' ') }} km</td>
                                        <td class="whitespace-nowrap px-4 py-4">{{ $fuelLabels[$car->fuel_type] ?? $car->fuel_type }}</td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                                {{ $statusLabels[$car->status] ?? $car->status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-base font-semibold text-gray-900">{{ number_format($car->price, 0, ',', ' ') }} kr</td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('carpark.show', $car->registration_number) }}"
                                                   class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900 px-2"
                                                   title="Vis">
                                                    <ion-icon name="eye-outline" class="text-base"></ion-icon>
                                                </a>
                                                <a href="{{ route('carpark.edit', $car->registration_number) }}"
                                                   class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900 px-2"
                                                   title="Rediger">
                                                    <ion-icon name="create-outline" class="text-base"></ion-icon>
                                                </a>
                                                <form action="{{ route('carpark.delete', $car->registration_number) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-red-200 text-red-600 transition hover:bg-red-50 px-2"
                                                            onclick="return confirm('Slette denne bilen?')">
                                                        <ion-icon name="trash-outline" class="text-base"></ion-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @once
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @endonce
</x-app-layout>
