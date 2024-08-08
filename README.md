![adobeflow](doc/_assets/adobe-flow-net-logo-long.png)

## About Leads Project

Leads is a web application to capture subscribers and provide API endpoints to retrive data,

Leads is built with followings software packages

- **[Laravel 11](https://vehikl.com/)**
- **Inertia**
- **Vue3, VueX**
- **Sanctum**
- **Passport**
- **Jetstream**
- **tailwindcss**
- **Flowbite**
- **Google Recaptcha**

> ### Application Status as of now
> 
> Is in prototype version <br>
> Encrypted database entries (built)<br>
> Homepage subscription form (built)<br>
> Token API Path (Partial 10%)<br>


> ### Docker container
>
> Docker container is attached to root under docker folder<br>
>> Install application in pathtoproject/www
>> <br>Isolate docker container pathtoproject/docker and run docker-compose in docker directory

> ### Run Laravel
>
> Change .env.catch to .env <br>
> add host file entry 127.0.0.1       catch.docker<br>
> Once docker is up and running migrate the database<br>
> Run Laravel commands<br>

> ### API Endpoints
>
> Leads have below API Endpoint. 
>
> GET /api/login <br>
> > API login
>
> POST /api/register <br>
> > API register<br>
> 
> GET /api/token <br>
> > Get API token with valid <br> Create new API token with valid
> 
> GET /api/leads/list <br>
> > Get leads available for you
>
> GET /api/leads/list/{id} <br>
> > Get lead by id
> 
> POST /api/leads/save/ <br>
> > Create new lead
> 
> GET /api/leads/ifavailable/{email} <br>
> > Check lead availability by email
> 
> POST /api/leads/delete/{id} <br>
> > delete lead by id

> ### Testing
> 
> Specific testing is not available at this stage, <br>
> Laravel basic tests for fortify is already available <br>
> Need to create below tests
> 
> > Unit testing (using PHP Unit)<br>
> > Integration testing<br>
> > API testing<br>
> > Development stage Browser Testing using selenium (Docker container is available)<br>
> > Production stage Browser Testing using BrowserStack Automated testing<br>
> > Penetration testing<br>
> > Load test with server<br>

> ### Coding Standards
> 
> Please use phpcode sniffer to validate coding standard
> Use default standard validation library packages

> ### Documentation
>
> For technical documentation, Leads use PHP documentor
> Please follow php standards, and run PHP documentor for API end point documentation
>
> [PHP Documentor](https://www.phpdoc.org/)

> ### Package
>
> Current status of the application is prototype
> Consider moving custom changes to laravel packages or create composer packages
