# Lane4 Contract
This package provides central interfaces for a Domain Driven Design approach.
It contains only abstractions (Contracts), no implementations.

## Purpose
- Defines common interfaces for various components.
- Allows developers to write their own implementations or use existing ones.
- Ensures loose coupling and interchangeability.

## Meta-Packages
For a quick start with standard implementations, optional meta-packages exist:
- lane4core/classVersion
- lane4core/factory
- lane4core/dotenv
- lane4core/dbConnection
- lane4core/dbSchema
- lane4core/dbQuery

These include the contracts as well as a recommended default implementation.

## Features
- PSR-4 namespaces for clean autoloading
- Compatible with PHP 8.1+
- Code quality:
    - PHP_CodeSniffer (PSR-12)
    - PHPStan configuration available
- Docker and Makefile support for consistent development

## Minimum Requirements
- PHP 8.1+
- Composer
- Optional: Docker/Docker Compose
- Optional: Make (GNU Make)

## Installation
Add as a dependency:
```bash
composer require lane4core/contract
```

## Structure
- src/ … Contains the PHP interfaces (Contracts)
- support/ … Helper files (Docker, scripts)
- .github/ … CI/CD workflows
- phpcs.xml … Rules for PHP_CodeSniffer
- phpstan.neon … Static analysis configuration
- Makefile … Shortcuts for common tasks

## Usage
Include the interfaces in your project via Composer and implement them in your own packages.

Example Composer autoload (psr-4) in your project:
```json
{
  "autoload": {
    "psr-4": {
      "YourVendor\\YourPackage\\": "src/"
    }
  }
}
```

After changes to namespaces/autoload:
```bash
make autoload
```

## Development
Check code style:
```bash
make phpcs
```

Static analysis:
```bash
make phpstan
```

## Tests
This repository provides contracts. Implementation projects should include their own PHPUnit tests. 
If you want to add tests for the contracts (e.g., contract compliance), add them in your implementation repository and reference this package as a dependency.

## Versioning
SemVer. Breaking changes only in major releases. Contracts are designed for stability; changes are made conservatively.

## License
See LICENSE in the repository.
