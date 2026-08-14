# ZyskajNaBank — PHP auth (branch: php-auth)

Ten branch zawiera proste endpointy PHP (PDO/MySQL) oraz frontend HTML/JS do rejestracji, logowania i logowania przez Google (Google Identity Services).

WAŻNE:
- Ten branch zawiera plik php/config.php z poświadczeniami bazy zgodnie z życzeniem — to może być niebezpieczne jeśli repo jest publiczne.
- GitHub Pages nie uruchamia PHP. Aby to działało musisz umieścić pliki z katalogu public_html oraz katalog php na serwerze z PHP i dostępem do bazy MySQL (phpMyAdmin).

Pliki:
- db_mysql.sql — skrypt tworzący bazę i tabelę users (jeśli potrzebujesz, uruchom w phpMyAdmin)
- php/config.php — konfiguracja PDO (zawiera DB host/name/user/pass)
- php/register.php, php/login.php, php/logout.php, php/google_signin.php, php/profile.php — endpointy
- public_html/*.html — strony frontend
- public_html/js/auth.js — klient Google Identity Services + fetch

Szybkie instrukcje wdrożenia:
1) W phpMyAdmin uruchom db_mysql.sql (jeśli baza jeszcze nie istnieje).
2) Wgraj zawartość public_html oraz php na serwer (public_html powinien być dostępny jako root web).
3) W Google Cloud Console utwórz OAuth Client ID (Web application) i ustaw Authorized redirect URI jeśli używasz serwera-side OAuth; dla Google Identity Services wystarczy Client ID. Wstaw Client ID do php/config.php ($googleClientId) i do data-client_id w HTML.
4) Otwórz /register.html i /login.html na Twoim serwerze i testuj.

Jeśli chcesz, mogę:
- usunąć poświadczenia z pliku konfiguracyjnego i dodać config.example.php oraz dodać config.php do .gitignore (bezpieczniej);
- dodać prostą walidację oraz ochronę przed brute-force;
- zintegrować CSRF tokeny.
