# Pytania i odpowiedzi do rozmowy technicznej

## 1. Czym różni się maszyna wirtualna od kontenera?

Maszyna wirtualna posiada własny system operacyjny i emulowany sprzęt.
Kontener korzysta z jądra systemu hosta, dlatego jest lżejszy i uruchamia się szybciej.

## 2. Do czego służy Docker Compose?

Docker Compose pozwala opisać i uruchomić wiele powiązanych usług z jednego pliku YAML.
W moim projekcie uruchamia NGINX, PHP, MariaDB, Prometheusa i Node Exportera.

## 3. Jaka jest rola NGINX-a?

NGINX przyjmuje żądania HTTP od użytkownika i przekazuje pliki PHP do kontenera PHP-FPM.
Pełni rolę serwera WWW i reverse proxy.

## 4. Dlaczego PHP działa w osobnym kontenerze?

Rozdzielenie usług ułatwia aktualizowanie, diagnozowanie i skalowanie aplikacji.
Awaria PHP nie musi oznaczać awarii bazy lub monitoringu.

## 5. Jak aplikacja łączy się z bazą danych?

Aplikacja używa nazwy usługi `db` jako hosta bazy.
Docker Compose zapewnia wewnętrzny DNS, dlatego nie używamy `localhost`.

## 6. Dlaczego MariaDB nie ma wystawionego publicznego portu?

Z bazy korzysta wyłącznie aplikacja wewnątrz sieci Docker Compose.
Brak publicznego portu ogranicza powierzchnię ataku.

## 7. Co oznacza mapowanie `8080:80`?

Port `8080` hosta jest przekazywany do portu `80` kontenera NGINX.

## 8. Do czego służy wolumin Dockera?

Wolumin przechowuje dane poza cyklem życia kontenera.
Dzięki temu usunięcie kontenera MariaDB nie musi usuwać danych bazy.

## 9. Czym różni się snapshot od backupu?

Snapshot zapisuje stan maszyny lub dysku w określonym momencie i zwykle zależy od tej samej infrastruktury.
Backup jest niezależną kopią danych, którą można przechowywać w innym miejscu i wykorzystać do odtworzenia.

## 10. Dlaczego sam backup nie wystarcza?

Backup trzeba regularnie testować.
Kopia, której nie da się odtworzyć, nie zapewnia realnego bezpieczeństwa.

## 11. Co oznacza błąd HTTP 502?

NGINX działa, ale nie może połączyć się z usługą znajdującą się za nim, na przykład z PHP-FPM.
W moim ćwiczeniu przyczyną był zatrzymany kontener `app`.

## 12. Co oznacza błąd HTTP 500?

Aplikacja została uruchomiona, ale napotkała wewnętrzny błąd.
W moim projekcie był to błąd logowania do MariaDB przez niepoprawne hasło.

## 13. Jak diagnozuję awarię kontenera?

Najpierw sprawdzam objaw przez `curl`, potem stan usług przez `docker compose ps`, a następnie logi przez `docker compose logs`.

## 14. Do czego służy `nginx -t`?

Sprawdza poprawność składni konfiguracji NGINX-a bez jej uruchamiania.
Pozwala wykryć błąd przed restartem usługi.

## 15. Do czego służy Prometheus?

Prometheus regularnie pobiera, zapisuje i pozwala analizować metryki systemów oraz aplikacji.

## 16. Do czego służy Node Exporter?

Node Exporter udostępnia Prometheusowi metryki systemu Linux, takie jak CPU, RAM, dyski i sieć.

## 17. Do czego służy `.env`?

Plik `.env` przechowuje wartości zmiennych środowiskowych, na przykład hasła i nazwy bazy.
Nie powinien trafiać do repozytorium.

## 18. Czym różni się `.env` od `.env.example`?

`.env` zawiera prawdziwe dane dostępowe.
`.env.example` jest bezpiecznym wzorem pokazującym, jakie zmienne trzeba skonfigurować.

## 19. Co robi pipeline CI?

Po wysłaniu zmian na GitHuba pipeline automatycznie pobiera projekt, sprawdza konfigurację Docker Compose i buduje obraz aplikacji.

## 20. Jak odtworzyć projekt od zera?

Podstawowy proces wygląda tak:

1. `git clone`
2. `cp .env.example .env`
3. uzupełnienie zmiennych
4. `docker compose up -d --build`
5. sprawdzenie przez `docker compose ps` i `curl`
6. odtworzenie danych z backupu
