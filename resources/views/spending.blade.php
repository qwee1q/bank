<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incomes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/incomes">All Incomes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/spending">All Spending</a>
                </li>
            </ul>
        </div>

    </div>
</nav>
<div class="d-flex justify-content-end text-white container">
    <p>Total spending:{{$all_spending}}</p>
</div>
<div class="container">
    <h4 class="h4 text-secondary">Operations:</h4>
</div>
@foreach($bank_info as $el)
    @if($el->income_or_spending == "spending")
        <div class="alert container spending" role="alert">
            <label for="creat-spending" class="form-label text-white-50">Date:</label>
            <h4 class="h4 text-secondary" id="creat-spending">
                {{$el->created_at}}
            </h4>
            <label for="badge-spending" class="form-label text-white-50">Operation:</label>
            <h4 class="h4 text-secondary" id="badge-spending">
                    <span class="badge text-bg-danger">
                        {{$el->income_or_spending}}
                    </span>
            </h4>
            <label for="sum-spending" class="form-label text-white-50">Sum:</label>
            <h4 class="h4 text-secondary" id="sum-spending">
                {{$el->sum}}
            </h4>
            <label for="comment-spending" class="form-label text-white-50">Comment:</label>
            <h3 class="h3 text-secondary" id="comment-spending">
                {{$el->comment}}
            </h3>
        </div>
    @endif
@endforeach
</body>
</html>
