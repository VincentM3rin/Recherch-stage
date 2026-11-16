<header style="background: #333; color: white; padding: 10px 20px;">
    <nav>
        <ul style="list-style: none; display: flex; gap: 15px; margin: 0; padding: 0; align-items: center;">
            <li><a href="{{ route('accueil') }}" style="color: white; text-decoration: none;">Accueil</a></li>
            <li><a href="{{ route('carte') }}" style="color: white; text-decoration: none;">Carte</a></li>
            <li><a href="{{ route('contact') }}" style="color: white; text-decoration: none;">Contact</a></li>

            @auth
                @if(Auth::user()->role === 'entreprise')
                    <li><a href="{{ route('entreprise.dashboard') }}" style="color: #90caf9; text-decoration: none;">Mon Espace Entreprise</a></li>
                    <li><a href="{{ route('entreprise.carte') }}" style="color: #90caf9; text-decoration: none;">Ajouter sur la carte</a></li>
                    <li><a href="{{ route('entreprise.candidatures') }}" style="color: #90caf9; text-decoration: none;">Candidatures reçues</a></li>
                @elseif(Auth::user()->role === 'etudiant')
                    <li><a href="{{ url('/etudiant/dashboard') }}" style="color: #a5d6a7; text-decoration: none;">Mon Espace Étudiant</a></li>
                @endif

                <li style="margin-left: auto;">
                    <span style="margin-right: 10px; font-size: 0.9em;">Connecté : <strong>{{ Auth::user()->nomUser }}</strong> ({{ Auth::user()->role }})</span>
                    <form action="{{ route('entreprise.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: #d32f2f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                            Déconnexion
                        </button>
                    </form>
                </li>
            @else
                <li style="margin-left: auto;"><a href="{{ route('entreprise.connexion') }}" style="color: white; text-decoration: none;">Espace Entreprise</a></li>
                <li><a href="{{ route('etudiant.connexion') }}" style="color: white; text-decoration: none;">Espace Étudiant</a></li>
            @endauth
        </ul>
    </nav>
</header>