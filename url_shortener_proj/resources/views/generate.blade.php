@extends('home')

@section('content')
    <div class="col-md-6 col-md-offset-3" style="text-align: center">
        <br>
        <form action="{{route('url.store')}}" method="post">
            {{csrf_field()}}
            <label for="original">Original Url:</label>
            <input type="text" name="original" class="form-control" placeholder="Paste Url You Want to Cut" required>
            <br>
            <label for="email">Email:</label>
            <input type="text" name="email" class="form-control" placeholder="Type Your Email (Optional)">
            <br>
            <button type="submit" class="btn btn-primary btn-block">Generate</button>
        </form>
    </div>
@endsection
