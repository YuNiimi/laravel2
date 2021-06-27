<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>

<div>
    <!-- 店舗一覧 -->
    <table class="table w-50">
    <thead>
        <td>店舗id</td>
        <td>店舗名前</td>
        <td>店舗code</td>
    </thead>
    <tbody>
            @foreach($datas as $data)
                <tr>
                <td>{{$data->store_id}}</td>
                <td>{{$data->store}}</td>
                <td>{{$data->count}}</td>
                    <!-- @foreach($data as $el) -->
                    <!-- <td>{{$data->store}}</td> -->
                    <!-- @endforeach -->
                </tr>
            @endforeach
    </tbody>
    </table>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>