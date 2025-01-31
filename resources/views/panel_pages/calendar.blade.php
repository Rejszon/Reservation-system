@extends('layouts.main')
@section('main')
<div id="calendar"></div>
{{-- TODO --}}
{{-- Czytamy z eventu wszystko i wypełniamy te formy napisz se funkcje showModal czy coś takiego i na Cickc funkcje pokaż jeden z formów 
potrzebujesz typu wizyty {bo to one ustalają długość wizyty na selectcie fajnie umieścić info o długości wizyty miejsce na opis co sie dzieje itp 
oraz datepicker z flowbite --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            open: false,
            mode: 'create',
            eventType: '',
            eventComment: '',
            eventDate: '',
            eventDuration: '',
            eventId: null, 
            message: '', 
            errors: {},

            saveEvent() {
                types = @json($types);
                duration = types.find(item => item.id == this.eventType).duration

                const eventData = {
                    type: this.eventType,
                    comment: this.eventComment,
                    date: this.eventDate,
                    duration: duration,
                };
                axios.post('/validate-appointment', eventData)
                    .then(response => {
                        if (response.data.success) {
                            this.message = 'Wizyta umówiona';
                            this.open = false;
                        } else {
                            this.errors = response.data.errors;
                            this.message = 'Błąd';
                        }
                    })
                    .catch(error => {
                        this.errors = { title: 'Wystąpił błąd' };
                        this.message = '';
                    });
            }
        });
    });
</script>

<div id="appointmentModal" x-data="$store.modal">
    <!-- Modal Background -->
    <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50 pointer-events-auto" x-show="open" x-transition>
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 z-60">
            <h3 class="text-xl font-semibold mb-4" x-text="mode === 'create' ? 'Umów wizytę' : 'Szczegóły wizyty'"></h3>
            <form @submit.prevent="saveEvent" x-show="mode === 'create'">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Typ wizyty</label>
                    <select
                        x-model="$store.modal.eventType"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" 
                        :class="{'border-red-500': errors.title}" 
                        :disabled="mode === 'view'"
                        required 
                    >
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->title." ".$type->getDuration()." ".$type->price."zl" }}</option>
                    @endforeach
                    </select>
                    <!-- Validation error for title -->
                    <p x-show="errors.title" class="text-red-500 text-sm mt-1" x-text="errors.title"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Komentarz dla terapeuty</label>
                    <textarea 
                        x-model="$store.modal.eventComment"
                        maxlength="200"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-lg"
                        :class="{'border-red-500': errors.description}"
                        :disabled="mode === 'view'"
                    ></textarea>
                    <!-- Validation error for description -->
                    <p x-show="errors.description" class="text-red-500 text-sm mt-1" x-text="errors.description"></p>
                </div>

                <!-- Success/Failure Message -->
                <div x-show="message" class="mt-4 text-green-500 text-sm" x-text="message"></div>

                <div class="flex justify-end mt-4">
                    <button type="button" @click="open = false" class="px-4 py-2 bg-red-500 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2" x-bind:disabled="mode === 'view'">Save</button>
                </div>
            </form>

            <!-- Read-Only Mode (Event Details) -->
            <div x-show="mode === 'view'" class="mt-4">
                <p><strong>Typ wizyty:</strong> <span x-text="eventType"></span></p>
                <p><strong>Komentarz:</strong> <span class="break-words text-wrap" x-text="eventComment"></span></p>
                <p><strong>Data:</strong> <span x-text="eventDate"></span></p>
                <p><strong>Czas trwania:</strong> <span x-text="eventDuration"></span></p>
                <div class="flex justify-end mt-4">
                    <button type="button" @click="open = false" class="px-4 py-2 bg-red-500 text-white rounded-lg">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>    
    <script> 
        let blockedDates = @json($schedule);
        blockedDates = blockedDates.map(event => ({
            start: event.start,
            end: event.end,
            display: event.background,
            color: event.color
        }));

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                dateClick: function(selectInfo) {
                    let clickedDate = selectInfo.date;
                    let isBlocked = blockedDates.some(event => {
                        let eventStart = new Date(event.start);
                        let eventEnd = new Date(event.end);
                        return clickedDate >= eventStart && clickedDate < eventEnd;
                    });

                    if (!isBlocked) {
                        Alpine.store('modal').open = true;
                        Alpine.store('modal').mode = 'create';
                        Alpine.store('modal').eventType = 1; //Tak nie wygląda to najlepiej ale jest tak dlatego że domyślnie typ jest na id
                        Alpine.store('modal').eventComment = '';
                        Alpine.store('modal').eventDuration = '';
                        Alpine.store('modal').eventDate = clickedDate.toISOString();
                    }
                },
                eventClick: function(selectInfo) {
                    Alpine.store('modal').open = true;
                    Alpine.store('modal').mode = 'view';
                    Alpine.store('modal').eventType = selectInfo.event.title;
                    Alpine.store('modal').eventComment = selectInfo.event.extendedProps.comment;
                    Alpine.store('modal').eventDuration = selectInfo.event.extendedProps.duration;
                    Alpine.store('modal').eventDate = selectInfo.event.start.toLocaleString('pl-PL', {
                    hour: '2-digit',
                    minute: '2-digit',
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                }).replace(',', '').replace('/', '.').replace('/', '.');
                },
                height: 'auto',
                initialView: 'timeGridWeek',
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                buttonText: {
                    today: "Dzisiaj",
                    week: "Tydzień",
                    year: "Rok",
                    month: "Miesiąc",
                },
                locale: 'pl',
                firstDay: 1,
                editable: true,
                selectable: true,
                allDaySlot: false,
                events: @json($events),
                headerToolbar: {
                    left: 'timeGridWeek,dayGridMonth',
                    center: 'title',
                    right: 'prev,next',
                },
                validRange: {
                    start: @json($today),
                    end: @json($limit),
                }
            });

            calendar.render();
        });
    </script>
@endpush

@endsection