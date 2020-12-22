  <!-- Notifications Dropdown Menu -->
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      @php
        $numeroNotificaciones = count(auth()->user()->unreadNotifications);
        $numeroDeLikes = 0;
        $tiempoLikes = '';
        $numeroDeComentarios = 0;
        $tiempoComentarios = '';
      @endphp
      <i class="far fa-bell"></i>
      @if ($numeroNotificaciones != 0)
      <span class="badge badge-warning navbar-badge">{{ $numeroNotificaciones }}</span>
      @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-header">Notificaciones</span>
      @foreach (auth()->user()->unreadNotifications as $notification) 
        @if ($notification->type == 'App\Notifications\LikeNotification')
            @php
                $numeroDeLikes+=1;
                $tiempoLikes = $notification->created_at->diffForHumans();
            @endphp
        @endif
        @if ($notification->type == 'App\Notifications\CommentNotification')
            @php
                $numeroDeComentarios+=1;
                $tiempoComentarios = $notification->created_at->diffForHumans();
            @endphp
        @endif
      @endforeach
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> 4 new messages
        <span class="float-right text-muted text-sm">3 mins</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-users mr-2"></i> 8 friend requests
        <span class="float-right text-muted text-sm">12 hours</span>
      </a>
      @if ($numeroDeLikes != 0)
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-thumbs-up"></i> {{ $numeroDeLikes }} Nuevo reporte
          <span class="float-right text-muted text-sm">{{ $tiempoLikes }}</span>
        </a>
      @endif
      @if ($numeroDeComentarios != 0)
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-comments"></i> {{ $numeroDeComentarios }} Nuevo reporte
        <span class="float-right text-muted text-sm">{{ $tiempoComentarios }}</span>
      </a>
      @endif
     
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
  </li>