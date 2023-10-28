<!DOCTYPE html>
<html>

<head>
    <title>Tickets PDF</title>
</head>
<style>
    div {
        float: left;
        /* display: flex;
        flex-wrap: wrap;
        justify-content: flex-start; */
    }

    img {
        margin: 10px;
        /* Adjust the margin as needed */
    }
</style>

<body>
    <h1>Tickets</h1>

    </div>
    @foreach($Tickets as $ticket)
    <div style="page-break-before: always;">

        <img src="data:image/png;base64,{{ base64_encode($ticket->encode('png')) }}" alt="QR Code" width="200" height="200">
    </div>
    @endforeach
</body>

</html>