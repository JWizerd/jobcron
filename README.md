# jobcron

A service used to get pertinent job posting information from different job sites based on predefined queries

USES:

- php 7.2
- mongo db [docs here](https://docs.mongodb.com/php-library/master/) for information on how
to tame this beast.
- guzzle
- php mailer lib
- php unit

```
.
├── README.md
├── docker
│   ├── dev
│   │   ├── Dockerfile
│   │   ├── apache2.conf
│   │   ├── bootstrap.sh
│   │   ├── build.sh
│   │   ├── composer.json
│   │   ├── config.sh
│   │   ├── php.ini
│   │   └── run.sh
│   ├── production
│   │   ├── Dockerfile
│   │   ├── apache2.conf
│   │   ├── config.sh
│   │   ├── deploy.sh
│   │   ├── mysql.cnf
│   │   ├── run.sh
│   │   └── version.txt
│   └── mongo
│       ├── README.md
│       ├── config.sh
│       └── run.sh
└── src
    └── index.php
```

# dev
```
./build.sh
./run.sh
```

# production
from dev box:
```
./deploy.sh
```
on all production machines:
```
./run.sh
```
