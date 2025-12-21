# UPGRADE TO 5.2

**Note:** XML routing files are deprecated. While they continue to work for backwards compatibility,
you should migrate to YAML in your config/routes/oauth2.yaml file:

```yaml
# Old (deprecated, will trigger warnings):
resource: "@FOSOAuthServerBundle/Resources/config/routing/token.xml"

# New (recommended):
resource: "@FOSOAuthServerBundle/Resources/config/routing/token.yaml"
```

# UPGRADE TO 5.1

## BC BREAK: redirectUris and allowedGrantTypes are now json and not array anymore

This change were made to be doctrine/dbal v4 compliant.
Make sure to migrate you database schema.