# Toggle bundle

# Feature Flag
System for checking whether account has feature flag enabled.

## FeatureFlagsSource
### implementations:
* `Landingi\ToggleBundle\FeatureFlagsSource\DbSource` -
  should use Landingi Read Only DB instance to fetch features from
  `accounts_features` table by account's UUID and from `packages_features` table
  by account's package.

* `Landingi\ToggleBundle\FeatureFlagsSource\RedisSource` - fetches feature
  flags list cached in Redis by account's UUID as a key.

* `Landingi\ToggleBundle\FeatureFlagsSource\CachingSource` - this class is
  an abstraction for caching feature flags list for account. See [Caching](#caching)
  section.

## Configuration
The bundle provides a configuration that allows you to easily control the data access layer.
Configuration file should be created at a path: `config/packages/landingi_toggle.yaml`.

```yaml
landingi_toggle:
    dbal:
        connection_name: mysql # DBAL connection name (this should be a read only connection, for a better performance)
    cache:
        enabled: true # If enabled then CachingSource is used, otherwise DbSource is used to fetch the feature flags
        redis_connection:
            schema: 'tcp'
            host: '%env(REDIS_HOST)%'
            port: 6379
        ttl: 60 # Time to leave for cached feature flags entries for a selected account_uuid
```
