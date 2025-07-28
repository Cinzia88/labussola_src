@extends('layouts.admin')
@section('styles')
    <style>
        .rossofc {
            background-color: #e60a0a !important;
            border: 1px solid #e60a0a !important;
        }

        .verdefc {
            background-color: #42f554 !important;
            border: 1px solid #42f554 !important;
        }

        .blufc {
            background-color: #0000ff !important;
            border: 1px solid #0000ff !important;
        }

        .giallofc {
            background-color: #f5e042 !important;
            border: 1px solid #f5e042 !important;
        }

        .arancionefc {
            background-color: #f58a42 !important;
            border: 1px solid #f58a42 !important;
        }

        .violafc {
            background-color: #9b42f5 !important;
            border: 1px solid #9b42f5 !important;
        }
    </style>
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            Scadenziario
        </div>

        <div class="card-body">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" />
            <div id="calendar"></div>

        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function() {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek, basicDay'
                },
                // put your options and callbacks here
                events: [
                    @foreach ($events as $event)
                        {
                            title: '{{ $event->nome . ' - ' . $event->created_by->name }}',
                            start: '{{ \Carbon\Carbon::createFromFormat(config('panel.date_format'), $event->data)->format('Y-m-d') }}',
                            url: '{{ url('admin/preventivos') . '/' . $event->preventivo_id }}',
                            className: '{{ $event->colore_eticchetta }}'
                        },
                    @endforeach
                ],
                eventRender: function(event, element) {
                    element.find('.fc-title').html(event.title);
                },
            })
        });
    </script>

@stop
