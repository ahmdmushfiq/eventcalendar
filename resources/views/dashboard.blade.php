<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ URL::asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('backend/assets/css/custom.min.css') }}" id="app-style" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        #calendar .fc-daygrid-day {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-primary">Logout</button>
                    </form>
                </div>
                <div class="card-body" style="display: flex;">
                    <div class="col-md-12">
                        <div id="calendar"></div>
                    </div>
                    <div class="col-md-4">
                        <div id="work-details" class="m-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Add Event Modal --}}

    <div class="modal fade show" id="event-modal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5>Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="post" id="form-event">
                        @csrf
                        <div class="row event-form">
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Event Name</label>
                                    <input class="form-control d-block" placeholder="Enter event name" type="text"
                                        name="event_name" required>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label>Event Date</label>
                                    <div class="input-group">
                                        <input type="date" name="event_date" id="event-start-date"
                                            class="form-control flatpickr flatpickr-input" placeholder="Select date" required>
                                        <span class="input-group-text"><i class="ri-calendar-event-line"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control d-block" placeholder="Enter a description" rows="3"
                                        spellcheck="false" name="description"></textarea>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div class="hstack gap-2 justify-content-end">
                            <button type="submit" class="btn btn-success" id="btn-save-event">Add Event</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal-content-->
        </div> <!-- end modal dialog-->
    </div>

    {{-- View Event Modal --}}

    <div class="modal fade show" id="view-event" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="needs-validation view-event" name="event-form" novalidate="">
                        @csrf
                        <input type="hidden" id="event_id">
                        <div class="text-end">
                            <a href="#" class="btn btn-sm btn-soft-primary" id="edit-event-btn" data-id=""
                                onclick="editEvent()" role="button">Edit</a>
                        </div>
                        <div class="event-details">
                            <div class="d-flex mb-2">
                                <div class="flex-grow-1 d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="ri-calendar-event-line text-muted fs-16"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="d-block fw-semibold mb-0" id="event_date"></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <i class="ri-discuss-line text-muted fs-16"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="d-block text-muted mb-0" id="event_description"></p>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-soft-danger" id="delete_event"><i
                                    class="ri-close-line align-bottom"></i> Delete</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal-content-->
        </div> <!-- end modal dialog-->
    </div>

    {{-- Event Edit Modal --}}
    <div class="modal fade show" id="edit_event_modal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5>Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="post" id="edit-event-form" novalidate="">
                        @csrf
                        <input type="hidden" name="event_id" id="edit_event_id">
                        <div class="row event-form">
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Event Name</label>
                                    <input class="form-control d-block" placeholder="Enter event name" type="text"
                                        name="event_name" id="edit_event_title" required>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label>Event Date</label>
                                    <div class="input-group">
                                        <input type="date" name="event_date" id="edit_event_date"
                                            class="form-control flatpickr flatpickr-input" placeholder="Select date" required>
                                        <span class="input-group-text"><i class="ri-calendar-event-line"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control d-block" id="edit_event_description"
                                        placeholder="Enter a description" rows="3" spellcheck="false"
                                        name="description"></textarea>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div class="hstack gap-2 justify-content-end">
                            <button type="submit" class="btn btn-success" id="btn-save-event">Update Event</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal-content-->
        </div> <!-- end modal dialog-->
    </div>




</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" referrerpolicy="no-referrer">
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ URL::asset('backend/assets/js/layout.js') }}"></script>
<script>
    let row = 1;
    let selectedDate;
    let calendarEl = document.getElementById('calendar');
    let calendar;
    $(document).ready(function() {
        calender();
        flatpickr(".flatpickr-input", {
        theme: "material_blue", // Use a material design style
        dateFormat: "Y-m-d",
        });
    });
    function editEvent() {
        var id = $('#event_id').val();
        $.ajax({
            type: 'GET',
            url: "{{ route('calendar.edit', ':id') }}".replace(':id', id),
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status == 'success') {
                    console.log(response);
                    $('#edit_event_title').val(response.data.event_name);
                    $('#edit_event_date').val(response.data.event_date);
                    $('#edit_event_description').val(response.data.description);
                    $('#edit_event_id').val(response.data.id);
                    $('#edit_event_modal').modal('show');
                    $('#view-event').modal('hide');
                }
            }
        })
    }

    $('#edit-event-form').submit(function(e) {
        e.preventDefault();
        var id = $('#edit_event_id').val();
        var formData = $(this).serialize();
        $.ajax({
            type: "PUT",
            url: "{{ route('calendar.update', ':id') }}".replace(':id', id),
            data: formData,
            success: function(response) {
                if (response.status == 'success') {
                    swal.fire({
                        icon: 'success',
                        title: 'Event updated successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                $('#edit_event_modal').modal('hide');
                calender();
            }
        });
    });


    $(document).on('click', '#delete_event', function() {
        var id = $('#event_id').val();
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('calendar.destroy', ':id') }}".replace(':id', id),
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            swal.fire({
                                icon: 'success',
                                title: 'Event deleted successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#view-event').modal('hide');
                            calender();
                        }
                    }
                });
            }
        });
    });
 
    
    $('#form-event').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "post",
            url: "{{ route('calendar.store') }}",
            data: formData,
            success: function(response) {
                if (response.status == 'success') {
                    swal.fire({
                        icon: 'success',
                        title: 'Event added successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                $('#event-modal').modal('hide');
                $('#form-event')[0].reset();
                calender();
            }
        });
    })
   

   


    function calender() {
        $('#work-details').html('');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            timeZone: 'local',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek',
            },
            events: {
                url: "{{ route('get-calendar-events') }}",
                method: 'POST',
                extraParams: {
                    _token: '{{ csrf_token() }}',
                },
                failure: function() {
                    alert('there was an error while fetching events!');
                },
                color: 'yellow', // a non-ajax option
                textColor: 'black' // a non-ajax option

            },
            dateClick: function(info) {
                selectedDate = moment(info.dateStr).format("YYYY-MM-DD");
                $('#event-start-date').val(selectedDate);
                $('#event-modal').modal('show');
            },
            eventClick: function(info) {
                var eventTitle = info.event.title;
                var date = moment(info.event.start).format("dddd, MMMM D, YYYY"); 
                var description = info.event.extendedProps.description;
                var event_id = info.event.id;
                $('#modal-title').html(eventTitle);
                $('#event_date').html(date);
                $('#event_description').html(description);
                $('#event_id').val(event_id);
                $('#view-event').modal('show');
            },

        });
        calendar.render();
    }

    




    

   
</script>

</html>