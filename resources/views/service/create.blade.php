<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Registrer service') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">
                    <h3 class="text-2xl font-semibold tracking-tight text-gray-900">Opprett ny service</h3>
                    <p class="mt-1 text-sm text-gray-500">Fyll inn alle nødvendige detaljer for service og reparasjon.</p>
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
                    $scheduledDateValue = old('scheduled_date');
                    $completedDateValue = old('completed_date');

                    if ($scheduledDateValue && preg_match('/^\d{4}-\d{2}-\d{2}$/', $scheduledDateValue)) {
                        $scheduledDateValue = \Carbon\Carbon::parse($scheduledDateValue)->format('d.m.Y');
                    }

                    if ($completedDateValue && preg_match('/^\d{4}-\d{2}-\d{2}$/', $completedDateValue)) {
                        $completedDateValue = \Carbon\Carbon::parse($completedDateValue)->format('d.m.Y');
                    }
                @endphp

                <form action="{{ route('service.store') }}" method="POST" class="px-6 py-6">
                    @csrf

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="registration_number"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Registrering Nummer</label>
                            <select id="registration_number" name="registration_number" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                <option value="" disabled @selected(old('registration_number') === null)>Velg registrerings nummer</option>
                                @forelse ($cars as $car)
                                    <option value="{{ $car->registration_number }}"
                                        @selected(old('registration_number') === $car->registration_number)>
                                        {{ $car->registration_number }} - {{ $car->make }} {{ $car->model }}
                                    </option>
                                @empty
                                    <option value="" disabled>Ingen registrerings nummer funnet</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label for="priority" class="mb-1.5 block text-sm font-semibold text-gray-700">Prioritet</label>
                            <select id="priority" name="priority" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                <option value="Lav" @selected(old('priority') === 'Lav')>Lav</option>
                                <option value="Normal" @selected(old('priority', 'Normal') === 'Normal')>Normal</option>
                                <option value="Høy" @selected(old('priority') === 'Høy' || old('priority') === 'Hoy')>Høy</option>
                                <option value="Kritisk" @selected(old('priority') === 'Kritisk')>Kritisk</option>
                            </select>
                        </div>

                        <div>
                            <label for="type" class="mb-1.5 block text-sm font-semibold text-gray-700">Kategori</label>
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
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="estimated_cost" class="mb-1.5 block text-sm font-semibold text-gray-700">Estimert kostnad (kr)</label>
                            <input type="number" id="estimated_cost" name="estimated_cost" value="{{ old('estimated_cost') }}"
                                min="0" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                        </div>
                        

                        <div>
                            <label for="scheduled_date" class="mb-1.5 block text-sm font-semibold text-gray-700">Planlagt dato (for gjennomførelse)</label>
                            <input type="text" id="scheduled_date" name="scheduled_date"
                                value="{{ $scheduledDateValue }}" placeholder="dd.mm.åååå" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Format: dd.mm.åååå</p>
                        </div>
                        <div>
                            <label for="mechanic"
                                class="mb-1.5 block text-sm font-semibold text-gray-700">Ansvarlig mekaniker</label>
                            <select id="mechanic" name="mechanic" required
                                class="h-11 w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">
                                <option value="" disabled @selected(old('mechanic') === null)>Velg mekaniker</option>
                                @forelse ($mechanics as $mechanic)
                                    <option value="{{ $mechanic->name }}"
                                        @selected(old('mechanic') === $mechanic->name)>
                                        {{ $mechanic->name }} - {{ $mechanic->title }}
                                    </option>
                                @empty
                                    <option value="" disabled>Ingen mekanikere funnet</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="mb-1.5 block text-sm font-semibold text-gray-700">Beskrivelse</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-300 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div
                        class="mt-8 flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-0 pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('service') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                            Tilbake
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">
                            Lagre service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
