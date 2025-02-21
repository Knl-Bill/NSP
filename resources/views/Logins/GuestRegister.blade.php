<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Register</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5 pt-5">
        <h2 class="text-center">Guest Register</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Check-in Date</th>
                    <th>Check-in Time</th>
                    <th>Check-in Gate</th>
                    <th>Stay At</th>
                    <th>Checkout Date</th>
                    <th>Checkout Time</th>
                    <th>Checkout Gate</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guests as $guest)
                <tr>
                    <td>{{ $guest->id }}</td>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->phoneno }}</td>
                    <td>{{ $guest->checkin_date }}</td>
                    <td>{{ $guest->checkin_time }}</td>
                    <td>{{ $guest->checkin_gate }}</td>
                    <td>{{ $guest->stay_at }}</td>
                    <td>{{ $guest->checkout_date ?? 'Pending' }}</td>
                    <td>{{ $guest->checkout_time ?? 'Pending' }}</td>
                    <td>{{ $guest->checkout_gate ?? 'Pending' }}</td>
                    <td>
                        @if(!$guest->checkout_date)
                            <button class="btn btn-danger" onclick="openCheckoutModal({{ $guest->id }}, '{{ addslashes($guest->name) }}')">Close Entry</button>
                        @else
                            <span class="badge bg-success">Closed</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="checkoutForm" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkoutModalLabel">Close Guest Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="guestId" name="guestId">
                        <p><strong>Guest Name:</strong> <span id="guestName"></span></p>
                        <label for="checkout_gate" class="form-label">Select Checkout Gate:</label>
                        <select class="form-select" id="checkout_gate" name="checkout_gate" required>
                            <option value="">Select Gate</option>
                            <option value="main">Main</option>
                            <option value="poovam">Poovam</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Close Entry</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCheckoutModal(id, name) {
            document.getElementById('guestId').value = id;
            document.getElementById('checkoutForm').action = "/CloseGuestEntry/" + id;
            document.getElementById('guestName').innerText = name; // Set the guest name in the modal

            var checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
            checkoutModal.show();
        }
    </script>
</body>
</html>
