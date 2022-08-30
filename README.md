# Test task for riverstart

[Task](https://docs.google.com/document/d/1oSTzvjFFYXWqMoCtP5yj0o0cqYAGk-xTlYDuw7XitRY/edit)

## Installation

Clone the repo locally:

```sh
git clone git@github.com:goodmartian/test-riverstart.git
cd test-riverstart
```

Setup configuration:

```sh
cp .env.example .env
```

Run Sail containers

```sh
./vendor/bin/sail up -d
```

Install PHP dependencies:

```sh
sail composer install
```
