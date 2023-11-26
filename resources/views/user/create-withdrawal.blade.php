<style>
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 50%;
    align:center;
    }

    td, th {
    border: 1px solid #dddddd;
    padding: 8px;
    }

    tr:nth-child() {
    background-color: #dddddd;
    }
</style>

<table>
    <h3 align="center">{{ Session::get('message') }}</h3>
    <form action="{{ Route('create-new-withdrawal') }}" method="post">
            {{ csrf_field() }}
    <tr align="center">
        <th>Withdrawal Amount</th>
        <th><input name="withdrawal_amount"></input></th>
    </tr>  
    <tr align="center">
        <th>Transactions Type</th>
        <th><label><input type="radio"  name="transactions_type" value="Withdrawal">Withdrawal</label></th>
    </tr>
    <tr align="center">
        <th></th>
        <th> <input type="submit" name="btn" class="btn btn-success btn-block" value="Save Amount Info"></th>
    </tr>
</table>