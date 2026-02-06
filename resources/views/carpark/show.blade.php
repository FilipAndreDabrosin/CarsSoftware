<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('BilButikk1') }}
        </h2>
    </x-slot>

    @php

        // LABELS SEKSJON

        $statusLabels = [
            'Til salgs',
            'Reservert',
            'Solgt',
        ];

        $fuelLabels = [
            'Bensin',
            'Elektrisk', 
            'Annet',
        ];

        $gearboxLabels = [
            'Manuell',
            'Automat',
            'Annet',
        ];
        // Setter color codet labels på siden.
        $statusLabel = $statusLabels[$car->status] ?? $car->status;
        $statusClass = match (strtolower((string) $statusLabel)) {
            'til salgs', => 'bg-sky-50 text-sky-700',
            'reservert', 'reserved' => 'bg-gray-100 text-gray-700',
            'solgt', 'sold' => 'bg-gray-200 text-gray-700',
            default => 'bg-gray-100 text-gray-700',
        };

        // LABELS SEKSJON SLUTT

        // SERVICE VARIABEL SEKSJON

        $services = collect($services ?? []);
        $totalServices = $services->count();
        // Sjekker om completed_date er satt, for å sjekke at servicen er fullført
        $completedServices = $services->whereNotNull('completed_date')->count();
        $activeServices = max($totalServices - $completedServices, 0);

        // SLUTT SERVICE VARIABEL SEKSJON
    @endphp

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex w-full flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <a href="{{ route('carpark') }}"
                           class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 transition hover:bg-gray-50 ">
                            <ion-icon name="arrow-back-outline" class="text-base"></ion-icon>
                        </a>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h1 class="text-xl font-semibold text-gray-900">{{ $car->make }} {{ $car->model }}</h1>
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            <p class="text-lg text-gray-500">{{ $car->registration_number }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('carpark.edit', $car->registration_number) }}"
                           class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-800 transition hover:bg-gray-50">
                            <ion-icon name="create-outline" class="text-base"></ion-icon>
                            <span>Rediger</span>
                        </a>

                        <form action="{{ route('carpark.delete', $car->registration_number) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-md border border-red-600 bg-white px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-500 hover:text-white"
                                    onclick="return confirm('Vil du slette denne bilen?')">
                                <ion-icon name="trash-outline" class="text-base"></ion-icon>
                                <span class="hover:text-white">Slett</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mb-6 flex w-full flex-col gap-4">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">Bilinformasjon</h3>

                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-1">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="calendar-outline" class="text-base"></ion-icon>
                                <span>Årsmodell</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ $car->year }}</p>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-1">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="speedometer-outline" class="text-base"></ion-icon>
                                <span>Kilometerstand</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ number_format($car->kilometers, 0, ',', ' ') }} km</p>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-1">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="document-text-outline" class="text-base"></ion-icon>
                                <span>Drivstoff</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ $fuelLabels[$car->fuel_type] ?? $car->fuel_type }}</p>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-1">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="swap-horizontal-outline" class="text-base"></ion-icon>
                                <span>Girkasse</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ $gearboxLabels[$car->gearbox] ?? $car->gearbox }}</p>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-1">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="color-palette-outline" class="text-base"></ion-icon>
                                <span>Farge</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ $car->color }}</p>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-1">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="cash-outline" class="text-base"></ion-icon>
                                <span>Pris</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ number_format($car->price, 0, ',', ' ') }} kr</p>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 pb-1">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="calendar-number-outline" class="text-base"></ion-icon>
                                <span>Innkomst</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($car->arrived_date)->format('d. M Y') }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="flex items-center gap-2 text-sm text-gray-500">
                                <ion-icon name="card-outline" class="text-base"></ion-icon>
                                <span>Reg.nr</span>
                            </p>
                            <p class="text-base font-semibold text-gray-900">{{ $car->registration_number }}</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-md border border-gray-200 bg-white p-2">
                        <p class="text-sm text-gray-500">Beskrivelse</p>
                        <p class="text-base text-gray-900">{{ $car->description ?: 'Ingen beskrivelse.' }}</p>
                    </div>
                </div>


                {{-- SERVICE OVERSIKT SEKSJON --}}
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900">Serviceoversikt</h3>

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between rounded-md bg-gray-100 px-3 py-2">
                            <span class="text-sm font-medium text-gray-700">Aktive servicer</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $activeServices }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-md bg-gray-100 px-3 py-2">
                            <span class="text-sm font-medium text-gray-700">Fullførte</span>
                            <span class="text-lg font-semibold text-green-600">{{ $completedServices }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-md bg-gray-100 px-3 py-2">
                            <span class="text-sm font-medium text-gray-700">Totalt</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $totalServices }}</span>
                        </div>
                    </div>

                    <button type="button"
                            class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                        <ion-icon name="add" class="text-base"></ion-icon>
                        <span>Ny service</span>
                    </button>
                </div>
            </div>

            {{-- SERVICE OVERSIKT SEKSJON SLUTT --}}


            {{-- FREMTIDIG SERVICE SEKSJON --}}
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-xl font-semibold text-gray-900">Servicer & Reparasjoner ({{ $totalServices }})</h3>

                @if ($totalServices > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100 text-sm text-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-start">Tittel</th>
                                    <th class="px-3 py-2 text-start">Type</th>
                                    <th class="px-3 py-2 text-start">Planlagt</th>
                                    <th class="px-3 py-2 text-start">Fullført</th>
                                    <th class="px-3 py-2 text-start">Kostnad</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700">
                                @foreach ($services as $service)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-3 py-2 font-medium text-gray-900">{{ $service->title }}</td>
                                        <td class="px-3 py-2">{{ $service->type }}</td>
                                        <td class="px-3 py-2">{{ $service->scheduled_date ?: 'Ikke satt' }}</td>
                                        <td class="px-3 py-2">{{ $service->completed_date ?: '-' }}</td>
                                        <td class="px-3 py-2">{{ $service->real_cost ?? $service->estimated_cost ?? 0 }} kr</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-12 text-center">
                        <p class="mb-4 text-lg text-gray-500">Ingen servicer registrert for denne bilen</p>
                        <button type="button"
                                class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-800 transition hover:bg-gray-50">
                            <ion-icon name="add" class="text-base"></ion-icon>
                            <span>Legg til service</span>
                        </button>
                    </div>
                @endif
            </div>
            {{-- FREMTIDIG SERVICE SEKSJON SLUTT --}}
        </div>
    </div>
    {{-- Ikoner fra ionicons.io/ionicons --}}
    @once
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @endonce
</x-app-layout>
