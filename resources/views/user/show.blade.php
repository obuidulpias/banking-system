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
    <th>Name</th> 
    <th>Transaction Type</th>
    <th>Amount</th>
    <th>Courrent Balance</th>
  </tr>  
    @foreach ($datas as $key => $value)
        <tr>
            <td>{{ $value->name }}</td>           
            <td>{{ $value->transaction_type }}</td>
            <td>{{ $value->amount }}</td>
            <td>{{ $value->balance }}</td>
        </tr>

    @endforeach
</table>

