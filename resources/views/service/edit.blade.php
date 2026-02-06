<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Rediger service') }}
        </h2>
    </x-slot>

    @php
        $scheduledDate = old('scheduled_date', $service->scheduled_date);
        $completedDate = old('completed_date', $service->completed_date);

        if ($scheduledDate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $scheduledDate)) {
            $scheduledDate = \Carbon\Carbon::parse($scheduledDate)->format('d.m.Y');
        }

        if ($completedDate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $completedDate)) {
            $completedDate = \Carbon\Carbon::parse($completedDate)->format('d.m.Y');
        }
    @endphp

    <div class="py-8">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">
                    <h3 class="text-2xl font-semibold tracking-tight text-gray-900">Rediger service</h3>
                    <p class="mt-1 text-sm text-gray-500">Oppdater informasjon for {{ $service->registration_number }}.</p>
                </div>

                @if ($errors->any())
                    <div class="mx-6 mt-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold">Rett opp følgende feil:</p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $currentPriority = old('priority', $service->priority);
                    $selectedRegistrationNumber = old('registration_number', $service->registration_number);
                @endphp

                <form action="{{ route('service.update', $service->registration_number) }}" method="POST" class="px-6 py-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="registration_number"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Registreringsnummer</label>
                            <select id="registration_number" name="registration_number" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                @forelse ($cars as $car)
                                    <option value="{{ $car->registration_number }}"
                                        @selected($selectedRegistrationNumber === $car->registration_number)>
                                        {{ $car->registration_number }} - {{ $car->make }} {{ $car->model }}
                                    </option>
                                @empty
                                    <option value="" disabled>Ingen biler tilgjengelig</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label for="priority" class="mb-1.5 block text-sm font-semibold text-gray-700">Prioritet</label>
                            <select id="priority" name="priority" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                <option value="Lav" @selected($currentPriority === 'Lav')>Lav</option>
                                <option value="Normal" @selected($currentPriority === 'Normal')>Normal</option>
                                <option value="Høy" @selected($currentPriority === 'Høy' || $currentPriority === 'Hoy')>Høy</option>
                                <option value="Kritisk" @selected($currentPriority === 'Kritisk')>Kritisk</option>
                                @if (!in_array($currentPriority, ['Lav', 'Normal', 'Høy', 'Hoy', 'Kritisk'], true))
                                    <option value="{{ $currentPriority }}" selected>{{ $currentPriority }}</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="type" class="mb-1.5 block text-sm font-semibold text-gray-700">Type arbeid</label>
                            <select name="type" id="type" required
                            class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                            <option value="EU Kontroll" @selected(old('type') === 'EU Kontroll')>EU Kontroll</option>
                            <option value="Klargjøring for salg" @selected(old('type') === 'Klargjøring for salg')>Klargjøring for salg</option>
                            <option value="Glasskade" @selected(old('type') === 'Glasskade')>Glasskade</option>
                            <option value="Dekk skifte" @selected(old('type') === 'Dekk skifte')>Dekk skifte</option>
                            <option value="Bilpleie" @selected(old('type') === 'Bilpleie')>Bilpleie</option>
                           </select>
                        </div>
                        <div>
                            <label for="title" class="mb-1.5 block text-sm font-semibold text-gray-700">Tittel</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $service->title) }}" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="estimated_cost" class="mb-1.5 block text-sm font-semibold text-gray-700">Estimert kostnad (kr)</label>
                            <input type="number" id="estimated_cost" name="estimated_cost"
                                value="{{ old('estimated_cost', $service->estimated_cost) }}" min="0" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="real_cost" class="mb-1.5 block text-sm font-semibold text-gray-700">Reell kostnad (kr)</label>
                            <input type="number" id="real_cost" name="real_cost"
                                value="{{ old('real_cost', $service->real_cost) }}" min="0" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="scheduled_date" class="mb-1.5 block text-sm font-semibold text-gray-700">Planlagt dato</label>
                            <input type="text" id="scheduled_date" name="scheduled_date"
                                value="{{ $scheduledDate }}" placeholder="dd.mm.åååå" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Format: dd.mm.åååå</p>
                        </div>
                        <div>
                            <label for="completed_date" class="mb-1.5 block text-sm font-semibold text-gray-700">Ferdigstilt dato</label>
                            <input type="text" id="completed_date" name="completed_date"
                                value="{{ $completedDate }}" placeholder="dd.mm.åååå" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Format: dd.mm.åååå</p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="mechanic" class="mb-1.5 block text-sm font-semibold text-gray-700">Ansvarlig mekaniker</label>
                            <input type="text" id="mechanic" name="mechanic" value="{{ old('mechanic', $service->mechanic) }}" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="mb-1.5 block text-sm font-semibold text-gray-700">Beskrivelse</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">{{ old('description', $service->description) }}</textarea>
                        </div>
                    </div>

                    <div
                        class="mt-8 flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-0 pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('service') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                            Tilbake
                        </a>
                        <button type="submit"
                            onclick="document.getElementById('completed_date').value='{{ now()->format('d.m.Y') }}';"
                            class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">
                            Marker som ferdig
                        </button>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">
                            Oppdater service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
