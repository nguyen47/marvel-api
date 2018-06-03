<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
  <div class="row">    
    <div class="col-xs-8 col-xs-offset-2">
      <form action="{{route('getHero')}}" method="GET">
      <div class="input-group">
        <input type="text" class="form-control" name="characters" placeholder="Search term...">
        <span class="input-group-btn">
          <input class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></input>
        </span>
      </div>
    </form>
    </div>
  </div>
</div>

