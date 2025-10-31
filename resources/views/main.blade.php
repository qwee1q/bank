@php
    use App\Models\BankModel;
    $date = request('date');
    $bank_info = BankModel::query();
    if ($date) {
        $bank_info = $bank_info->whereDate('created_at', $date);
    }
    $bank_info = $bank_info->get();
    $balance = 0;
    foreach ($bank_info as $el){
        if ($el->income_or_spending == 'spending'){
            $balance -= $el->sum;
           }
        else{
               $balance += $el->sum;
        }
    }
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank</title>
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
    @if($errors->any())
        <div class="alert alert-danger container bg-dark">
            <ul class="list-group">
                @foreach($errors->all() as $error)
                    <li class="list-group-item bg-dark spending text-white-50">{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="d-flex justify-content-end text-white container">
        <p>Balance: {{$balance}}</p>
    </div>
    <div class="container mb-3">
        <label for="form" class="form-label text-white-50">Enter New Operation</label>
        <form action="/check_bank" method="post" class="form-control bg-dark" id="form">
            @csrf
            <label for="income/spending" class="form-label text-white-50">Income Or Spending</label>
            <input list="operations" type="text" name="income_or_spending" id="income_or_spending" placeholder="income/spending" class="form-control bg-secondary">
            <datalist id="operations">
                <option value="income"></option>
                <option value="spending"></option>
            </datalist>
            <label for="sum" class="form-label text-white-50">Sum</label>
            <input type="text" name="sum" id="sum" placeholder="enter sum" class="form-control bg-secondary">
            <label for="comment" class="form-label text-white-50">Comment</label>
            <textarea class="form-control bg-secondary" id="comment" name="comment" placeholder="enter comment" rows="3"></textarea><br>
            <button type="submit" class="btn btn-success">Send</button>
        </form>
    </div>
    <div class="d-flex justify-content-end text-white container">
        <form class="form-control bg-dark" action="{{ route('main_date') }}" method="get">
            @csrf
            <label for="date" class="form-label text-white-50">Choose Date:</label>
            <input type="date" id="date" name="date" class="form-control bg-secondary" onchange="this.form.submit()" value="{{ request('date') }}">
        </form>
    </div>
    <div class="accordion container bg-dark" id="accordionExample">
        <label for="accordion" class="form-label text-white-50">Operations:</label>
        <div class="accordion-item text-black" id="accordion">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    All Operations
                </button>
            </h2>
        </div>
    </div>
    <br>

    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            @foreach($bank_info as $el)
                @if($el->income_or_spending == "income")
                    <div class="alert container income " role="alert">
                        <label for="creat-income" class="form-label text-white-50 ">Date:</label>
                        <h4 class="h4 text-secondary" id="creat-income">
                            {{$el->created_at}}
                        </h4>
                        <div class="details">
                            <label for="badge-income" class="form-label text-white-50">Operation:</label>
                            <h4 class="h4 text-secondary" id="badge-income">
                            <span class="badge text-bg-success">
                                {{$el->income_or_spending}}
                            </span>
                            </h4>
                            <label for="sum-income" class="form-label text-white-50">Sum:</label>
                            <h4 class="h4 text-secondary" id="sum-income">
                                {{$el->sum}}
                            </h4>
                            <label for="comment-income" class="form-label text-white-50">Comment:</label>
                            <h3 class="h3 text-secondary" id="comment-income">
                                {{$el->comment}}
                            </h3>
                        </div>
                    </div>
                @elseif($el->income_or_spending == "spending")
                    <div class="container alert spending">
                        <label for="creat-spending" class="form-label text-white-50">Date:</label>
                        <h4 class="h4 text-secondary" id="creat-spending">
                            {{$el->created_at}}
                        </h4>
                        <div class="details">
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
                    </div>
                @else
                    <div class="container alert">
                        <h3 class="h3 text-warning">Strange Operation</h3>
                    </div>
                    <div class="container alert strange">
                        <label for="creat-strange" class="form-label text-white-50">Date:</label>
                        <h4 class="h4 text-secondary" id="creat-strange">
                            {{$el->created_at}}
                        </h4>
                        <label for="badge-strange" class="form-label text-white-50">Operation:</label>
                        <h4 class="h4 text-secondary" id="badge-strange">
                    <span class="badge text-bg-warning">
                        {{$el->income_or_spending}}
                    </span>
                        </h4>
                        <label for="sum-strange" class="form-label text-white-50">Sum:</label>
                        <h4 class="h4 text-secondary" id="sum-strange">
                            {{$el->sum}}
                        </h4>
                        <label for="comment-strange" class="form-label text-white-50">Comment:</label>
                        <h3 class="h3 text-secondary" id="comment-strange">
                            {{$el->comment}}
                        </h3>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
