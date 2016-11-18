<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      @if(Auth::check())
        @if(Auth::user()->rights == "planner")
          <a class="navbar-brand" href="/Overzicht">Snelle Wiel</a>
        @elseif(Auth::user()->rights == "chauffeur")
          <a class="navbar-brand" href="/Pakbonnen">Snelle Wiel</a>
        @elseif(Auth::user()->rights == "administratie")
          <a class="navbar-brand" href="/Orders">Snelle Wiel</a>
        @endif
      @endif
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        @if(Auth::check())
          @if(Auth::user()->rights == "planner")
            <li><a href="/Chauffeurs">Chauffeurs</a></li>
            <li><a href="/Orders">Orders</a></li>
            <li><a href="/Overzicht">Overzicht</a></li>
            <li><a href="/Planningen">Planningen</a></li>
            <li><a href="/Wagens">Wagens</a></li>
          @elseif(Auth::user()->rights == "administratie")
            <li><a href="/Orders">Orders</a></li>
          @elseif(Auth::user()->rights == "chauffeur")
            <li><a href="/Pakbonnen">Pakbonnen</a></li>
          @endif
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
          <p class="navbar-text text-capitalize">Welkom {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
          <li><a href="/logout">Uitloggen</a></li>
        @else
          <li><a href="/login">Inloggen</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>