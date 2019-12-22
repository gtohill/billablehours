<nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample10">
      <ul class="navbar-nav">
        <li class="nav-item active">
        <a class="nav-link" href="{{url('/accounts')}}">Clients <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{url('/accounts/create')}}">Create Client</a>
        </li>        
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{url ('/')}}" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown10">
            <a class="dropdown-item" href="{{url('/accounts')}}">Clients</a>
            <a class="dropdown-item" href="{{url('/accounts/create')}}">Create Clients</a>            
          </div>
        </li>
      </ul>
    </div>
  </nav>
  