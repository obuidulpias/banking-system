<style>
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    td, th {
    border: 1px solid #dddddd;
    padding: 8px;
    }

    tr:nth-child(even) {
    background-color: #dddddd;
    }
</style>

<table>
  <tr align="center">
    <th>User Id</th>
    <th>Transaction Type</th>
    <th>Tmount</th>
    <th>Fee</th>
    <th>Date</th>
  </tr>  
    @foreach ($withdrawals as $value)
    <tr>
        <td>{{ $value->user_id }}</td>
        <td>{{ $value->transaction_type }}</td>
        <td>{{ $value->amount }}</td>
        <td>{{ $value->fee }}</td>
        <td>{{ $value->date }}</td>
    </tr>
    @endforeach
</table>

