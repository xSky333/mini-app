# Mini App – środowisko Docker Compose

Projekt przedstawia proste środowisko aplikacyjne uruchamiane za pomocą Docker Compose.

## Usługi

- NGINX – serwer WWW i reverse proxy
- PHP-FPM – aplikacja PHP
- MariaDB – baza danych
- Prometheus – zbieranie metryk
- Node Exporter – metryki systemu Linux

## Architektura

Przeglądarka → NGINX → PHP → MariaDB

Prometheus → Node Exporter

## Uruchomienie

1. Skopiuj przykładowy plik zmiennych:

```bash
cp .env.example .env
