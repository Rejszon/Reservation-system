@extends('layouts.main')
@section('main')
<div id="calendar"></div>
{{-- TODO --}}
{{-- Czytamy z eventu wszystko i wypełniamy te formy napisz se funkcje showModal czy coś takiego i na Cickc funkcje pokaż jeden z formów 
potrzebujesz typu wizyty bo to one ustalają długość wizyty na selectcie fajnie umieścić info o długości wizyty miejsce na opis co sie dzieje itp 
oraz datepicker z flowbite --}}

<div id="createAppointmentForm" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-semibold mb-4">Umów wizytę</h3>
        <form id="calendarForm">
            <div class="mb-4">
                <label for="eventTitle" class="block text-sm font-medium text-gray-700">Event Title</label>
                <input type="text" id="eventTitle" name="eventTitle" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required />
            </div>
            <div class="mb-4">
                <label for="eventDescription" class="block text-sm font-medium text-gray-700">Event Description</label>
                <textarea id="eventDescription" name="eventDescription" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" class="px-4 py-2 bg-red-500 text-white rounded-lg" id="cancelBtn">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="viewAppointmentForm" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-semibold mb-4">Form Title</h3>
        <form id="calendarForm">
            <div class="mb-4">
                <label for="eventTitle" class="block text-sm font-medium text-gray-700">Event Title</label>
                <input type="text" id="eventTitle" name="eventTitle" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg" required />
            </div>
            <div class="mb-4">
                <label for="eventDescription" class="block text-sm font-medium text-gray-700">Event Description</label>
                <textarea id="eventDescription" name="eventDescription" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" class="px-4 py-2 bg-red-500 text-white rounded-lg" id="cancelBtn">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg ml-2">Save</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script> 
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                dateClick: function(){
                    alert('alert');
                },
                eventClick: function(info){
                    console.log(info.event.extendedProps);
                    alert('alert2');
                },
                height: 'auto',
                initialView: 'timeGridWeek',
                slotMinTime: '8:00:00',
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
            });
            calendar.render();
        });
        
    </script>
@endpush
@endsection
