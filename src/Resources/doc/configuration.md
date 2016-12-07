# Configuration

You need to have MailJet account available

## config.yml

Define a configuration in your `config.yml`:

```yaml
welp_mailjet:
    api_key:    "%mailjet_api_key%"
    secret_key: "%mailjet_secret_key%"
    # route name to handle the callback
    event_endpoint_route: app_event_endpoint_route
    # secret to secure callback
    event_endpoint_token: "secretCode12345678"
    lists:
        listId1:
            # provider used in full synchronization
            contact_provider: 'yourapp.provider1'
        listId2:
            contact_provider: 'yourapp.provider2'
        ...
```

Where `listIdX` is the list id of your MailJet lists, and `yourapp.providerX` is the key of your provider's service that will provide the contacts that need to be synchronized in MailJet. See the documentation on create [your own Contact provider](contact-provider.md).
