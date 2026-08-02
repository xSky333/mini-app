# Mini-playbook diagnozy awarii

## 1. Sprawdź objaw

curl -I http://localhost:8080

- 200 — aplikacja działa
- 500 — problem aplikacji lub bazy danych
- 502 — NGINX nie może połączyć się z aplikacją
- brak odpowiedzi — problem z kontenerem, portem, siecią lub firewallem

## 2. Sprawdź kontenery

docker compose ps

Sprawdzam, czy nginx, app i db mają status running.

## 3. Sprawdź logi

docker compose logs --tail=50 nginx
docker compose logs --tail=50 app
docker compose logs --tail=50 db

## 4. Sprawdź konfigurację i zasoby

docker compose config
docker compose exec nginx nginx -t
df -h
free -h

## 5. Napraw i potwierdź działanie

docker compose restart nazwa_uslugi

Jeżeli zmieniono zmienne środowiskowe:

docker compose up -d --force-recreate --no-deps app

Na końcu:

docker compose ps
curl -I http://localhost:8080
