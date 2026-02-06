<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Service og reparasjon') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <ion-icon name="checkmark-circle-outline" class="text-base"></ion-icon>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-gray-200 bg-white px-4 py-5 shadow-sm sm:px-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-4xl font-semibold tracking-tight text-gray-900">Service</h3>
                        <p class="mt-1 text-2xl text-gray-500">
                            {{ $services->count() }} {{ $services->count() === 1 ? 'oppgave totalt' : 'oppgaver totalt' }}
                        </p>
                    </div>
                    <a href="{{ route('service.create') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">
                        <ion-icon name="add" class="text-base"></ion-icon>
                        <span>Registrer service</span>
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                @if ($services->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-indigo-700">
                            <ion-icon name="construct-outline" class="text-2xl"></ion-icon>
                        </div>
                        <h4 class="text-base font-semibold text-gray-900">Ingen serviceoppgaver registrert</h4>
                        <p class="mt-2 text-sm text-gray-500">Legg til første oppgave for å komme i gang.</p>
                        <a href="{{ route('service.create') }}"
                            class="mt-5 inline-flex items-center justify-center gap-2 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                            <ion-icon name="add" class="text-base"></ion-icon>
                            <span>Registrer service</span>
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-4 py-4">Oppgave</th>
                                    <th class="px-4 py-4">Reg.nr</th>
                                    <th class="px-4 py-4">Planlagt</th>
                                    <th class="px-4 py-4">Ferdigstilt</th>
                                    <th class="px-4 py-4">Prioritet</th>
                                    <th class="px-4 py-4">Status</th>
                                    <th class="px-4 py-4">Kostnad</th>
                                    <th class="px-4 py-4">Mekaniker</th>
                                    <th class="px-4 py-4">Handlinger</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white text-sm text-gray-700">
                                @foreach ($services as $service)
                                    @php
                                        $priority = strtolower((string) $service->priority);
                                        $priorityClass = match ($priority) {
                                            'lav' => 'border border-emerald-200 bg-emerald-50 text-emerald-700',
                                            'normal' => 'border border-indigo-200 bg-indigo-50 text-indigo-700',
                                            'høy', 'hoy' => 'border border-amber-200 bg-amber-50 text-amber-700',
                                            'kritisk' => 'border border-red-200 bg-red-50 text-red-700',
                                            default => 'border border-gray-200 bg-gray-100 text-gray-700',
                                        };
                                        $isCompleted = !empty($service->completed_date);
                                        $statusClass = $isCompleted
                                            ? 'border border-emerald-200 bg-emerald-50 text-emerald-700'
                                            : 'border border-amber-200 bg-amber-50 text-amber-700';
                                        $statusLabel = $isCompleted ? 'Ferdig' : 'Planlagt';
                                        $scheduledForComplete = $service->scheduled_date
                                            ? \Carbon\Carbon::parse($service->scheduled_date)->format('d.m.Y')
                                            : '';
                                    @endphp
                                    <tr class="align-top">
                                        <td class="px-4 py-4">
                                            <p class="font-semibold text-gray-900">{{ $service->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $service->type }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 font-semibold text-gray-900">{{ $service->registration_number }}</td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            {{ $service->scheduled_date ? \Carbon\Carbon::parse($service->scheduled_date)->format('d.m.Y') : '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            {{ $service->completed_date ? \Carbon\Carbon::parse($service->completed_date)->format('d.m.Y') : '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $priorityClass }}">
                                                {{ $service->priority }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-base font-semibold text-gray-900">
                                            {{ number_format((int) $service->estimated_cost, 0, ',', ' ') }} kr
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">{{ $service->mechanic }}</td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('service.edit', $service->registration_number) }}"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 px-2 text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900"
                                                    title="Oppdater service">
                                                    <ion-icon name="create-outline" class="text-base"></ion-icon>
                                                </a>
                                                <form method="POST" action="{{ route('service.delete', $service->registration_number) }}" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Slette serviceoppgaven?')" title="Slett"
                                                        class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-red-200 px-2 text-red-600 transition hover:bg-red-50">
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
