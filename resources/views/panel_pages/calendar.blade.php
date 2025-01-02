@extends('layouts.main')
@section('main')
<div id="calendar"></div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script> 
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                dateClick: function(){
                    alert('alert');
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
