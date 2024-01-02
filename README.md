# Contact Manager API (Clean Architecture & DDD POC with PHP 8.3+)

> The center of your application is not the database. Nor is it one or more of the frameworks you may be using. **The center of your application is the use cases of your application**  -  _Unclebob_ ([source](https://blog.8thlight.com/uncle-bob/2012/05/15/NODB.html "NODB"))

[Clean architecture for the rest of us by Pusher](https://pusher.com/tutorials/clean-architecture-introduction) and [An Introduction to Domain-Driven Design by Khalil Stemmler](https://khalilstemmler.com/articles/domain-driven-design-intro/) are great introduction articles to understand the blend of concepts used in this project.  

This project has a series of articles explaining the concepts used in the code:

- [Introduction to Clean Architecture & Domain-Driven Design on PHP](https://ntorga.com/introduction-to-clean-architecture-and-domain-driven-design-on-php/)
- [The Domain Layer - Clean Architecture & Domain-Driven Design on PHP](https://ntorga.com/the-domain-layer-clean-architecture-and-domain-driven-design-on-php/)
- [The Presentation Layer - Clean Architecture & Domain-Driven Design on PHP](https://ntorga.com/the-presentation-layer-clean-architecture-and-domain-driven-design-on-php/)

## Disclaimer  

This API is **NOT** intended for a production environment. It is a **proof of concept** that does not meet traditional requirements in terms of availability nor scalability.

It is an attempt to create a light version of Clean Architecture, DDD, CQRS etc, but **not all concepts were followed to the letter**. The idea is to comply with the [SOLID principles](https://scotch.io/bar-talk/s-o-l-i-d-the-first-five-principles-of-object-oriented-design) as much as possible, with a few exceptions to simplify the code.

## Deploy  

1. Check the `config/.env.example` file and create a `.env` (on config directory) file with the same structure.

2. To create the container, run the following command:

```
podman build -t clean-ddd-php-poc-contacts .
```

You may use Docker instead of Podman. If you do, replace `podman` with `docker` in the commands below.

3. To run the container, run the following command:

```
podman run -d -p 8080:80 -t clean-ddd-php-poc-contacts
```

_Note: The API uses the filesystem to store the contacts added. As this is a proof of concept, when you stop the container, the storage will be wiped out._
  
## Documentation

The API documentation follows the [OpenAPI v3 specification](https://swagger.io/specification/).

### Generating the Documentation

To generate the documentation, you need to have composer and the dependencies installed. Then, run the following command:

```
vendor/bin/openapi --output src/Presentation/Api/swagger.json src/
```

You must run this command every time you update the controllers or the domain.

### Viewing the Documentation

The `src/Presentation/Api/swagger.json` file contains the documentation in the OpenAPI v3 specification.

To see the documentation, you can use any tool that supports this specification, such as the [Swagger Online Editor](https://editor.swagger.io/).

When using the Swagger Online Editor, you can import the `swagger.json` file by clicking on the `File` menu and then on `Import file`.

The swagger file is also available in the API itself. To see it, just access the `/swagger.json` endpoint.

## Contacts

For any question or feedback feel free to contact me:  
* Email: northontorga _(plus)_ github _(at)_ gmail.com  
* Twitter: [@NorthonTorga](https://twitter.com/northontorga)  
* Linkedin: [Northon Torga](https://www.linkedin.com/in/ntorga/)