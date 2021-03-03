@component('mail::message')
# Electronic Receipt

Thank you for purchasing! Here is your receipt
<style>
    /* .th, .td {
        border: 1px solid black;
    } */
</style>

<table width="100%" class="tb">
    <thead>
        <th class="th" style="text-align: left;">Reference #</th>
        <th class="th" style="text-align: left;">Product</th>
        <th class="th" style="text-align: right;">Amount</th>
    </thead>
    <tbody>
        @foreach ($info as $in)
            <tr>
                <td class="td">{{$in['id']}}</td>
                <td class="td">{{$in['type']}}</td>
                <td class="td" style="text-align: right;">PHP {{$in['amount']}}</td>
            </tr>
        @endforeach
        <tr><td colspan="3"><hr></td></tr>
        <tr>
            <td colspan="2"><b>Total:</b></td>
            <td class="td" style="text-align: right;"><b>{{$total}}</b></td>
        </tr>
    </tbody>
</table>

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}
<br>
<br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
