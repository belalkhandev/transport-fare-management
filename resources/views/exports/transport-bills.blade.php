<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transport bill reports</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        h1, h2, h3,
        ul {
            margin: 0;
            padding: 0;
        }

        ul {
            list-style: none;
            margin-top:20px;
        }

        ul li {
            float: left;
            margin-right: 30px;
        }

        header {
            text-align: center;
        }

        .table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .table th {
            border: 1px solid #000;
            padding: 5px 10px;
        }
        .table td {
            border: 1px solid #000;
            font-size: 13px;
            padding: 3px 10px;
        }
    </style>
</head>
<body>
    <header>
        <h2>BAFSK BUS</h2>
        <h3>Transport bill reports</h3>

        <ul>
            @if($requestData['month'])
                <li>Month: {{ \Carbon\Carbon::createFromDate(now()->year, $requestData['month'], 1)->format('F') }}</li>
            @endif
            @if($requestData['year'])
                <li>Year: {{ \Carbon\Carbon::createFromDate($requestData['year'], 1, 1)->format('Y') }}</li>
            @endif

            @if($requestData['payment_status'])
                <li>Status: {{ $requestData['payment_status'] }}</li>
            @endif
        </ul>
    </header>

    <table class="table">
        <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Billing Month</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bills as $bill)
            <tr>
                <td>{{ $bill->student->student_id }}</td>
                <td>{{ $bill->student->name }}</td>
                <td>{{ $bill->student->contact_no }}</td>
                <td>{{ \Carbon\Carbon::createFromDate($bill->year, $bill->month, 1)->format('F Y') }}</td>
                <td>{{ $bill->amount }}</td>
                <td>
                    {{ $bill->is_paid ? 'Paid' : 'Unpaid' }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4">
                <b>Total</b>
            </td>
            <td colspan="2">
                <b>{{ number_format($totalAmount, 2) }}</b>
            </td>
        </tr>
        </tbody>
    </table>
</body>
</html>
