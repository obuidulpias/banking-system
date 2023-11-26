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
    <h3>{{ Session::get('message') }}</h3>
    <form action="{{ Route('create-new-deposit') }}" method="post">
            {{ csrf_field() }}
    <tr align="center">
        <th>Deposit Amount</th>
        <th><input name="deposit_amount"></input></th>
    </tr>  
    <tr align="center">
        <th>Transactions Type</th>
        <th><label><input type="radio"  name="transactions_type" value="Deposit">Deposit</label></th>
    </tr>
    <tr align="center">
        <th></th>
        <th> <input type="submit" name="btn" class="btn btn-success btn-block" value="Save Amount Info"></th>
    </tr>
</table>