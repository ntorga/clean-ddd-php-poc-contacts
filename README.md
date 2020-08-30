
# Contact Manager API (Clean Architecture & DDD POC with PHP 7.4+)
  
> The center of your application is not the database. Nor is it one or more of the frameworks you may be using. **The center of your application is the use cases of your application**  -  _Unclebob_ ([source](https://blog.8thlight.com/uncle-bob/2012/05/15/NODB.html "NODB"))  
  
[Clean architecture for the rest of us by Pusher](https://pusher.com/tutorials/clean-architecture-introduction) and [An Introduction to Domain-Driven Design by Khalil Stemmler](https://khalilstemmler.com/articles/domain-driven-design-intro/) are great introduction articles to understand the blend of concepts used in this project.  
   
 Soon I will be posting a series of articles on my [blog](https://ntorga.com) explaining every part of the code.  
 
 ## Disclaimer  
    
This API is **NOT** intended for a production environment. It is a **proof of concept** that does not meet traditional requirements in terms of availability nor scalability.  
    
It is an attempt to create a hybrid version between Clean and DDD, but **not all concepts were followed to the letter**. The idea is to comply with the [SOLID principles](https://scotch.io/bar-talk/s-o-l-i-d-the-first-five-principles-of-object-oriented-design) as much as possible, with a few exceptions to simplify the code.  
    
## Deploy  
  
The API uses the filesystem to store the contacts added, therefore make sure you create a `config` directory with an `.env` file containing this entry:  
```  
CONTACTS_DIR="/tmp/contacts"  
```  
  
Feel free to change the directory. As this is a proof of concept, when you stop the Docker containers, the storage will be wiped out. 
  
Speaking of Docker container, to deploy the API you just need to run `docker-compose up -d` to get the API running and answering on port 443.  
  
## Documentation  
  
The API documentation follows the [OpenAPI v3 specification](https://swagger.io/specification/) and you simply need to import the URL `https://github.com/ntorga/clean-ddd-php-poc-contacts/raw/master/openapi.json` on the [Swagger Online Editor](https://editor.swagger.io/) to get all details and try the API.  
  
## Contacts  
For any question or feedback feel free to contact me:  
* Email: northontorga _(plus)_ github _(at)_ gmail.com  
* Twitter: [@NorthonTorga](https://twitter.com/northontorga)  
* Linkedin: [Northon Torga](https://www.linkedin.com/in/ntorga/)