
# Mitigations Browser

This repo is basically a ripoff of [Mitre's ATT&CK website](https://attack.mitre.org/tactics/enterprise/) - an open source knowledge base of adversary tactics and techniques based on real-world observations. #with_laravel


## Installation

The process is simple across any LAMP-based environment:

- copy the .env.example into .env with sufficient 
- run migrations with `php artisan migrate`

## Available commands

`php artisan mitre:attack` - Fetch and populate dataset from Mitre's ATT&CK github into database.

## REST
There is also REST api onboard:

| URL | Method | Description |
| --- | ------ | ----------- | 
| /api/tactics    | GET    | Collection of all tactics |
| /api/techniques | GET    | Collection of all techniques/subtechniques |
| /api/techniques/{external_id} | GET | Technique or subtechnique by external_id |

## Tests

You can run tests with `php artisan test` command.  
There are two test suites:
- Units
- Functional

## License

Mitigations Browser is open-source. Please, feel free to use and modify anything you would find useful!
