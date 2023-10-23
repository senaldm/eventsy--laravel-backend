



<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Generate Tickets</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('createqr') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="event_name">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name" required>
                        </div>

                        <div class="form-group">
                            <label for="ticket_type">Ticket Type</label>
                            <input type="text" class="form-control" id="ticket_type" name="ticket_type" required>
                        </div>

                        <div class="form-group">
                            <label for="qrcode_size">QR Code Size</label>
                            <input type="number" class="form-control" id="qrcode_size" name="qrcode_size" required>
                        </div>

                        <div class="form-group">
                            <label for="sample_ticket">Sample Ticket Image</label>
                            <input type="file" class="form-control-file" id="sample_ticket" name="sample_ticket" accept="image/jpeg, image/png" required>
                        </div>

                        <div class="form-group">
                            <label for="qrcode_location">QR Code Location</label>
                            <select class="form-control" id="qrcode_location" name="qrcode_location" required>
                                <option value="bottom-right">Bottom Right</option>
                                <option value="bottom-left">Bottom Left</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="no_of_tickets">Number of Tickets</label>
                            <input type="number" class="form-control" id="no_of_tickets" name="no_of_tickets" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Generate Tickets</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
