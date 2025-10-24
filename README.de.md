# Lane4 Contract
Dieses Package stellt zentrale Interfaces für einen Domain Driven Design-Ansatz bereit.
Es enthält ausschließlich Abstraktionen (Contracts), keine Implementierungen.

## Zweck
- Definiert gemeinsame Schnittstellen für verschiedene Komponenten.
- Ermöglicht es Entwicklern, eigene Implementierungen zu schreiben oder bestehende zu verwenden.
- Sorgt für lose Kopplung und Austauschbarkeit.

## Meta-Packages
Für einen schnellen Start mit Standard-Implementierungen existieren optionale Meta-Packages:
- lane4core/classVersion
- lane4core/factory
- lane4core/dotenv
- lane4core/dbConnection
- lane4core/dbSchema
- lane4core/dbQuery

Diese binden die Contracts sowie eine empfohlene Default-Implementierung ein.

## Features
- PSR-4 Namespaces für sauberes Autoloading
- ab PHP 8.1 kompatibel
- Code-Qualität:
    - PHP_CodeSniffer (PSR-12)
    - PHPStan Konfiguration vorhanden
- Docker- und Makefile-Unterstützung für einheitliche Entwicklung

## Mindest-Voraussetzungen
- PHP 8.1+
- Composer
- Optional: Docker/Docker Compose
- Optional: Make (GNU Make)

## Installation
Als Abhängigkeit einbinden:
```bash
composer require lane4core/contract
```

## Struktur
- src/ … Enthält die PHP-Interfaces (Contracts)
- support/ … Hilfsdateien (Docker, Skripte)
- .github/ … CI/CD-Workflows
- phpcs.xml … Regeln für PHP_CodeSniffer
- phpstan.neon … Statische Analyse-Konfiguration
- Makefile … Abkürzungen für häufige Tasks

## Nutzung
Binde die Interfaces in deinem Projekt per Composer ein und implementiere sie in deinen eigenen Packages.

Beispiel Composer-Autoload (psr-4) in deinem Projekt:
```json
{
  "autoload": {
    "psr-4": {
      "DeinVendor\\DeinPackage\\": "src/"
    }
  }
}
```

Nach Änderungen an Namespaces/Autoload:
```bash
make autoload
```

## Entwicklung
Code-Style prüfen:
```bash
make phpcs
```

Statische Analyse:
```bash
make phpstan
```

## Tests
Dieses Repository stellt Contracts bereit. Implementierungsprojekte sollten eigene PHPUnit-Tests enthalten. 
Falls du Tests zu den Contracts (z. B. Contract-Compliance) ergänzen willst, füge sie in deinem Implementierungs-Repository hinzu und referenziere dieses Package als Abhängigkeit.

## Versionierung
SemVer. Breaking Changes nur in Major-Releases. Contracts sind auf Stabilität ausgelegt; Änderungen erfolgen konservativ.

## Lizenz
Siehe LICENSE im Repository.
