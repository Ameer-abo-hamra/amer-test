<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{Route("change")}}" method="post">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>حالة الدفع</th>
                    <th>استلام الدفع</th>
                </tr>
            </thead>
            <tbody>
                <!-- بيانات الطلبات تأتي من قاعدة البيانات -->
                @foreach ($requests as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            <select name="payment_state[{{ $order->id }}]">
                                <option value="paid">تم الدفع</option>
                                <option value="unpaid">لم يتم الدفع</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="receive_state[{{ $order->id }}]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">تحديث الحالة</button>
    </form>

</body>
</html>
