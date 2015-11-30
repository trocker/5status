# 5Status - Job tracking productivity app

5status is a project preaching a different way to handle your daily tasks. Instead of seeing all the cards of a team, you see/comment/prioritize cards assigned to you accross multiple mini teams. For example, your dashboard will contain cards from many different domains - personal and professional areas of your life such as:
  - Search feature from work (team - you, manager, your tech colleague etc.)
  - Plumber fixing pipers (team - you, property manager, and plumber)
  - Groceries (team - you and your wife)

The purpose of this is to track *all* your jobs in one place and assign/see their status-es. The name comes from your ability to assign one of the five statuses to your job:
  - Queued On
  - Doing By
  - Done By
  - Waiting On
  - Stopped By
  
You can see what priorities others have assigned to the job and their comments on the job. You can invite people to the job just by mentioning their email address. When they sign up, they'll see the card on their dashboard.

Many features are to be implemented in the future such as - ability to move the cards around, to make payments, tagging someone for the next action to be taken etc.

> The demo is available at 5status.com with the sample login of
> *someone@example.com* and *password* as password.

Please disregard the appearance of the seed data you see in there, I am still working on better-ing the code organization, once it is done, all will be sorted out!

### Version
0.0.5


### Code Organization

The REST APIs all are located in:
* [src/api/v1/*]

These REST APIs use wrappers from:
* [src/lib/wrappers/*]
 
These wrappers are trying to make the APIs independent of the functionality below, the same way any framework will try to, but in a much lighter way! No functions or methods in the wrappers which aren't being used by 5status!

Test cases are written in PHPUnit under:
* [tests/api/v1/*]

ReadMe will soon be changed when the test cases are solidified and committed.

### Tech

The first version of 5Status is supposed to achieve the basic functionality fast with a good code structure, and hence the decision to go with:

* [Bootstrap] - For the frontend
* [PHP (no frameworks)] - For the REST APIs
* [Nginx] - HTTP Server
* [Varnish] - Accelerator or Cache
* [MySQL] - DB
* [EC2] - For the 'cloud' part of it.
* [Docker] - Ofcourse!
* [jQuery] - duh

### Installation

You just need to:

```sh
$ 5status-install
```
Just kidding, automatic vagrant file soon to be published. Right now, its pretty much manual docker installation. Nginx docker from the docker hub works just fine.



