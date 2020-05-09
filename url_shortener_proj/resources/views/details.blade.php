<!DOCTYPE HTML>
<html lang="en">

@include('parts._head')

<div class="col-md-6 col-md-offset-3" style="text-align: center">
    <br>
    <div class="col-md-6-col-md-offset-3">
        <strong>Original Url:</strong>
        <a href="{{$url->original}}" target="_blank">{{$url->original}}</a>

    </div>
    <br>
    <div class="col-md-6-col-md-offset-3">
        <strong>Generated Short Url:</strong>
        <a href="{{route('urls.all', $url)}}" target="_blank">{{$url->short}}</a>

    </div>
    <br>
    <div class="col-md-6-col-md-offset-3">
        <strong>All View Count:</strong>
        {{$url->all_views}}

    </div>
    <br>
    <div class="col-md-6-col-md-offset-3">
        <strong>Unique View Count:</strong>
        {{$url->unique_views}}
    </div>

</div>
</body>
</html>





