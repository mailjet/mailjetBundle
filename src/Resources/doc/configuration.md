# Configuration

You need to have MailJet account available

## config.yml

Define a configuration in your `config.yml`:

```yaml
welp_mailjet:
    api_key:    "%mailjet_api_key%"
    secret_key: "%mailjet_secret_key%"
    event_endpoint_route: app_event_endpoint_route # route name to handle the callback
    event_endpoint_token: "secretCode12345678" # secret to secure callback
    lists:
        1346789:
            contact_provider: 'yourapp.provider1'
        987456321:
            contact_provider: 'yourapp.provider2'
        ...
```
