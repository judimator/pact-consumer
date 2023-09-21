## Run consumer

```bash
$ docker-compose up
````

# PACT

- Run tests
```bash
$ ./vendor/bin/phpunit
```
- Find contract in `./pacts/fake-consumer-fake-provider.json`

### Publish contract

```bash
$ docker run --rm --network=host \
    -w /pacts \
    -v ./pacts:/pacts \
    pactfoundation/pact-cli:latest \
    publish /pacts/fake-consumer-fake-provider.json \
    --broker-base-url=http://localhost:8080 \
    --broker-username=username \
    --broker-password=password \
    --consumer-app-version=fake-git-sha-for-demo-123
```
