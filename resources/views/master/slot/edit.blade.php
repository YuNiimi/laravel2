<!DOCTYPE html>

<html>
<head>
<title>店舗別マスタ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body class="container">

<div class="mt-4">
    <h2>データ取得機種</h2>
    <table class="table w-100 mt-4">
    <thead>
        <td>slots_id</td>
        <td>slot_code</td>
        <td>slot_name</td>
        <td>slot_name_encode</td>
        <td>&nbsp;</td>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td>{{$data->id}}</td>
        <td>{{$data->sis}}</td>
        <td>{{$data->name}}</td>
        <td>{{$data->name_encode}}</td>
        <td><button type="button" class="btn btn-secondary">修正</button></td>
        </tr>
    @endforeach
    <tr>
    </tr>
    </tbody>
    </table>

        <div class="ml-4 border bg-light p-2">
        <h5>新規登録</h5>
            <form method="POST" action="/master/store/slot/create">
        @csrf
        <input type="hidden" name="store_id" value={{$store}}>
        <div>
            <label for="form-name" class="form-label">code(sis)</label>
            <input class="form-control" type="text" name="code" id="form-name" >
        </div>

        <div>
            <label for="form-tel" class="form-label">name</label>
            <input class="form-control" type="text" name="name" id="form-tel">
        </div>

        <div>
            <label for="form-email" class="form-label">name_encode</label>
            <input class="form-control" type="text" name="name_encode" id="form-email">
        </div>
        <button type="submit" class=" mt-2 btn btn-primary">追加</button>
        </form>
        </div>

</div>

<div class="mt-4">
<h2>角台リスト</h2>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>