# concrete5 Nightcap

concrete5 Nightcap is a library that aims to make getting REST just a little bit easier. With Nightcap, developers can create PHP clients for their existing API layer; if you're a developer who wants to take their REST API and offer a PHP client for it, this is the library for you.

concrete5 Nightcap is **not**:

1. A REST Library – Nightcap uses [Guzzle 6 for that](http://docs.guzzlephp.org/en/stable/)
2. A REST Web Services library – Nightcap uses [Guzzle Services for that](https://github.com/guzzle/guzzle-services).
3. An OAuth2 Provider – Nightcap uses the [League OAuth2 Client for that](https://github.com/thephpleague/oauth2-client).

Instead, Nightcap is a way to glue all these different things together, providing a nice object-oriented layer around various OAuth2 grant types and authorization. Additionally, Nightcap gives you a way to define your web services easily, and offer extension as well. 

## Library Example

concrete5's PHP API client is built on Nightcap: it's probably the best place to start. 

[https://github.com/concrete5/concrete5_api_client](https://github.com/concrete5/concrete5_api_client)

### Using the Client 

Want to see how a developer queries the API? The test console application is a good place to start:

[https://github.com/aembler/concrete5_cli_api_example](https://github.com/aembler/concrete5_cli_api_example)
