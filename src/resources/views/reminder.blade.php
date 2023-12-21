<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Reminder List</title>
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <form id="reminderForm">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="remind_at">Remind At:</label>
                        <input type="datetime-local" class="form-control" id="remind_at" name="remind_at" required>
                    </div>
                    <div class="form-group">
                        <label for="event_at">Event At:</label>
                        <input type="datetime-local" class="form-control" id="event_at" name="event_at" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addReminder()">Add Reminder</button>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Remind At</th>
                            <th>Event At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reminderTableBody">
                        <!-- Reminder rows will be added dynamically here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function addReminder() {
            var title = $("#title").val();
            var description = $("#description").val();
            var remindAt = new Date($("#remind_at").val()).getTime();
            var eventAt = new Date($("#event_at").val()).getTime();
            var id = $("#id").val();
            var type = "POST";
            var url = "/api/reminders";


            if (id !== "") {
                type = "PUT"
                url = "api/reminders/" + id
            }
            // Validate input (you may want to perform more thorough validation)
            if (!title || !description || !remindAt || !eventAt) {
                alert("Please fill in all fields.");
                return;
            }
            $.ajax({
                url: url,
                type: type,
                data: {
                    title: title,
                    description: description,
                    remind_at: remindAt / 1000,
                    event_at: eventAt / 1000
                },

                success: function(response) {
                    var data = response.data;
                    alert("Berhasil insert data")
                    console.log(data);
                    var newRow = "<tr><td>" + data.id + "</td><td>" + data.title + "</td><td>" + data
                        .description + "</td><td>" + data.remind_at +
                        "</td><td>" + data.event_at + "</td><td>" +
                        "<button type='button' class='btn btn-warning btn-sm' onclick='editReminder(this)'>Edit</button> " +
                        "<button type='button' class='btn btn-danger btn-sm' onclick='deleteReminder(this)'>Delete</button></td></tr>";
                    $("#reminderTableBody").append(newRow);

                    // Clear the form fields
                    $("#title, #description, #remind_at, #event_at").val("");
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseJSON.message)

                }
            });


            // Add a new row to the table

        }



        function editReminder(button) {
            var row = $(button).closest("tr");
            var id = row.find("td:eq(0)").text();
            var title = row.find("td:eq(1)").text();
            var description = row.find("td:eq(2)").text();
            var remindAt = row.find("td:eq(3)").text();
            var eventAt = row.find("td:eq(4)").text();


            var remindAt = new Date(remindAt * 1000);

            // Format the date as a string compatible with datetime-local input
            var remindAt = remindAt.toISOString().slice(0, 16); // Remove seconds and milliseconds

            var eventAt = new Date(eventAt * 1000);
            console.log(eventAt);
            // Format the date as a string compatible with datetime-local input
            var eventAt = eventAt.toISOString().slice(0, 16); // Remove seconds and milliseconds

            // Set the value of the datetime-local input



            // Populate the form fields with the selected reminder's data
            $("#title").val(title);
            $("#id").val(id);
            $("#description").val(description);
            $("#remind_at").val(remindAt);
            $("#event_at").val(eventAt);

            // Remove the row from the table
            row.remove();
        }

        function deleteReminder(button) {
            var row = $(button).closest("tr");
            var id = row.find("td:eq(0)").text();
            var type = "DELETE"

            var url = "/api/reminders/" + id
            if (confirm("Are you sure")) {
                $.ajax({
                    url: url,
                    type: type,
                    success: function(response) {
                        alert("Delete succesful")
                        row.remove();
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseJSON.message)

                    }
                });
            }

        }

        $(document).ready(function() {
            var token = localStorage.getItem('token');
            if (!token) {
                document.location.href = "{{ url('/') }}"
            }

            $.ajaxSetup({
                headers: {
                    'Authorization': "Bearer " + token
                }
            });

            $.ajax({
                type: "GET",
                url: "/api/reminders", // Replace with your server-side script URL
                data: {
                    limit: 10
                },
                success: function(response) {
                    res = response;
                    if (res.data) {

                        $.each(res.data.reminders, function(idx, item) {
                            var newRow = "<tr><td>" + item.id + "</td><td>" + item.title +
                                "</td><td>" +
                                item.description + "</td><td>" + item.remind_at + "</td><td>" +
                                item.event_at +
                                "</td><td>" +
                                "<button type='button' class='btn btn-warning btn-sm' onclick='editReminder(this)'>Edit</button> " +
                                "<button type='button' class='btn btn-danger btn-sm' onclick='deleteReminder(this)'>Delete</button></td></tr>";
                            $("#reminderTableBody").append(newRow);
                        })
                    } else {
                        alert("Login failed. Please check your credentials.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseJSON.message)
                    if (jqXHR.status == 401) {
                        document.location.href = "{{ url('/') }}";
                    }

                }
            });
        });
    </script>

</body>

</html>
