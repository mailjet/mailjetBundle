# Configuration

You need to have Mailjet account available

## config.yml

Define a configuration in your `config.yml`:

```yaml
mailjet:
    api_key:    "%mailjet.api_key%"
    secret_key: "%mailjet.secret_key%"
    call: true # (Default: true) - Performs the API call or not
    options:
        url: "api.mailjet.com" # (Default: api.mailjet.com) - domain name of the API
        version: "v3" # (Default: v3) - API version (only working for Mailjet API V3 +)
        call: true # (Default: true) - turns on(true) / off the call to the API
        secured: true # (Default: true) - turns on(true) / off the use of 'https'
    transactionnal:
        call: true #  (Default: true) - Performs the API call or not
        options:
            url: "api.mailjet.com" # (Default: api.mailjet.com) - domain name of the API
            version: "v3" # (Default: v3) - API version (only working for Mailjet API V3 +)
            call: true # (Default: true) - turns on(true) / off the call to the API
            secured: true # (Default: true) - turns on(true) / off the use of 'https'
    # route name to handle the callback, if you want to change it
    event_endpoint_route: app_event_endpoint_route
    # secret to secure callback
    event_endpoint_token: "secretCode12345678"
    lists:
        listId1:
            # provider used in full synchronization
            contact_provider: 'yourapp.provider1'
        listId2:
            contact_provider: 'yourapp.provider2'
        # ...
    contact_metadata:
        -
            name: firstname
            datatype: str
        -
            name: lastname
            datatype: str
        -
            name: postalcode
            datatype: int
        -
            name: rank
            datatype: int
        -
            name: hasavatar
            datatype: bool
        -
            name: lastlogin
            datatype: datetime
        -
            name: createdat
            datatype: datetime
        -
            name: birthdate
            datatype: datetime
        # ...

```

Where `listIdX` is the list id of your Mailjet lists, and `yourapp.providerX` is the key of your provider's service that will provide the contacts that need to be synchronized in Mailjet. See the documentation on create [your own Contact provider](contact-provider.md).

## Contact Metadata (Contact Properties)

* [Mailjet FAQ](https://app.mailjet.com/docs/manage_contact_lists#lists-contact-properties)
* [Mailjet Documentation](https://dev.mailjet.com/email-api/v3/contactmetadata/)

You can find all parameters in Mailjet documentation.

Example:

```yaml
contact_metadata:
    -
        name: firstname
        datatype: str
    -
        name: lastname
        datatype: str
    -
        name: organisation
        datatype: str
    -
        name: town
        datatype: str
    -
        name: postalcode
        datatype: int
    -
        name: gender
        datatype: str
    -
        name: rank
        datatype: int
    -
        name: hasavatar
        datatype: bool
    -
        name: lastlogin
        datatype: datetime
    -
        name: createdat
        datatype: datetime
    -
        name: birthdate
        datatype: datetime
```

Available datatype: `str, int, float, bool, datetime`
